<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Elearn_Controller extends CI_Controller{
        private  $url;
        private $smtpmail = true;
        protected $logged_user_id;
        function __construct(){
            parent::__construct();
            $this->url = ($this->uri->segment(1)) ? strtolower($this->uri->segment(1)) : "login";
            /*if($this->url!="signup" && $this->url!="validate" && $this->url!="userlist"){
                $this->load->model(array('businessowner_model','customer_model','service_model','staff_model'));
                $this->loginUser(); 
            }*/
        }
        
        // Check whether a user is logged in or not, based on it will redirect
        function loginUser(){
            $userdata = $this->session->userdata('business_in');
            $req_url = (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']!="" )?$_SERVER['REQUEST_URI']:'';
                if((!strpos($req_url,"trackingpaws/login")) && (!strpos($req_url,"trackingpaws/dashboard"))){
                    $this->session->set_userdata("requested_url",$req_url);
                }
            if(empty($userdata) || !isset($userdata['Login_id']) || in_array($userdata['Login_userstatus'],array('0'))){
                
                if($this->url != "login"){
                    redirect("login");
                }
            }
            else{
                $this->logged_user_id = $userdata['logged_user_id'];           
                if($userdata['Login_userrole']==3){
                    if($this->url == "staff" || $this->url == "login" || $this->url == "accounts" || $this->url =="schedule" || $this->url =="validate"){}
                    else{
                        redirect("staff/dashboard");
                    }
                }
                else if($userdata['Login_userrole']==4){
                    if($this->url == "customerrequest" || $this->url == "login" || $this->url=="customer" || $this->url =="schedule" || $this->url == "accounts" || $this->url =="validate"){}
                    else{
                        redirect("customer/dashboard");
                    }
                }
                else if($userdata['Login_userrole']==2){
                    $userId = $userdata['logged_user_id'];
                    $userinfo = $this->businessowner_model->getBusinessownerInfoByBoid($userId,true);
                    $customercount = $this->customer_model->getCustomerInfoByBoid($userId);
                    $servicecount = $this->service_model->getServiceInfoByBoid($userId);
                    $staffcount = $this->staff_model->getStaffInfoByBoid($userId);
                    //$staffcount = 0;
                    if(isset($userinfo['Bo_companyname']) && isset($userinfo['Bo_payment']) && ($customercount>0) && ($servicecount>0) && ($staffcount>0)){
                       if($this->url != "accounts" && $this->url != "businessowner" && $this->url != "csv" && $this->url != "customer" && $this->url != "customerrequest" && $this->url != "dashboard" &&
                               $this->url != "home" && $this->url != "invoice" && $this->url !="paws" && $this->url !="reports" && $this->url !="schedule" 
                               && $this->url !="signup" && $this->url !="staff" && $this->url !="userlist" && $this->url !="validate"  && $this->url !="welcome"){
                                redirect('dashboard');   
                       }
                        
                    }
                    else{
                        if($this->url != "accounts" && $this->url != "businessowner" && $this->url != "csv" && $this->url != "customer" && $this->url != "customerrequest" &&
                               $this->url != "home" && $this->url != "invoice" && $this->url !="paws" && $this->url !="reports" && $this->url != "setupdashboard" && $this->url !="schedule" 
                               && $this->url !="signup" && $this->url !="staff" && $this->url !="userlist" && $this->url !="validate"  && $this->url !="welcome"){
                                redirect('setupdashboard');
                            }
                        }
                    }
                else if($userdata['Login_userrole']==1) {
                    if($this->url != "accounts" && $this->url != "businessowner" && $this->url != "csv" && $this->url != "customer" && $this->url != "customerrequest" &&
                               $this->url != "home" && $this->url != "invoice" && $this->url !="paws" && $this->url !="reports" && $this->url !="schedule" 
                               && $this->url !="signup" && $this->url !="staff" && $this->url !="userlist" && $this->url !="validate"  && $this->url !="welcome" && $this->url !="admin"){  
                                redirect('admin/dashboard');   
                       }
                }
                
            }
        }
        // Check existance of valid data
        public function verifiedData($data){
            return (isset($data))?$data:'';
        }

        // Check existance of valid array
        public function verifiedArray($data){
            return (isset($data) && !empty($data))? $data:false;
        }
        public function checkValue($id,$controller,$message){
            if(isset($id) && ($id>0)){
                return true;
            }
            else{
                $this->session->set_flashdata('messages',$message);
                redirect($controller);
            }
        }
        public function sendEmail($to,$sub,$message)
        {
            $mail_temp_path = $this->config->item('mail_template');
            extract($message,EXTR_OVERWRITE);
            ob_start();
            include $mail_temp_path.'news-letter.php';
            $filecontents = ob_get_contents();
            if($this->smtpmail){
                $config = Array(
                  'protocol' => 'smtp',
                  'smtp_host' => 'ssl://smtp.googlemail.com',
                  'smtp_port' => 465,
                  'smtp_user' => 'pradeep.ps@fingent.com', // change it to yours
                  'smtp_pass' => 'fingent2014', // change it to yours
                  'mailtype' => 'html',
                  'charset' => 'iso-8859-1',
                  'wordwrap' => TRUE
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('pradeep.ps@fingent.com'); // change it to yours
                $this->email->to($to);// change it to yours
                $this->email->subject($sub);
                $this->email->message($filecontents);
                if($this->email->send())
                {
                     return true;
                }
                else
               {
                    return false;
                //show_error($this->email->print_debugger());
               }
            }
            else{
                $to      = $to;
                $subject = $sub;
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: Tracking Paws <info@trackingpaws.com>' . "\r\n";

                if(mail($to, $subject, $filecontents, $headers)){
                    return true;
                }
                else{
                    echo "mail not send";exit;
                    return false;
                }
                
            }
          
          
        }
        
         public function format_date($date)
         {
            $date = date('m-d-Y');
            $split = explode("-",$date);
            $new_string = $split[2]."-".$split[0]."-".$split[1];
            $new_date = date('Y-m-d',strtotime($new_string));
            return $new_date;
		 }
    }
?>
