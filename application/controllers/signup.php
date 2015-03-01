<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test_mukul
 *
 * @author user
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course extends Elearn_Controller {

    public function __construct() {

        parent::__construct();
        $this->controller = strtolower(__CLASS__);
        $this->load->model('Signup_model', 'signobj');
    }
    //put your code here
    public function index() { echo 1; exit;
        $message = array();
        $this->data                     = array();
          if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'First name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            //$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[bussinessowner_info.Bo_emailaddress]|');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if ($this->form_validation->run()   == true) {
                $user_array['Login_name']       = $this->input->post('email');
                $user_array['Login_userrole']   = 2;
                $user_array['Login_userparent'] = 1;
                $user_array['Login_dateofjoin'] = date('Y-m-d H:i:s'); 
                
                $result = $this->businessowner_model->addCustomer($user_array);
                $split_email                    = explode("@", $this->input->post('email'));
                $update_array['Login_password']   = md5($split_email[0].$result);
                $this->businessowner_model->updateCustomer($result,$update_array);
                
                
                if ($result != '') {
                    $user['Bo_loginid']         = $result;
                    $user['Bo_emailaddress']    = $this->input->post('email');
                    $user['Bo_firstname']       = $this->input->post('first_name');
                    $user['Bo_lastname']        = $this->input->post('last_name');
                    $result = $this->businessowner_model->addBusinessOwner($user);
                    
                    if ($result) {
                        $message['heading_para'] = 'Thanks for signing up with us!';
                        $message['content_para'] = '<tr>
                                                        <td align="center">
                                                            <h4 style="color: rgb(236, 96, 50); margin-bottom: 12px; margin-top: 10px; font-size: 25px;">Thanks for signing up with us!</h4>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding-left: 165px;">
                                                            <p style="color: rgb(79, 77, 77); margin-top: 0px; width: 600px; font-size: 16px;">Please wait until your account is been activated. You will receive the activation mail within 2-3 days.</p>          
                                                        </td>
                                                    </tr>';
                        $mail_result = $this->sendEmail($user['Bo_emailaddress'],"Sign up",$message);
                        $this->session->set_flashdata('success_message', 'Thanks for signing up with us! You will receive an email after approval.');
                        redirect(base_url('/signup'));
                    }else {
                        $this->session->set_flashdata('error_message', 'Something went wrong sorry for the inconvinience.');
                        redirect(base_url('/signup'));
                    }
                }
            }
        }

        $this->load->view('signup', $this->data);
    }

}

?>
