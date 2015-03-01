<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends Elearn_Controller {

     public function __construct() {

        parent::__construct();
        $this->controller = strtolower(__CLASS__);
        $this->load->model('Course_model', 'couobj');
    }
    //put your code here
    
    // Display login page and process login request
    function index() { echo "hi"; exit;
        if($this->input->post()){
            $this->form_validation->set_rules('email', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if($this->form_validation->run()){
				echo $this->input->post('email');
				echo $this->input->post('password');
                /*$userdata = $this->session->userdata('user_in');
                $req_url = $this->session->userdata('requested_url');
                if(isset($req_url) && $req_url!=""){
                    if($userdata['Login_userrole']==2){
                        $base = '/trackingpaws/';
                        $redirect = str_replace($base,'',$req_url);
                        redirect($redirect);
                    }
                }
                if($userdata['Login_userrole']==1){
                    redirect('admin/dashboard');
                } 
                redirect('dashboard');*/
            }
        }
        
        //$this->load->view('login');
        
    }
  
}	
?>