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

class Signin extends Elearn_Controller {

    public function __construct() {
        parent::__construct();
        $this->controller = strtolower(__CLASS__);
       	$this->load->model('Login_model', 'loginobj');
    }
    //put your code here
    function index(){
       if($this->input->post()){
	   		//$this->form_validation->set_rules('email', 'Username', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            //if($this->form_validation->run()){
                //$userdata = $this->session->userdata('business_in');
				$email =  $this->input->post('email');
				$password = $this->input->post('password');
				$usrdata = $this->loginobj->login($email,$password);
                                $usrdata[0]->course = $this->loginobj->user_enrolled_courses($usrdata[0]->stud_id);
                                $this->session->set_userdata('user_in', $usrdata);
				redirect('/course');
							//}	
	   }
    }
	
	function logout(){
        $this->session->unset_userdata('user_in');
        $this->session->sess_destroy();
        redirect("/course"); 
    }
}


