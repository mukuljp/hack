<?php

class Users extends  CI_Controller {

    function __construct() {	
        parent::__construct();
        $this->controller                                                       = strtolower(__CLASS__);
//        $segs                                                                   = $this->uri->uri_to_assoc();
//        $act                                                                    = isset($segs["act"]) ? $segs["act"] : $this->uri->segment(2);
//        $com_acts                                                               = array("register", "load_category", "ajax_states", "activation","unique_email","unique_email2","paypal_recurrent_payment_crone","google_checkout_response","ajax_check_login","check_login","users","email_uncsubscribe","benchmark_update_crone","BM_webhook_response","privacy_block","user_register_popup");
//        $user_acts                                                              = array("home","full", "advance","user_profile", "adv_edit","prof","change","info","post","del_image","adv_save_edit","user_like","another_prof","advance_register");
//		$user_login                                                    		 = $this->session->userdata('USER');
//		if(empty($user_login))
//		{
//			check_cookie();
//			$user_login = $this->session->userdata('USER');
//		}
//		 if(!empty($user_login) && $user_login['ID']!='')
//		{
//		    $this->user_id                =  $user_login['ID'];
//		    $this->level            	  =  $user_login['LEVEL'];
//		    $this->user_email            =  $user_login['Email'];
//		    $this->first_name          	  =  $user_login['FIRST_NAME'];
//		    $this->last_name          	  =  $user_login['LAST_NAME'];
//		    $this->prof_image          	  =  $user_login['USER_IMAGE'];
//		}	
//		else
//			$this->user_id 				=''; 
//		if (isset($act) && $act!='') {
//            if (in_array($act, $com_acts)) {
//                ;
//            } else if (in_array($act, $user_acts)) {
//				if (!isset($user_login) || $user_login['ID'] == "") {
//                    redirect('/users');
//                }
//            }
//        }
	
		$this->load->model('Users_model', 'usersobj');
		
    }

    function index() {

        $segs                   = $this->uri->uri_to_assoc();
        //print_r($segs); exit;
        if (!isset($segs["act"])) {
            $this->login();
        } else if ($segs["act"] == 'register') {
            $this->register();
        } else if ($segs["act"] == 'edit') {
			$user_login = $this->session->userdata('USER');
            $this->register($user_login['ID']);
        } else if ($segs["act"] == 'save') {
            $this->register_save($this->input->post('id'));
        } else if ($segs["act"] == 'advance') {
            if ($this->session->userdata('USER_UPGRADE_PLAN')) {
                $plan = $this->session->userdata('USER_UPGRADE_PLAN');
				if($plan['id'])
				{
					$id = $plan['id'];
					$this->advance_register($id);
				}else
				{
					  $this->session->set_userdata('VALIDATION_ERRORS', "<p>Please select any plan</p>");
					  redirect('/businessmodel');					  
				}	  
            }
            else
			{	
                redirect('/businessmodel');
			}	
        }else if ($segs["act"] == 'adv_edit') {
            $user_login = $this->session->userdata('USER');
            $this->advance_register($user_login['ID'], 'edit');
        } else if ($segs["act"] == 'adv_save') {
            $this->advance_register_save();
        } else if ($segs["act"] == 'prof') {
			//$this->session->unset_userdata('ANOTHER_USER');
            $this->user_profile();
        } else if ($segs["act"] == 'another_prof') {
            $this->user_profile($segs["id"]);
        } else if ($segs["act"] == 'change') {
            $this->change_password_save();
        } else if ($segs["act"] == 'activation') {
            $this->activation($segs["id"]);
        } else if ($segs["act"] == 'info') {
            $this->basic_information();
        } else if ($segs["act"] == 'twitter') {
            $this->twitter_register();
        } else if ($segs["act"] == 'fb') {
            $this->facebook_register();
        } else if ($segs["act"] == 'linkedin') {
            $this->linkedin_register();
        } else if ($segs["act"] == 'sol') {
            $this->my_solution();
        }else if ($segs["act"] == 'pro') {
            $this->my_product();
        }else if ($segs["act"] == 'soc') {
            $this->my_social_venture();
        }else if ($segs["act"] == 'favourite') {
            $this->my_favourites();
        }else if ($segs["act"] == 'prof_edit') {
            $this->profile_edit_save();
        }else if ($segs["act"] == 'deleteqn') {
            $this->delete_question($segs["id"]);
        }else if ($segs["act"] == 'del_image') {
            $this->del_image($segs["id"]);
        }else if ($segs["act"] == 'chg_pwd') {
            $this->change_password();
        }else if ($segs["act"] == 'del_atchmnt') {					
			$this->del_atchmnt($segs["atch_type"]);
		}else if ($segs["act"] == 'full') {					
			$this->user_profile_detail_view($segs["id"]);
		}else if ($segs["act"] == 'approve') {
			if(isset($segs['bymail']) && $segs['bymail']==1)
				$this->user_confirmation($segs['module_id'],$segs['user'],$segs['module'],$segs['owner'],'',$segs['bymail']);
			else
				$this->user_confirmation($segs['module_id'],$segs['user'],$segs['module'],$segs['owner']);
		}else if ($segs["act"] == 'disapprove') {
			if(isset($segs['bymail']) && $segs['bymail']==1)
				$this->user_confirmation($segs['module_id'],$segs['user'],$segs['module'],$segs['owner'],'Cancel',$segs['bymail']);
			else
				$this->user_confirmation($segs['module_id'],$segs['user'],$segs['module'],$segs['owner'],'Cancel');
		}else if ($segs["act"] == 'reg') {
			$this->user_register_popup();
		}else if ($segs["act"] == 'search') {
			$this->advanced_search();
		}
	}

    function register($id = "") {

        $this->load->model("users_model", "usersobj");
        $data['id']                                                             = $id;
        $data['action']                                                         = "users/index/act/save";
       	$data['home']	=1;
        $this->load->helper('form', 'url', 'html');
        //$this->load->view('header_home',$data);
        $this->load->view("home", $data);
       // $this->load->view('footer_home'); 
	   
    }

    function register_save($id = "") {
		 $this->load->library('form_validation');
        $this->load->model("users_model", "usersobj");
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
         $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]|min_length[6]');
        if ($id == "") {
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email|is_unique[user.email]');
			//$this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email');//only for excel insertion
        }
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
            $this->register();
        } else {
			$this->load->library('encrypt');
            $this->load->model("users_model");
              if ($id == "") {
             	$data['email']                                                  = $this->input->post('email');
				$data['password']                                            	= $this->encrypt->encode($this->input->post('password'));
				$data['verified']                                             	= 0;
				$data['published']                                             	= 1;
			 	$data['profile_update_date']									= date('Y-m-d h:i:s'); 
			 	$data['email_digest']											= 1; 
			 	$user_id                                                        = $this->users_model->insert_user($data);
				$enc_id                                                         = $this->encrypt->encode($user_id);
				if($user_id!='')
				{
					/* $soc_media_array                                          	= array(
																					'EMAIL'		=> $data['email']  ,
																					'PASSWORD'  => $this->input->post('password')
																				);
					$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
					$this->check_login(); */
					$this->load->library( 'email' );
					$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
					$this->email->to( $data['email']  );
					$this->email->subject( 'Verify your email account - CleanTekMarket' );
					$this->email->set_mailtype("html");
					$emaildata['message']='<p><h4>Welcome to CleanTek Market.</h4></p><br><p>Your username is : '.$data['email'].'</p><p>Your password is : '.$this->input->post('password').'</p><br><p>Please activate your account by clicking <a target="_blank" style="border:none;color:#0084b4;text-decoration:none;font-size:14px;font-weight:bold;font-family:' . 'Helvetica Neue' . ',Helvetica,Arial,sans-serif" href="' . base_url() . 'users/index/act/activation/id/' . $enc_id. '">here</a> or click the link below:</p><p><a target="_blank" style="border:none;color:#0084b4;text-decoration:none" href="' . base_url() . 'users/index/act/activation/id/' . $enc_id    . '">' . base_url() . 'users/index/act/activation/id/' . $enc_id    . '</a></p><br> <p>Thank you</p> <p>cleantekmarket.com</p>';
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send(); 
					
					/*<-- free registration for 1 year*/
					$plan["price"] 		= '';	
					$plan["plan_id"]	=  1;	
					$plan["free"]		=  1;	
					$this->session->set_userdata('USER_UPGRADE_PLAN',$plan);
					$this->user_id=$user_id ;
					$this->advance_register_save();
					$this->session->unset_userdata('USER');
					$this->user_id='';
					/* ---> */
					$this->session->set_userdata('VALIDATION_ERRORS','<p>Registration completed successfully.<br>
					Please check your email to complete the verification process.</p>');
					redirect();
					
				}
				else
				{
					$this->session->set_userdata('VALIDATION_ERRORS', '<p class="err">Email already existing</p>');
					redirect();	
				}	
				//-->
				

            } 
        }
    }

    function unique_username() {
        $username                                                               = $_POST['username'];
        //connect to database
        $this->load->model('Users_model', 'usersobj');
        $where['name']                                                          = $username;
        $count                                                                  = $this->usersobj->user_count($where);
        if ($count > 0) {
            //and we send 0 to the ajax request
            echo 0;
        } else {
            //else if it's not bigger then 0, then it's available '
            //and we send 1 to the ajax request
            echo 1;
        }
    }
	// for checking in excel file
	function unique_email2() {
		$email                                                                  = $_POST['email'];
		$emails																	= array();
		if(file_exists("images/db.csv")){
		  	$file		= fopen("images/db.csv", "r");
			while (($data2 = fgetcsv($file, 5000, ",")) != FALSE) {
				array_push($emails,trim($data2[0]));	
			}
			fclose($file); 
		
		}	
		if(in_array($email,$emails))
		{	
			echo 0;
		}else{
			echo 1;
		}
    }
    function unique_email() {
        $email                                                                  = $_POST['email'];
        //connect to database
        $this->load->model('Users_model', 'usersobj');
        $where['email']                                                         = $email;
        $count                                                                  = $this->usersobj->user_count($where);
        if ($count > 0) {
            //and we send 0 to the ajax request
            echo 0;
        } else {
            //else if it's not bigger then 0, then it's available '
            //and we send 1 to the ajax request
            echo 1;
        }
    }

    function login() {

		$user_login                                                     = $this->session->userdata('USER');
		if (isset($user_login) && $user_login['ID'] != "") { 
			$redirect_to                                                    = $this->session->userdata('USER_REFERRAL');
			if (isset($redirect_to) && !empty($redirect_to)) {                
                $this->session->unset_userdata('USER_REFERRAL');
                redirect($redirect_to);
            } else {
                //Go to private area
                redirect('users/index/act/prof', 'refresh');
            }
		
		}else
		{
		   $data['page_title']                                                     = 'User:Login';
			$data['base_url']                                                       = $this->config->item('base_url');
			$data['action']                                                         = 'users/check_login';
			$this->load->view('header', $data);
			$this->load->view("user_login", $data);			
		}	
    }

    function check_login() {

        $this->load->model('Users_model', 'usersobj');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
		$soc_media_user = $this->session->userdata("SOCIAL_MEDIA_USER");
		if(isset($soc_media_user) && $soc_media_user!=''){
			$_POST['password']= $soc_media_user['PASSWORD'];
			$_POST['email']= $soc_media_user['EMAIL'];
		}
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('VALIDATION_ERRORS',validation_errors());
            $this->login();
        } else {
			
            $redirect_to                                                    = $this->session->userdata('USER_REFERRAL');
			if (isset($redirect_to) && !empty($redirect_to)) {                
                $this->session->unset_userdata('USER_REFERRAL');
                redirect($redirect_to);
            } else {
                //Go to private area
                redirect('users/index/act/prof', 'refresh');
            }
        }
    }
	function ajax_check_login() {

        $this->load->model('Users_model', 'usersobj');
        $this->load->library('form_validation');
        $this->load->library('encrypt');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
           echo 1;
        }
    }

    function check_database($password) {
	if(isset($soc_media_user) && $soc_media_user!=''){
			$email = $soc_media_user['EMAIL'];
		}else
        $email                                                                  = $this->input->post('email');
	   $result                                                                 	= $this->usersobj->email_check($email);
	 
        if (!empty($result)) {
			$where['user_id']														= $result[0]->id;
			//$level_result                                                           = count($this->usersobj->get_user_level($where));
			$level_result                                                            = $this->usersobj->get_user_level($where);
			$sess_array                                                         = array();
			$level_array														= array();
            foreach ($result as $row) {
			                $db_password                                                    = $this->encrypt->decode($row->password);
			   if ($db_password == $password) {
                    if ($row->verified == 1) {
						if ($row->published == 1) {
							if( isset($level_result[0]->order_status) && $level_result[0]->order_status=='Active'){
								$level		=2;	
								$order_id	=$level_result[0]->order_id;
							}else
							{
								$level		=1;
								$order_id	='';
							}
							$sess_array                                             = array(
																						'ID'            => $row->id,
																						'USER_NAME'     => $row->username,
																						'FIRST_NAME'    => $row->first_name,
																						'LAST_NAME'    => $row->last_name,
																						'USER_IMAGE'    => $row->profile_picture,
																						'Email'			=> $row->email,
																						'LEVEL'			=>$level,
																						'ORDER_ID'		=>$order_id
																					);
							$this->session->set_userdata('USER', $sess_array);
							if($this->input->post('remember')==1)
							{
								
								$cookie = array(
									'name'   => 'user_email',
									'value'  => $row->email,
									'expire' => 60*60*24*7
								);
								$this->input->set_cookie($cookie);
								$cookie = array(
									'name'   => 'user_pwd',
									'value'  => $this->encrypt->encode($password),
									'expire' => 60*60*24*7
								);
								$this->input->set_cookie($cookie);
							}
							else
							{
								$this->load->helper('cookie');
								delete_cookie("user_email");
								delete_cookie("user_pwd");
							}							
							$data['is_login']= 1;
							$data['session_id']	=$this->session->userdata('session_id');
							//print_r($data);exit;
							$this->usersobj->update_user($row->id, $data);
						}else {
							$this->form_validation->set_message('check_database', 'Sorry! Your are not published');
							return false;
						}
                    } else {
                        $this->form_validation->set_message('check_database', 'Sorry! Your email verification is not completed. Please check your email to complete the verification process.');
                        return false;
                    }
                } else {
                    $this->form_validation->set_message('check_database', 'Invalid username or password');
                    return false;
                }
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    function forgot_password() {

        $data['page_title']                                                     = 'Users:forgotpassword';
        $data['base_url']                                                       = $this->config->item('base_url');
        $data['show_menu']                                                      = 0;
        $data['action']                                                         = 'users/check_email';
        $this->load->view('header', $data);
        $this->load->view("forgot_password", $data);
        $this->load->view('footer');
    }

    function check_email() {

        $this->load->model('Users_model', 'usersobj');
        $this->form_validation->set_rules('e_mail', 'E-mail', 'trim|required|valid_email|xss_clean|callback_check_database_email');
        if ($this->form_validation->run() == FALSE) {
            $this->forgot_password();
        } else {
            $data['display']                                                    = 1;
            $data['page_title']                                                 = 'User:forgotpassword';
            $data['base_url']                                                   = $this->config->item('base_url');
            $data['action']                                                     = 'users/check_email';
			$data['show_menu'] 													= 0; 
            $this->load->view('header', $data);
            $this->load->view("forgot_password", $data);
            $this->load->view('footer');
        }
    }

    function check_database_email($email) {
        $this->load->library('encrypt');
		$this->email->set_mailtype('html');
        $result                                                         = $this->usersobj->email_check($email);
	
		$password														= substr($email, 0, strpos($email, '@')).rand(1, 15);
		$data['password']												= $this->encrypt->encode($password);
		
       	
	   if ($result) {
			$this->usersobj->update_user( $result[0]->id, $data);
            $sess_array                                                         = array();
            foreach ($result as $row) {
             									
					$this->load->library( 'email' );
					$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
					$this->email->to($row->email);
					$this->email->subject( 'Password Recovery - CleanTekMarket' );
					$this->email->set_mailtype("html");
					$emaildata['message']="<p>Hi " . $row->first_name . " " . $row->last_name . ",".br(3) . "Email : " . $row->email . br(1)."Password : " . $password.br(2)."Thank you".br(1)."cleantekmarket.com</p>";
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send(); 
					
            }
            return true;
        } else {
            $this->form_validation->set_message('check_database_email', 'Email address could not be found');
            return false;
        }
    }

    function home() {

        $this->load->model('adverts_model', 'advertsobj');
        $data['page_title']                                                     = 'Users:Home';
        $data['base_url']                                                       = $this->config->item('base_url');
        $data['adv_res']                                                        = $this->advertsobj->get_adverts_pages('Investor Page');
        $this->load->view('header');
        $this->load->view("home", $data);
        //$this->load->view("facebook/login-facebook");
        $this->load->view('footer');
    }

     function facebook_login() {
	  $this->load->library('encrypt');
       /*  $fb_config                                                              = array(
                                                                                    'appId'     => '548056688611669',
                                                                                    'secret'    => '7cbd3ba4aeed5b217a369ad47adaddba'
                                                                                );
        $appId                                                                  = '548056688611669'; */ 
	 $fb_config                                                              = array(
                                                                                    'appId'     => '196567750529566',
                                                                                    'secret'    => '7f1a6c9d13e2ea0d5eb77608794968d8'
                                                                                );
        $appId                                                                  = '196567750529566'; 
        $this->load->library('Facebook', $fb_config);
        $this->load->model('Users_model', 'usersobj');
        //$user=0;
        $_SESSION['fb_' . $appId . '_user_id']                                  = '';
        $_SESSION['fb_' . $appId . '_access_token']                             = '';
		if(isset($_REQUEST['error']))
			redirect();
        $user                                                                   = $this->facebook->getUser();
	//	print_r($user);exit;
        if ($user) {
           // $data['user']                                                       = $user;
         //   echo $user;

            $auth_result                                                        = $this->usersobj->facebook_login_auth_key_check($user);
            if ($auth_result) {
				/* $data['success']											=1;
				$data['home']												=1;
				$this->load->view('header',$data);
				$this->load->view("home", $data);
				$this->load->view('footer'); */
				$soc_media_array                                             = array(
																					'EMAIL'			=> $auth_result[0]->email,
																					'PASSWORD'    	=> $this->encrypt->decode($auth_result[0]->password),
																				);
				$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
				$this->check_login();
				 
            } else {

                $user_profile                                                   = $this->facebook->api('/me');
              //print_r($user_profile);exit;
                $data['user_profile']                                           = $user_profile;
                //$data['username']                                               = $user_profile['username'];
                $data['first_name']                                             = $user_profile['first_name'];
                $data['last_name']                                              = $user_profile['last_name'];
                $data['user_type']                                              = 'general';
                $data['registered_via']                                         = 'facebook';
                $data['login_auth_key']                                         = $user_profile['id'];
                if (isset($user_profile['email'])) {
					 $user_email                                                     = $this->usersobj->email_check($user_profile['email']);
					 if($user_email)
					 {
						$this->session->set_userdata('VALIDATION_ERRORS','<p class="err">\''.$user_profile['email'].'\' is already existing.</p>');
						redirect('users/login');
					 }
                    $data['email']                                              = 	$user_profile['email'];
					$password													= 	substr($user_profile['email'], 0, strpos($user_profile['email'], '@')).rand(1, 15);
					$data['password']											=  	$this->encrypt->encode($password);
					$data['profile_update_date']								=	date('Y-m-d h:i:s'); 
					$data['verified']                                           = 1;
					$data['published']                                          = 1;
                    $user_id                                                     = 	$this->usersobj->insert_user($data);
					$enc_id                                                     = $this->encrypt->encode($user_id);
					$this->load->library( 'email' );
					$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
					$this->email->to ($user_profile['email']  );
					$this->email->subject( 'Registration completed successfully  - CleanTekMarket' );
					$this->email->set_mailtype("html");
					$emaildata['message']='<p><h4>Welcome to CleanTek Market.</h4></p><br><p>Your username is : '.$user_profile['email'].'</p><p>Your password is : '.$password.'</p><br> <p>Thank you</p> <p>CleanTekMarket.com</p>';
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send();
					$soc_media_array                                             = array(
																					'EMAIL'		=> $user_profile['email'],
																					'PASSWORD'  => $password
																					);
					$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
					/*<-- free registration for 1 year*/
					$plan["price"] 		= '';	
					$plan["plan_id"]	=  1;	
					$plan["free"]		=  1;	
					$this->session->set_userdata('USER_UPGRADE_PLAN',$plan);
					$this->user_id=$user_id ;
					$this->advance_register_save();
					$this->session->unset_userdata('USER');
					$this->user_id='';
					/* ---> */
					$this->check_login();
                } else {
                    $this->session->set_userdata("FB", $data);
                    $data['action']                                             = "users/index/act/fb";
                    $this->load->view('header');
                    $this->load->view("twitter_login_view", $data);
                    $this->load->view('footer');
                }
            }
        } else {

            //if ($user) {
            //$user=0;

            /* $data['logout_url'] = $this->facebook->getLogoutUrl();
              $_SESSION['fb_'.$appId.'_user_id'] = '';
              $_SESSION['fb_'.$appId.'_access_token'] = '';
              $this->load->view('main_index',$data); */
            $_SESSION['fb_' . $appId . '_user_id']                              = '';
            $_SESSION['fb_' . $appId . '_access_token']                         = '';
			$base_url=base_url();
			$params	= array('scope' => 'email',
							'redirect_uri'=> $base_url.'users/facebook_login'
			);
            $data['login_url']                                                  = $this->facebook->getLoginUrl($params);

            //$this->load->view('main_index', $data);
            redirect($data['login_url']);
        } /* else {

          } */
    }

    function facebook_register() {
		$this->load->library('encrypt');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email|is_unique[user.email]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
            $data['action']                                                     = "users/index/act/fb";
            $this->load->view('header');
            $this->load->view("twitter_login_view", $data);
            $this->load->view('footer');
        } else {
		
            $this->load->model("users_model");

            $content                                                            = $this->session->userdata('FB');
			
         //print_r($content);exit;
           // $content['email']                                                   = $this->input->post('email');
            if($content!=''){
			
				$content['email']                                                   = $this->input->post('email');
				$password1															= substr($content['email'], 0, strpos($content['email'], '@')).rand(1, 15);
				$password															=  $this->encrypt->encode($password1);
				//echo $password;
				$content['password']                                                = $password;
				$content['published']                                               = 1;
				$content['verified']           	                                    = 1;
				
				/* echo "<pre>";
				  print_r($content);
				  exit; */
				//$user=explode(' ', $content->name, 2);
				/* $data['first_name']			=$content['first_name'];
				  $data['last_name']			=$content['last_name'];

				  $data['login_auth_key']		=$content->id;
				  $data['registered_via']		=	'twitter';
				  $data['user_type']			='general';
				  $data['verified']			=1; */
				  //print_R($content);exit;
				  $content['profile_update_date']=date('Y-m-d h:i:s'); 
				  $user_id=$this->users_model->insert_user($content);
				  $enc_id                                                             = $this->encrypt->encode($user_id);
				  $this->load->library( 'email' );
					$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
					$this->email->to( $content['email']  );
					$this->email->subject( 'Registration completed successfully  - CleanTekMarket' );
					$this->email->set_mailtype("html");
					$emaildata['message']='<p><h4>Welcome to CleanTekMarket.</h4></p><br><p>Your username is : '.$content['email'] .'</p><p>Your password is : '.$password1.'</p><br> <p>Thank you</p> <p>CleanTekMarket.com</p>';
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send();
					/*<-- free registration for 1 year*/
					$plan["price"] 		= '';	
					$plan["plan_id"]	=  1;	
					$plan["free"]		=  1;	
					$this->session->set_userdata('USER_UPGRADE_PLAN',$plan);
					$this->user_id=$user_id ;
					$this->advance_register_save();
					$this->session->unset_userdata('USER');
					$this->user_id='';
					/* ---> */	
				//$this->session->unset_userdata('FB');
			}
			$soc_media_array                                            	= array(
																					'EMAIL'		=> $content['email'],
																					'PASSWORD'  => $password1,
																				);
			$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
			$this->check_login();
           /*  $data['success']=1;
			$data['home']	=1;
			$this->load->view('header',$data);
			$this->load->view("home", $data);
			$this->load->view('footer'); */
        }
    }

    function advance_register($id = '', $act = '',$cleantek_user_category='') {
		$selected_option = array();
		if($id!='')
		{
			$id=$this->user_id ;
		}
		if(!empty($act))
		{
			/* loading my products */
			$where['my_product']					=	1;
			$where['submitted']						=	$id;
			$this->load->model('product_model', 'prodobj');
			$product_res							= 	$this->prodobj->search_product('','',$where);
			$product_result						=	"";
			if($product_res){
				foreach($product_res as $raw){
					$catIds = $this->prodobj->getRelationalCategoryList($raw->product_id);
					$categories="";
					foreach ($catIds as $keycat=>$value)
					{
						$comma = "";
						if($keycat+1 != count($catIds))
							$comma = ", ";
						if($keycat<2)
						{	 
							$categories .= $value->categories_name.$comma;
						 }else{
							$categories .='...';
							break;
						}					
					}
					if(strlen($categories)>100){
						$categories = substr(strip_tags($categories), 0, 75); 
						$categories = substr($categories, 0, strrpos($categories, ", "))."....";		
					}
					if($raw->image != "" && file_exists('images/products/'.$raw->image)){
						$img_path=base_url().'images/products/'.$raw->image;
					}else{
						$img_path=base_url().'images/no_image.gif';
					 } 	
					if($raw->submitted_by==$this->user_id)
					{
						$action_btn='<div class="act_btn"><a title="Edit" href="'.base_url().'products/index/act/edit/id/'.$raw->id.'/type/'.$raw->type.'"><img src="'.base_url().'images/edit.png" alt=""></a>&nbsp;&nbsp;<a title="Delete" onclick="javascript:return confirm(\'Are you sure you want to delete this product?\')"href="'.base_url().'products/index/act/del/id/'.$raw->id.'/type/'.$raw->type.'"><img src="'.base_url().'images/delete.png" alt=""></a></div>';
					}else
					{
						$action_btn='';
					}
					if($raw->published==0)
					{
						$un_published=' <div class="un_published Approval pending">Pending Approval</div>';
						$opacity=0.4;
					}else
					{
						$un_published=' ';
						$opacity=1;
					}					
					$product_result.='<div class="productwrap">'.$action_btn.'
								'.$un_published.'
							  <div style="opacity:'.$opacity.'">		
							  <div class="thumbImg">
							   <a class="thumb" href="#"><img src="'.$img_path.'"></a>
							  </div>
							  <div class="itemInfo">
							  <ul><li>
							   <h2>'.$raw->title.'</h2></li>
							   <li><span class="category1">Category :&nbsp;</span>'.$categories .'</li>
							   <li><span class="location1">Location :&nbsp;</span>'.$raw->country_name.'</li>
							   </ul>
							   <input type="button" id='.$raw->id.' value="Details" class="prodDetails">
							  </div>
							  </div>
							 </div>';						
						
				}
			}	
			$data['product_result']=$product_result;
			/*Loaing my solutions*/
			$where['my_solution']					=	1;
			$this->load->model('Solution_model', 'solutionobj');
			$solution_res							= 	$this->solutionobj->search_solution('','',$where);
			$solution_result						=	"";
			if($solution_res){
				
				foreach($solution_res as $raw){
					$catIds = $this->solutionobj->getRelationalCategoryList($raw->id);
					$categories="";
					foreach ($catIds as $keycat=>$value)
					{
						$comma = "";
						if($keycat+1 != count($catIds))
							$comma = ", ";
						if($keycat<2)
						{	 
							$categories .= $value->categories_name.$comma;
						 }else{
							$categories .='...';
							break;
						}					
					}
					
					if($raw->image != "" && file_exists('images/solutions/'.$raw->image)){
						$img_path=base_url().'images/solutions/'.$raw->image;
					}else{
						$img_path=base_url().'images/no_image.gif';
					}
					if($raw->submitted_by==$this->user_id)
					{
						$action_btn='<div class="act_btn"><a href="'.base_url().'solutions/index/act/edit/id/'.$raw->id.'/type/'.$raw->type.'"><img src="'.base_url().'images/edit.png" alt=""></a>&nbsp;&nbsp;<a href="'.base_url().'solutions/index/act/del/id/'.$raw->id.'/type/'.$raw->type.'"><img src="'.base_url().'images/delete.png" alt=""></a></div>';
					}else
					{
						$action_btn='';
					}
					if($raw->published==0)
					{
						$un_published=' <div class="un_published Approval pending">Pending Approval</div>';
						$opacity=0.4;
					}else
					{
						$un_published=' ';
						$opacity=1;
					}			
					$solution_result.='<div class="productwrap">'.$action_btn.'
								'.$un_published.'
							  <div style="opacity:'.$opacity.'">
							  <div class="thumbImg">
							   <a class="thumb" href="#"><img src="'.$img_path.'"></a>
							  </div>
							  <div class="itemInfo">
							  <ul><li>
							   <h2>'.$raw->title.'</h2></li>
							   <li><span class="category1">Category :&nbsp;</span>'.$categories .'</li>
							   <li><span class="location1">Location :&nbsp;</span>'.$raw->country_name.'</li>
							   </ul>
							   <input type="button"  id='.$raw->id.' data-reveal-id="myModal"   value="Details" class="solnDetails">
							  </div>
							 </div></div>
							 ';				
							
						
				}
			}
			$data['solution_result']=$solution_result;
			/*loading favourite my favourite investors*/
			$wh['user_id']						=	$id;
			$wh['fav']			   				=	1;
			$wh["cleantek_user_category"]		= 'investor';
			$investor_res							= 	$this->usersobj->search_investor_advisor('','',$wh);
			$investor_result						=	"";
			if($investor_res){
			
				
				foreach($investor_res as $raw){
					$cleanteckCategoryIds       	=  	$this->usersobj->getRelationalCategoryList($raw->id);
					$categoryname="";
					foreach ($cleanteckCategoryIds as $keycat=>$value)
					{
						$categoryname .= $value->categories_name.', ';
					}
					$category_name=substr($categoryname,0,-2);
					if(strlen($category_name)>25){
						$category_name = substr(strip_tags($category_name), 0, 25); 
						if(strrpos($category_name, ", ")!='')
							$category_name = substr($category_name, 0, strrpos($category_name, ", "))."....";
						else
							$category_name = substr($category_name, 0, 25)."....";
					} 
					if($raw->profile_picture != "" && file_exists('images/profile_images/'.$raw->profile_picture)){
						$img_path=base_url().'images/profile_images/'.$raw->profile_picture;
					}else{
						$img_path=base_url().'images/profile_images/default_profile_image.gif';
					 } 
					$investor_result.='<div class="productwrap inv_adv_wrap">
					  <div class="thumbImg">
					   <a href="#" class="thumb"><img src="'.$img_path.'"></a>
					  </div>
					  <div class="itemInfo">
					  <ul><li>
					   <h2><a href="'.base_url().'users/index/act/another_prof/id/'.$raw->id.'">'.$raw->first_name." ".$raw->last_name.'</a></h2></li>
					   <li><span class="category1">Category :&nbsp;</span>'.$category_name.'</li>
					   <li><span class="location1">Industry :&nbsp;</span>'.$raw->industry.'</li>
					   <li><span class="location1">User Type :&nbsp;</span>'.$raw->user_type.'</li>
					   <li><span class="location1">User Category :&nbsp;</span>'.$raw->cleantek_user_category.'</li>
					   <li><span class="location1">Investor Category :&nbsp;</span>'.$raw->investor_category.'</li>
					   <li><span class="location1">Location :&nbsp;</span>'.$raw->country_name.'</li>
					   </ul>
					   <input type="button" id='.$raw->id.' class="invDetails" value="Details">
					  </div>
					 </div>
					';
					
				}
			}
			$data['investor_result']=$investor_result;	
			/*loading favourite my favourite advisors*/
			$wh['user_id']						=	$id;
			$wh['fav']			   				=	1;
			$wh["cleantek_user_category"]		= 'advisor';
			$advisor_res							= 	$this->usersobj->search_investor_advisor('','',$wh);
			$advisor_result						=	"";
			if($advisor_res){
			
				
				foreach($advisor_res as $raw){
					$cleanteckCategoryIds       	=  	$this->usersobj->getRelationalCategoryList($raw->id);
					$categoryname="";
					foreach ($cleanteckCategoryIds as $keycat=>$value)
					{
						$categoryname .= $value->categories_name.', ';
					}
					$category_name=substr($categoryname,0,-2);
					if(strlen($category_name)>25){
						$category_name = substr(strip_tags($category_name), 0, 25); 
						if(strrpos($category_name, ", ")!='')
							$category_name = substr($category_name, 0, strrpos($category_name, ", "))."....";
						else
							$category_name = substr($category_name, 0, 25)."....";
					} 
					if($raw->profile_picture != "" && file_exists('images/profile_images/'.$raw->profile_picture)){
						$img_path=base_url().'images/profile_images/'.$raw->profile_picture;
					}else{
						$img_path=base_url().'images/profile_images/default_profile_image.gif';
					 } 
					$advisor_result.='<div class="productwrap inv_adv_wrap">
					  <div class="thumbImg">
					   <a href="#" class="thumb"><img src="'.$img_path.'"></a>
					  </div>
					  <div class="itemInfo">
					  <ul><li>
					   <h2><a href="'.base_url().'users/index/act/another_prof/id/'.$raw->id.'">'.$raw->first_name." ".$raw->last_name.'</a></h2></li>
					   <li><span class="category1">Category :&nbsp;</span>'.$category_name.'</li>
					   <li><span class="location1">Industry :&nbsp;</span>'.$raw->industry.'</li>
					   <li><span class="location1">User Type :&nbsp;</span>'.$raw->user_type.'</li>
					   <li><span class="location1">User Category :&nbsp;</span>'.$raw->cleantek_user_category.'</li>
					   <li><span class="location1">Investor Category :&nbsp;</span>'.$raw->investor_category.'</li>
					   <li><span class="location1">Location :&nbsp;</span>'.$raw->country_name.'</li>
					   </ul>
					   <input type="button" id='.$raw->id.' class="advDetails" value="Details">
					  </div>
					 </div>
					';
					
				}
			}
			$data['advisor_result']=$advisor_result;
			/*loading my clusters*/
			$this->load->model('group_model', 'groupobj');
			$where	= array();
			$where["group_status"]			= "Active";
			$cluster_res						= 	$this->groupobj->get_mygroups($where,$id);
			$cluster_result						=	"";
			if($cluster_res){
				foreach($cluster_res as $raw){
					$cleanteckCategoryIds       	=  	$this->groupobj->getRelationalCategoryList($raw->group_id);
					$categoryname="";
					foreach ($cleanteckCategoryIds as $keycat=>$value)
					{
						$categoryname .= $value->categories_name.', ';
					}
					$category_name=substr($categoryname,0,-2);
					if(strlen($category_name)>25){
						$category_name = substr(strip_tags($category_name), 0, 25);
						if(strrpos($category_name, ", ")!='')
							$category_name = substr($category_name, 0, strrpos($category_name, ", "))."....";
						else
							$category_name = substr($category_name, 0, 25)."....";
					}
					$groupLogo=json_decode($raw->group_logo);
					if(isset($groupLogo->file_name) && $groupLogo->file_name!='' && $groupLogo->path_name!="" && file_exists("images/groups/".$groupLogo->path_name)){
						$img_path=base_url().'images/groups/'.$groupLogo->path_name;
					}else{
						$img_path=base_url().'images/no_image.gif';
					}
					$description = $raw->group_description;
					if (strlen($description) > 150) {
						$stringCut = substr($raw->group_description, 0, 150);
						// make sure it ends in a word so assassinate doesn't become ass...
						$description = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
					}
					if($raw->group_access==1)
						$groupState =  '<p class="Approval approved">Closed</p>';
					else
						$groupState = '<p class="Approval pending">Open</p>';
					$ts = strtotime(str_replace("-","/",$raw->cur_date)) - strtotime(str_replace("-","/",$raw->group_created_datetime));
					if($ts>31536000) $val = round($ts/31536000,0).' year';
					else if($ts>2419200) $val = round($ts/2419200,0).' month';
					else if($ts>604800) $val = round($ts/604800,0).' week';
					else if($ts>86400) $val = round($ts/86400,0).' day';
					else if($ts>3600) $val = round($ts/3600,0).' hour';
					else if($ts>60) $val = round($ts/60,0).' minute';
					else $val = round($ts).' second';
						
					if($val>1)
						$val .= 's';
					$val.= ' ago';
					
					if($raw->group_created_by==$id)
					{
						$action_btn='<div style="float:left;"><a title="Edit" href="'.base_url().'group/index/act/edit/group_id/'.$raw->group_id.'"><img src="'.base_url().'images/edit.png" alt=""></a>&nbsp;&nbsp;<a title="Delete" onclick="javascript:return confirm(\'Are you sure you want to delete this group?\')"href="'.base_url().'group/index/act/del/group_id/'.$raw->group_id.'"><img src="'.base_url().'images/delete.png" alt=""></a></div>';
					}else
					{
						$action_btn='';
					}
					
					$cluster_result.='<div class="feed">
							  <h3 style="padding-right:5px;"><a href="'.base_url().'group/index/act/full/id/'.$raw->group_id.'" class="grpname">'.$raw->group_name.'</a></h3>'.$action_btn.$groupState.'
							  	<div class="feedActivity">
							  		<img class="pro" style="width:102px;" src="'.$img_path.'">
							  		<p class="feedMessage mypostcluster">'.$description.'<br/>'.$categories.'</p>
							  	</div>
							  	<div class="feedActions">
							  		<div class="shareThis grpslidepan" id="slidepanel">
										<input type="text" placeholder="Enter the email id here" name="forward_email" id="forward_email" >
										<input type="submit" value="Forward"  class="btn_user_forward submit1" id="btn_user_forward2" />
							  			<input type="hidden" value="group" name="item_type">
							  			<input type="hidden" value="'.$raw->group_id.'" name="item_id">
							  			
										</div>
										<div class="email_check" id="email_check_action1"></div>
									<p class="time">'.$val.'</p>
							  	</div>
							 </div>';
						
				}
			}
			$data['cluster_result']=$cluster_result;
			
		}
		
        $i                                                                      = 0;
		$plan = $this->session->userdata('USER_UPGRADE_PLAN');		
		if($plan['price']==''&& $act=='')
		{
			$this->advance_register_save();
			
		}else{
			$data['plan_price']														=$plan['price'];
			$data['cat_id'] 														= array();
			$this->load->model('Users_model', 'usersobj');
			$this->load->model('Category_model', 'categorysobj');
			$data['user_res']                                                       = $this->usersobj->get($id);	
			
			if ($act == "")
				$data['action']                                                     = "users/index/act/adv_save";
			else {
			   // $data['action']                                                     = "users/index/act/adv_save_edit";
				$data['action']                                                     = "users/index/act/prof_edit";
				$data['act']                                                        = 'edit';
			}

			//loading categories
			$this->load->model('category_model', 'catobj');
			$data["catList"]        												=  $this->catobj->getDepthCategories();
			//@todo: get all cleanteck category
			$clnCategoryList       													=  $this->usersobj->getRelationalCategoryList($id);
			if(!empty($clnCategoryList)){
				foreach($clnCategoryList as $cat){
						$selected_option[]=$cat->clntek_cat_id;
				}
			}
			$data['cleanteckCategoryIds']											=	$clnCategoryList;
			
				$where['parent_id'] = array("-1");
				$par = array();
				$data['cat_res'][0]	= 	$this->catobj->get_categories("", "", $where, 'categories_name');
				if ($data['cat_res'][0]) {
					foreach ($data['cat_res'][0] as $cat) {
						if (in_array($cat->categories_id, $selected_option))
							$par[] = $cat->categories_id;
					}
				}
				$par2 = $data['cat_res'][1] = $data['cat_res'][2] = array();
				if (!empty($par)) {
					$where['parent_id'] = $par;
					$data['cat_res'][1]	= 	$this->catobj->get_categories("", "", $where, 'categories_name');
					if ($data['cat_res'][1]) {
						foreach ($data['cat_res'][1] as $cat) {
							if (in_array($cat->categories_id, $selected_option))
								$par2[] = $cat->categories_id;
						}
					}
					$where['parent_id'] = $par2;
					if (!empty($par2)) {
						$data['cat_res'][2] = 	$this->catobj->get_categories("", "", $where, 'categories_name');
					}
				}
				$data['selected_option']	=$selected_option;
			
			//loading funding stages
			$funding_stages['']                   	                                = '-----Select Funding Stage------';
			$funding_stages['General']                                       		 = 'General';
			$funding_stages['Seed Funding']                                         = 'Seed Funding';
			$funding_stages['Start-up']                                             = 'Start-up';
			$funding_stages['Growth']                                               = 'Growth';
			$funding_stages['Expansion']                                            = 'Expansion';
			$funding_stages['Exit']                                                 = 'Exit';
			$funding_stages['Others']                                               = 'Others';
			$data['funding_stages']                 	                        	= $funding_stages;
			//loading seeking options
			//$seeking['']                                                      		= 'Any Type';
			$seeking['Product']                                                   		= 'Product';
			$seeking['Advisor']                                                    		= 'Advisor';		
			$seeking['Solution']                                                   		= 'Solution';
			$data['seeking']                                                		= $seeking;
			//loading advisor categories
			$this->load->model('Users_model', 'usersobj');
			$advisor_res                                                            = $this->usersobj->load_advisor_categories();
			$advisor_categories['']                                                 = '-----Select Advisor Category------';
			if ($advisor_res) {
				foreach ($advisor_res as $advisor) {
					$advisor_categories[$advisor->id]                               = $advisor->advisor_category;
				}
			}
			$data['advisor_categories']                                             = $advisor_categories;
			//loading investor categories
			$this->load->model('Users_model', 'usersobj');
			$investor_res                                                           = $this->usersobj->load_investor_categories();
			$investor_categories['']                                                = '-----Select Investor Category------';
			if ($investor_res) {
				foreach ($investor_res as $investor) {
					$investor_categories[$investor->id]                             = $investor->investor_category;
				}
			}
			$data['investor_categories']                                            = $investor_categories;
			/* //loading profeesions
			$professions['']                                                        = '-----Select Profession------';
			$professions[1]                                                         = 'Profession 1';
			$data['professions']                                                    = $professions; */
			//loading industries
			$industries['']                                                         = '-----Select Industry------';
			$industries[1]                                                          = 'Industry 1';
			$data['industries']                                                     = $industries;
			//loading user types
			$user_types['']                                                         = '-----Select User Type------';
			$user_types['individual']                                               = 'Individual';
			$user_types['company']                                                  = 'Company';
			$user_types['government']                                               = 'Government';
			$data['user_types']                                                     = $user_types;
			//loading buudget range
			//$budget_ranges['']                                                      = '-----Select Investment Amount------';
			$start                                                                  = SOLUTION_BUDGET_START_RANGE;
			$end                                                                    = SOLUTION_BUDGET_END_RANGE;
			$interval 																= SOLUTION_BUDGET_RANGE_VALUE;
			for ($start; $start <= $end; $start = $start + $interval) {
					$budget_ranges[$start] = "$".number_format($start);
			}
			$data['budget_ranges']                                                  = $budget_ranges;
			//loading user categories
			$user_categories['']                                                    = '-----Select User Category------';
			$user_categories['general']                                             = 'General';
			$user_categories['advisor']                                             = 'Advisor';
			$user_categories['investor']                                            = 'Investor';
			$data['user_categories']                                                = $user_categories;
			//loading countries
			$this->load->model('users_model', 'userobj');
			$data['countries_res']                                                  = $this->userobj->get_country('', '');
			$countries['']                                                          = '-----Select Country------';
			foreach ($data['countries_res'] as $country) {
				$countries[$country->country_code]                                  = $country->country_name;
			}
			$data['countries']                                                      = $countries;
			for ($yr = date("Y"); $yr < (date("Y") + 10); $yr++) {
				$cc_yrs[$yr]                                                        = $yr;
			}
			for ($mn = 1; $mn < 13; $mn++) {
				$cc_mns[$mn]                                                        = date("F", mktime(0, 0, 0, $mn, 1, date("Y")));
			}
			global $cc_types;
			$ccs                                                                    = array_merge(array('' => '-----Select Credit Card Type------'), $cc_types);
			$data['ccs']                                                            = $ccs;
			$data['cc_yrs']                                                         = $cc_yrs;
			$data['cc_mns']                                                         = $cc_mns;
			$data['act']                                                            = $act;
			$data['level']                                                           = $this->level;
			$this->load->helper('form', 'url', 'html');
			
			$this->load->model('advisor_categorys_model', 'adv_catobj');
			$data["advisor_catList"]        			=  $this->adv_catobj->getAdvisorDepthCategories();
			//@todo: get all advisor category of user
			$advisorCategoryIds      					=  $this->adv_catobj->getRelationalCategoryList($id);
			$data["advisorCategoryIds"]     			=  $advisorCategoryIds;
			$this->load->view('header');
			if($act!='edit')
				$this->load->view("advance_registration_view", $data);
			else
			{
				$this->load->view("advance_registration_edit_view", $data);				
			}	
			  $this->load->view('footer');
		}
		
    }

    function load_category($id = '') {
        $cat_id                                                                 = 	$_POST['cat_id'];
        $this->load->model('Users_model', 'usersobj');
        $categories                                                             = 	$this->usersobj->load_categories($cat_id);
        $option                                                                 = 	'<option value="-2" selected="selected">----select category------</option>';
        if ($categories) {
            foreach ($categories as $category) {
                $option.='<option value="' . $category->categories_id . '">' . $category->categories_name . '</option>';
            }
            echo $option;
        }
        else
            echo 0;
    }

    function load_category_edit($id = '') {
        $cat_id                                                                 = 	$_POST['cat_id'];
        $par_id                                                                 = 	$_POST['par_id'];
        $this->load->model('Users_model', 'usersobj');
        $this->load->model('category_model', 'categorysobj');
        $categories                                                             = 	$this->usersobj->load_categories($par_id);
        $cat_res                                                                = 	$this->categorysobj->get($cat_id);
        if ($cat_res)
            $option                                                             = 	'<option value="-2">----select category------</option>';
        //else
        //	$option                                                         ='<option value="-1" selected="selected">----select category------</option>';
        if ($categories) {
            foreach ($categories as $category) {
                if ($category->categories_id == $cat_res->categories_id)
                    $option.='<option value="' . $cat_res->categories_id . '" selected="selected">' . $cat_res->categories_name . '</option>';
                else
                    $option.='<option value="' . $category->categories_id . '">' . $category->categories_name . '</option>';
            }
            echo $option;
        }
        else
            echo 0;
    }

    function ajax_states() {
        $country                                                                = 	$_POST['country'];
		if(isset($_POST['bill']))
			$bill																= 	$_POST['bill'];
		else
			$bill																= 	0;
        //$country='AU';
        $this->load->model('Users_model', 'usersobj');
        $states                                                                 =	 $this->usersobj->get_states($country);

        if ($states != null) {
			if($bill==0)
			{
				$select                                                         = 	"<select id='state'  name='state' class='ac_select'>
                                                                                        <option  value=''>-----Select State------</option>";
			}else{
				$select                                                         = 	"<select id='bill_state'  name='bill_state' class='ac_select'>
                                                                                        <option  value=''>-----Select State------</option>";																	
			}			
            foreach ($states as $state) {
                $select.="<option value=" . $state->state_code . ">" . $state->state_name . "</option>";
            }

            $select.="</select>";
            echo $select;
        } else {
            echo 0;
        }
    }

    function advance_register_save() {
		 if($this->user_id!='')
			$id							=	$this->user_id  ;
		else{
			redirect('users');
		}
		$payment_type														=	$this->input->post('payment_type');
		$USER_UPGRADE_PLAN                                             		= 	$this->session->userdata('USER_UPGRADE_PLAN');		
		if($USER_UPGRADE_PLAN["price"]=='')
		{
			//$this->load->model("users_model");
			//$this->users_model->update_user($id, $data);
			$this->load->model("Users_order_model");
			$bill_data['user_id']													= $id;
			$bill_data['payment_type']												= 'free';		
			$bill_data['transaction_id']											= '';		
			$bill_data['country']													= '';	
			$bill_data['state']														= '';	
			$bill_data['city']														= '';	
			$bill_data['street']													= '';	
			$bill_data['post_code']													= '';	
			$bill_data['phone']														= '';	
			$bill_data['order_status']												= 'Active' ;
			$order_id=$this->Users_order_model->insert_order($bill_data); 
			$this->load->model('businessfeature_model','bfobj');
			$plan_details=$this->bfobj->get_bussinessmodel_features($USER_UPGRADE_PLAN["plan_id"] );
			if(!empty($plan_details))
			{
				foreach($plan_details as $raw)
				{
					$plan_data['user_id']=$id;
					$plan_data['plan_title']=$raw->plan_title;
					$plan_data['plan_id']=$raw->businessmodel_id;
					$plan_data['planfeature_id']=$raw->planfeature_id;
					$plan_data['planfeature_title']=$raw->feature_title;
					$plan_data['business_feature_id']=$raw->businessfeature_id;
					$plan_data['feature_value']=$raw->businessfeatureval;
					$plan_data['order_id']=$order_id;
					$this->bfobj->insert_user_businessmodel($plan_data); 
				}
			}	
				
			$this->session->unset_userdata('USER_UPGRADE_PLAN');
			$this->session->unset_userdata('user_res');	
			
			if(isset($USER_UPGRADE_PLAN['free']) && $USER_UPGRADE_PLAN['free']!='')
				return 1;
			else{
				$this->session->set_userdata('VALIDATION_ERRORS','<p class="succ">Your advance registration completed successfully</p>');
				$user_login 															= $this->session->userdata('USER');
				$user_login['LEVEL']													= 2;
				$user_login['ORDER_ID']													= $order_id;
				$this->session->set_userdata('USER', $user_login);
				// to create the user logs <--
				 $this->load->model('logs_model', 'logsobj');
				 $user_login                                                    			= 	$this->session->userdata('USER');
				 $logs['user_id']															=	$user_login['ID'];
				 $logs['logs']																=	'Profile upgraded';
				 $logs['module']															= 	'prof';
				 $logs['item_id']															= 	$user_login['ID'];
				 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
				 $this->logsobj->insert_logs($logs);
				//-->
				redirect('users/index/act/prof');
			}	
		}
		
		
		if ($payment_type == "paypal_direct") {
			$this->form_validation->set_rules('cc_type', 'Credit Card Type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cc_number', 'Credit Card Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cc_year', 'Expiration Date', 'trim|required|xss_clean|callback_check_expiration_date');
			$this->form_validation->set_rules('cvv2', 'cvv2', 'trim|required|xss_clean');
		}
		if($USER_UPGRADE_PLAN["price"]>0)
		{
			$this->form_validation->set_rules('bill_country', 'Country name for billing', 'trim|required|xss_clean');
			$this->form_validation->set_rules('bill_state', 'State name for billing', 'trim|required|xss_clean');
			$this->form_validation->set_rules('bill_city', 'City name for billing', 'trim|required|xss_clean');
			$this->form_validation->set_rules('bill_street', 'Street name for billing', 'trim|required|xss_clean');
			$this->form_validation->set_rules('post_code', 'Post code', 'trim|required|xss_clean');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
		
		}	
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
             $this->advance_register($id);          
        }else{
			$user_login                                                     = $this->session->userdata('USER');
			if(isset($user_login['ID']) && ($user_login['ID']!=''))
			{
				$data['first_name']=$user_login['FIRST_NAME'];
				$data['last_name']=$user_login['LAST_NAME'];
				$data['email']=$user_login['Email'];
			}
			else
				redirect('users');
			if($USER_UPGRADE_PLAN["price"]>0)
			{		
				$paymentInfo['Order']['Amt']                                    = $USER_UPGRADE_PLAN["price"];
				$paymentInfo['Order']['period']                                 = $USER_UPGRADE_PLAN["period"];
				$paymentInfo['Order']['frequency']	                            = $USER_UPGRADE_PLAN["frequency"];
				$paymentInfo['Member']['first_name']                            = $data['first_name'];
				$paymentInfo['Member']['last_name']                             = $data['last_name'];
				$paymentInfo['Member']['country']                            	= $this->input->post('bill_country');
				$paymentInfo['Member']['state']                             	= $this->input->post('bill_state');
				$paymentInfo['Member']['city']                             		= $this->input->post('bill_city');
				$paymentInfo['Member']['street']                             	= $this->input->post('bill_street');
				$paymentInfo['Member']['post_code']                             = $this->input->post('post_code');
				$paymentInfo['Member']['phone']                             	= $this->input->post('phone');
				$paymentInfo['Member']['email']                                 = $data['email'];
				$paymentInfo['CreditCard']['credit_type']                       = $this->input->post('cc_type');
				$paymentInfo['CreditCard']['card_number']                       = $this->input->post('cc_number');
				$paymentInfo['CreditCard']['expiration_month']                  = $this->input->post('cc_mn');
				$paymentInfo['CreditCard']['expiration_year']                   = $this->input->post('cc_year');
				$paymentInfo['CreditCard']['cvv2']                  		 	= $this->input->post('cvv2');
				$paymentInfo['id']                                              = $id;
					$this->session->set_userdata('paymentInfo', $paymentInfo);	
					$errors='';						
					if ($payment_type == "paypal_direct") 
						$errors=$this->Do_direct_checkout();
					else if	($payment_type == "paypal_express") 
						$errors=$this->Set_express_checkout();
					else if	($payment_type == "google_checkout") 
					{
						$temp_data['first_name']			=	$data['first_name'];
						$temp_data['last_name']				=	$data['last_name'];
						$temp_data['email']					=	$data['email'];
						$temp_data['bill_country']			=	$this->input->post('bill_country');
						$temp_data['bill_state']			=	$this->input->post('bill_state');
						$temp_data['bill_city']				=	$this->input->post('bill_city');
						$temp_data['bill_street']			=	$this->input->post('bill_street');
						$temp_data['bill_postcode']			=	$this->input->post('post_code');
						$temp_data['bill_phone']			=	$this->input->post('phone');
						$temp_data['billing_period']		=	$USER_UPGRADE_PLAN["period"];
						$temp_data['amount']				=	$USER_UPGRADE_PLAN["price"];
						$temp_data['user_id']				=	$id;
						$temp_data['businessmodel_id']		=	$USER_UPGRADE_PLAN["plan_id"];
						$this->usersobj->insert_google_checkout_temp($temp_data);							
						$errors=$this->google_checkout();
					}	
					
					if($errors)	
					{
						 $this->session->set_userdata('VALIDATION_ERRORS', $errors);
						 $this->advance_register($id);
					}
						
			}
               
				
             	
		}
	}
	
	/*  function advance_register_next_save() {
		$id							=	 $this->user_id   ;
		$cleantek_user_category		=	$this->input->post('cleantek_user_category');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('experience[]', 'Experience', 'trim|numeric|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			  $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
			  $this->advance_register($id,'edit',$cleantek_user_category);		
			  
		}else{
		
			if($cleantek_user_category=='advisor')
			  {
				  $data['advisor_category']		=	$this->input->post('advisor_category');
				  $data['biodata']				=	$this->input->post('biodata');
				  $data['employment']			=	$this->input->post('employment');
				  $data['education']			=	$this->input->post('education');
				  $data['publication']			=	$this->input->post('publication');
				  $data['investor_category']	=	"";
				  $data['budget_range']			=	"";
				  $data['social_venture']		=	"";
				  $data['investment_prefernce']	=	"";
				  $clnCategoryList       		=  $this->usersobj->getRelationalCategoryList($id);
				  $experiences					=  $this->input->post('experience');
				  $i							= 0;	
				  foreach($clnCategoryList as $category)
				  {
					$this->usersobj->update_user_category_expereince($experiences[$i],$category->id);
					$i++;
				  }
				  
				
			  }
			  else if($cleantek_user_category=='investor')
			  {
				  $data['advisor_category']		=	"";
				  $data['biodata']				=	"";
				  $clnCategoryList       		=  $this->usersobj->getRelationalCategoryList($id);
				  $i							= 0;	
				  foreach($clnCategoryList as $category)
				  {
					
					$this->usersobj->update_user_category_expereince ('',$category->id);
					$i++;
				  }
				  $data['employment']			=	"";
				  $data['education']			=	"";
				  $data['publication']			=	"";
				  $data['investor_category']	=	$this->input->post('investor_category');
				  $data['budget_range']			=	$this->input->post('budget_range');
				  $data['investment_prefernce']	=	$this->input->post('investment_prefernce');
				  $data['social_venture']		=	$this->input->post('social_venture');
			  }else
			  {
				$data['advisor_category']		=	"";
				  $data['biodata']				=	"";
				  $clnCategoryList       		=  $this->usersobj->getRelationalCategoryList($id);
				  $i							= 0;	
				  foreach($clnCategoryList as $category)
				  {
					
					$this->usersobj->update_user_category_expereince ('',$category->id);
					$i++;
				  }
				  $data['employment']			=	"";
				  $data['education']			=	"";
				  $data['publication']			=	"";
				  $data['investor_category']	=	"";
				  $data['budget_range']			=	"";
				  $data['investment_prefernce']	=	"";
				  $data['social_venture']		=	"";
			  }
			$this->load->model('Users_model', 'usersobj');
			$this->usersobj->update_user($id, $data);
			redirect('users/index/act/prof');
		}	
	 } */
	function profile_edit_save()
	{
		if($this->user_id!='')
			$id							=	$this->user_id  ;
		else{
			redirect('users');
		}	
		$form						=	$this->input->post('form_type');
		
		if($form!='' && $form=='picture')
		{	
			if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["name"]!="" && ($_FILES["profile_picture"]["name"]!=$this->input->post('profile_picture_old')))
				$this->form_validation->set_rules('profile_picture', 'Profile picture', 'trim|xss_clean|callback_check_image');
			else
				$this->form_validation->set_rules('profile_picture', 'Profile picture', 'trim|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
				//$this->advance_register($id, 'edit');
				redirect('users/advance_register/'.$id.'/edit')	;
			}else{
	/* 			if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["name"]!="" && $_FILES["profile_picture"]["name"]!=$this->input->post('profile_picture_old') && $this->input->post('profile_picture_old')!='' && file_exists('images/profile_images/'.$this->input->post('profile_picture_old')))
					unlink('images/profile_images/'.$this->input->post('profile_picture_old')); */

              if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["name"]!=""){
				 /*  $config['upload_path'] 	 	= 	'images/profile_images/';
				  $config['allowed_types'] 	=   'gif|jpg|png|jpeg';
				  $config['max_size']		 	= 	'2000000';
				  $file=$config['file_name']	=	str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["profile_picture"]["name"]);
				  
				  $this->load->library('upload', $config);
				  $this->upload->initialize($config);
				  $this->upload->do_upload('profile_picture'); */
					$image_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["profile_picture"]["name"]);
					$config['image_library'] = 'gd2';
					$config['source_image'] = $_FILES["profile_picture"]["tmp_name"];
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 300;
					$config['height'] = 300;									  
					$config['new_image']="images/profile_images/".$image_name;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$data['profile_picture']		=	$image_name;
					 // to create the user logs <--
					 $user_login                                                    			= 	$this->session->userdata('USER');
					 $this->load->model('logs_model', 'logsobj');
					 $logs['user_id']															=	$id;
					 $logs['logs']																=	'changed profile picture';
					 $logs['module']															= 	'prof';
					 $logs['item_id']															= 	$id;
					 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
					 $logs['profile_image']														= 	$data['profile_picture'];
					 $this->logsobj->insert_logs($logs);
					//-->
					/*<-- changing login seesion details*/
					$user_login 															= $this->session->userdata('USER');
					$user_login['USER_IMAGE']												= $image_name;					
					$this->session->set_userdata('USER', $user_login);
					/*-->*/
					
              }else if($this->input->post('profile_picture_old'))
				$data['profile_picture']			=	$this->input->post('profile_picture_old'); 
			
				$this->usersobj->update_user($id, $data);
			}
				
		}else if($form!='' && $form=='account' &&  $this->level==2)
		{
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
			/*  $old_email                                                              = 	$this->input->post('old_email');
			$email                                                                  = 	$this->input->post('email');		if ($old_email != $email)
				$this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email|is_unique[user.email]');
			else
				$this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email');
			*/
			$this->form_validation->set_rules('cleantek_user_category', 'User Category', 'trim|required|xss_clean');
			$user_type                     = 	$this->input->post('user_type');
			if ($user_type == 'company' || $user_type == 'government') {
				$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('company_location', 'Company Location', 'trim|required|xss_clean');
			}
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
				//$this->advance_register($id, 'edit');
				redirect('users/advance_register/'.$id.'/edit')	;
			}else{
				/*<-- changing login seesion details*/
				$user_login 															= $this->session->userdata('USER');
				$user_login['FIRST_NAME']												= $this->input->post('first_name') ;
				$user_login['LAST_NAME']												= $this->input->post('last_name');
				$this->session->set_userdata('USER', $user_login);
				/*-->*/
				
				$user_res	=	$this->usersobj->get($id);
				if($user_res->email_digest!=$this->input->post('digest'))
				{
					if($this->input->post('digest')==1)
					{
						$this->email_subscribe($id,$user_res->email);
						$message="<ul class='alert_size'><li class='alert_width'>We have sent you an email that contains a confirm link. </li> <li class='alert_width'> Your subscription for email digest is not complete until you click the link in the email to verify your email address.</li><li class='alert_width'>If you don't receive the email check your spam or bulk mail folder to see if it was misfiled.</li></ul>";
						$this->session->set_userdata('ALERT_MESAAGE', $message);
					}	
					else
						$this->email_unsubscribe($user_res->email);
						
				}	
				
				$data['profile_update_date']										= date('Y-m-d h:i:s'); 
				$data['first_name']                                                = $this->input->post('first_name');
				$data['last_name']                                                  = $this->input->post('last_name');
				//$data['email']                                                      = $this->input->post('email');
				$data['user_type']                                                  = $this->input->post('user_type');
				if ($user_type == 'company' || $user_type == 'government' ) {
					$data['company_name']                                           = $this->input->post('company_name');
					$data['company_location']                                       = $this->input->post('company_location');
				} else {
					$data['company_name']                                           = "";
					$data['company_location']                                       = "";
				}
			//	$data['profession']                                              = $this->input->post('profession');
				$data['industry']                                                = $this->input->post('industry');
				$data['profile_description']                                     = $this->input->post('profile_description');
				$data['email_digest']                                            = $this->input->post('digest');
				$data['cleantek_user_category'] =$cleantek_user_category         = $this->input->post('cleantek_user_category');
				if($cleantek_user_category=='advisor')
			  {
				  $data['investor_category']	=	"";
				  $data['social_venture']		=	"";
				  $data['investment_prefernce']	=	"";
				   $data['funding_stage']		=	'';
				  $user_res                                                       = $this->usersobj->get($id);
				   $data['portfolio']			='';
				  if($id && file_exists('images/users/portfolio/'.$user_res->portfolio))
					unlink('images/users/portfolio/'.$user_res->portfolio);
				  $data['funding_specification']='';
				  if($id && file_exists('images/users/funding_specification/'.$user_res->funding_specification))
					unlink('images/users/funding_specification/'.$user_res->funding_specification);
				  $data['assumptions']			='';
				  if($id && file_exists('images/users/assumptions/'.$user_res->assumptions))
					unlink('images/users/assumptions/'.$user_res->assumptions);					  
				$data['market']					='';
			    $data['budget_range_start']		='';
			    $data['budget_range_end']		='';
			    $data['seeking']				='';
				/*change status to delete in benchmark crone table*/
					$this->load->model('bulk_message_model', 'bulkobj');
					$BM_data['need_delete']=1;
					$where['user_id']			=$id;
					$where['reference_module']	='investor';
					$where['reference_id']		=$id;						
					$this->bulkobj->update_benchmark($where,$BM_data);
					$where['reference_module']	='general';
					$this->bulkobj->update_benchmark($where,$BM_data);
				//-->	
				
			  }
			  else if($cleantek_user_category=='investor')
			  {
				  $user_res                                                       = $this->usersobj->get($id);
				  $data['publication']		='';
				  if($id && file_exists('images/users/publication/'.$user_res->publication))
					unlink('images/users/publication/'.$user_res->publication);	
				 $data['cv']			='';
				  if($id && file_exists('images/users/cv/'.$user_res->cv))
					unlink('images/users/cv/'.$user_res->cv);	
				  $data['terms']			='';
				  if($id && file_exists('images/users/terms/'.$user_res->terms))
					unlink('images/users/terms/'.$user_res->terms);	
					
				  $data['advisor_category']		=	"";
				  $data['biodata']				=	"";
				  $this->load->model('advisor_categorys_model', 'adv_catobj');
				  $clnCategoryList       		=  $this->adv_catobj->getRelationalCategoryList($id);
				  foreach($clnCategoryList as $category)
				  {
					$this->usersobj->delete_advisor_category ($category->id);					
				  }
				  $data['employment']			=	"";
				  $data['education']			=	"";
				   $data['expertise']			=	"";
				/*change status to delete  */
					$this->load->model('bulk_message_model', 'bulkobj');
					$BM_data['need_delete']=1;
					$where['user_id']			=$id;
					$where['reference_module']	='advisor';
					$where['reference_id']		=$id;						
					$this->bulkobj->update_benchmark($where,$BM_data);
					$where['reference_module']	='general';
					$this->bulkobj->update_benchmark($where,$BM_data);
				//-->	
				 
			  }else
			  {
				  $data['investor_category']	=	"";
				  $data['social_venture']		=	"";
				  $data['investment_prefernce']	=	"";	
				   $data['funding_stage']		=	"";
				  $user_res                                                       = $this->usersobj->get($id);
				   $data['portfolio']			='';
				  if($id && file_exists('images/users/portfolio/'.$user_res->portfolio))
					unlink('images/users/portfolio/'.$user_res->portfolio);
				  $data['funding_specification']='';
				  if($id && file_exists('images/users/funding_specification/'.$user_res->funding_specification))
					unlink('images/users/funding_specification/'.$user_res->funding_specification);
				  $data['restrictions']			='';
				  if($id && file_exists('images/users/restrictions/'.$user_res->restrictions))
					unlink('images/users/restrictions/'.$user_res->restrictions);
				  $data['assumptions']			='';
				  if($id && file_exists('images/users/assumptions/'.$user_res->assumptions))
					unlink('images/users/assumptions/'.$user_res->assumptions);	
				  $data['financial_summary']	='';
				 if($id && file_exists('images/users/financial_summary/'.$user_res->financial_summary))
					unlink('images/users/financial_summary/'.$user_res->financial_summary);	
				 $data['company_details']		='';
				 if($id && file_exists('images/users/company_details/'.$user_res->company_details))
					unlink('images/users/company_details/'.$user_res->company_details);
				$data['supplimentary_material']	='';
				if($id && file_exists('images/users/supplimentary_material/'.$user_res->supplimentary_material))
					unlink('images/users/supplimentary_material/'.$user_res->supplimentary_material);				
				 $data['publication']		='';
				  if($id && file_exists('images/users/publication/'.$user_res->publication))
					unlink('images/users/publication/'.$user_res->publication);	
				 $data['cv']			='';
				  if($id && file_exists('images/users/cv/'.$user_res->cv))
					unlink('images/users/cv/'.$user_res->cv);	
				  $data['terms']			='';
				  if($id && file_exists('images/users/terms/'.$user_res->terms))
					unlink('images/users/terms/'.$user_res->terms);		
					$data['market']					='';
					$data['budget_range_start']		='';
					$data['budget_range_end']		='';
					$data['seeking']				='';
				  $data['advisor_category']		=	"";
				  $data['biodata']				=	"";
				  $this->load->model('advisor_categorys_model', 'adv_catobj');
				  $clnCategoryList       		=  $this->adv_catobj->getRelationalCategoryList($id);
				  foreach($clnCategoryList as $category)
				  {
					$this->usersobj->delete_advisor_category ($category->id);					
				  }
				  $data['employment']			=	"";
				  $data['education']			=	"";
				  $data['expertise']			=	"";
				/*change status to delete  */
					$this->load->model('bulk_message_model', 'bulkobj');
					$BM_data['need_delete']=1;
					$where['user_id']			=$id;
					$where['reference_module']	='investor';
					$where['reference_id']		=$id;						
					$this->bulkobj->update_benchmark($where,$BM_data);
					$where['reference_module']	='advisor';
					$this->bulkobj->update_benchmark($where,$BM_data);
				//-->	
			  }
				$this->usersobj->update_user($id, $data);
				  // to create the user logs <--
				 $this->load->model('logs_model', 'logsobj');
				 $user_login                                                    			= 	$this->session->userdata('USER');
				 $logs['user_id']															=	$id;
				 $logs['logs']																=	'Changed account information';
				 $logs['module']															= 	'prof';
				 $logs['item_id']															= 	$id;
				 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
				 $this->logsobj->insert_logs($logs);
				//-->
				$this->load->model('category_model', 'categorysobj');
				$cat_select							=	$this->input->post('cat_select');
				$lev2_select						=	$this->input->post('lev2_select');
				$lev3_select						=	$this->input->post('lev3_select');
								
				if(!empty($cat_select) && (!empty($lev2_select[0]) && ($lev2_select[0]!='No Subcategories' || $lev2_select[0]!='')))
						$categoryIds = array_merge($cat_select,$lev2_select);
					else
						$categoryIds = $cat_select;
					if(!empty($categoryIds) && (!empty($lev3_select[0]) && ($lev3_select[0]!='No Subcategories' || $lev3_select[0]!='')))
						$categoryIds = array_merge($categoryIds,$lev3_select);
				//$categoryIds 			=  $this->input->post('clntek_cat_id');
				$catList 				= $this->usersobj->getRelationalCategoryList($id);
				$arrCatList 			= array();
				foreach($catList as $key=>$val)
				{
					$arrCatList[] = $val->clntek_cat_id;
				}
				foreach($arrCatList as $key=>$val)
				{
					if(!in_array($val,$categoryIds))
					{	
						$this->usersobj->delete_user_category($catList[$key]->id);
						/* //<--  delete contacts from email marketing list 
						$retval=$this->bmeapi->listDeleteEmailContact($catList[$key]->email_list_id,$old_email);
						
						if($retval){						
							//echo $retval;
						}	
						else
						{
							echo "\n\tCode=". $this->bmeapi->errorCode;
							echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
							//exit;
						}
						//--> */
						
						/*change status to delete  */
						$this->load->model('bulk_message_model', 'bulkobj');
						$BM_data['need_delete']=1;
						$where['user_id']			=$id;
						$where['reference_module']	='category';
						$where['reference_id']		=$val;						
						$this->bulkobj->update_benchmark($where,$BM_data);
						//-->
					}
				}
				if(!empty($categoryIds))
				{
					foreach($categoryIds as $key=>$val)
					{
						if(!in_array($val,$arrCatList))
						{
							$categoryList = array();
							$categoryList["user_id"] = $id;
							$categoryList["clntek_cat_id"] = $val;
							$this->usersobj->insert_user_category($categoryList);
							/* //<--  Add contacts to email marketing list 
							$this->load->model('category_model', 'catobj');
							$catList 				= $this->catobj->get($val);
							$details[0]["email"] 	= $email;
							$details[0]["firstname"]= $data['first_name'];	
							$details[0]["lastname"] = $data['last_name'];	
							$retval = $this->bmeapi->listAddContacts($catList->email_list_id, $details);						
							if($retval){						
								//echo $retval;
							}	
							else
							{
								
								echo "\n\tCode=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								//exit;
							}
							//--> */
						}
							
					}
				}
				$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">Account Information updated successfully</p><br><br>');
			}
		}else if($form!='' && $form=='address')
		{
			$data['profile_update_date']										= date('Y-m-d h:i:s'); 
			$data['country']                                                    = $this->input->post('country');
            $data['state']                                                      = $this->input->post('state');
            $data['city']                                                       = $this->input->post('city');
            $data['street']                                                     = $this->input->post('street');
            $data['postcode']                                                   = $this->input->post('postcode');
            $data['phone']                                                   	= $this->input->post('phone');
            $data['mobile']                                                   	= $this->input->post('mobile');
            $data['fax']                                                    	= $this->input->post('fax');
			$this->usersobj->update_user($id, $data);
			 // to create the user logs <--
			 $this->load->model('logs_model', 'logsobj');
			 $user_login                                                    			= 	$this->session->userdata('USER');
			 $logs['user_id']															=	$id;
			 $logs['logs']																=	'Changed address information';
			 $logs['module']															= 	'prof';
			 $logs['item_id']															= 	$id;
			 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
			 $this->logsobj->insert_logs($logs);
			//-->
			$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">Address Information updated successfully</p><br><br>');
		}else if($form!='' && $form=='advisor' &&  $this->level==2)
		{
			$this->form_validation->set_rules('experience[]', 'Experience', 'trim|numeric|xss_clean');
			if ($this->form_validation->run() == FALSE) {
			  $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
			 // $this->advance_register($id, 'edit');	
			redirect('users/advance_register/'.$id.'/edit')	;
			  
			}else{
				 $data['advisor_category']		=	$this->input->post('advisor_category');
				  $data['biodata']				=	$this->input->post('biodata');
				  $data['employment']			=	$this->input->post('employment');
				  $data['education']			=	$this->input->post('education');				 
				  $data['expertise']			=	$this->input->post('expertise');
					if($_FILES["cv"]["name"])
					{
						$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["cv"]["name"]);
						move_uploaded_file($_FILES["cv"]["tmp_name"],"images/users/cv/".$attachmnet_name);
						$data['cv']		=json_encode(array("file_name"=>$_FILES["cv"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["cv"]["size"]));
						if($id && file_exists('images/users/cv/'.$this->input->post('cv_old')))
							unlink('images/users/cv/'.$this->input->post('cv_old'));
					}	
				  $this->usersobj->update_user($id, $data);
				   // to create the user logs <--
				 $this->load->model('logs_model', 'logsobj');
				 $user_login                                                    			= 	$this->session->userdata('USER');
				 $logs['user_id']															=	$id;
				 $logs['logs']																=	'Changed advisor information ';
				 $logs['module']															= 	'prof';
				 $logs['item_id']															= 	$id;
				 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
				 $this->logsobj->insert_logs($logs);
				//-->
				$this->load->model('advisor_categorys_model', 'adv_catobj');	  
				$advisor_categoryIds 					=  $this->input->post('advisor_cat_id');
				$catList 								= $this->adv_catobj->getRelationalCategoryList($id);
				
				$arrCatList 							= array();	  
				foreach($catList as $key=>$val)
				{
					$arrCatList[] = $val->advisor_cat_id;
				}
				//print_r($arrCatList );
				//print_r($advisor_categoryIds  );
				foreach($arrCatList as $key=>$val)
				{
					if(!in_array($val,$advisor_categoryIds))
					{	
						$this->usersobj->delete_advisor_category($catList[$key]->id);					
					}
				}
				foreach($advisor_categoryIds as $key=>$val)
				{
					
					if(!in_array($val,$arrCatList))
					{
						$categoryList = array();
						$categoryList["user_id"] = $id;
						$categoryList["advisor_cat_id"] = $val;					
						$this->usersobj->insert_advisor_category($categoryList);				
					}
						
				}
				 $advisorCategoryList       		=  $this->adv_catobj->getRelationalCategoryList($id);
				 $i							= 0;	
				
				  foreach($advisorCategoryList as $category)
				  {
					$this->usersobj->update_advisor_category_expereince( $this->input->post('experience_'.$category->advisor_cat_id),$category->id);
					$i++;
				  } 
			  
				$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">User updated successfully</p><br><br>');
			}
		}else if($form!='' && $form=='advisor_addtnl' &&  $this->level==2)
		{
			$this->form_validation->set_rules('experience[]', 'Experience', 'trim|numeric|xss_clean');
			if ($this->form_validation->run() == FALSE) {
			  $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
			 // $this->advance_register($id, 'edit');	
			redirect('users/advance_register/'.$id.'/edit')	;
			  
			}else{
				if($_FILES["publication"]["name"])
				{
					$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["publication"]["name"]);
					move_uploaded_file($_FILES["publication"]["tmp_name"],"images/users/publication/".$attachmnet_name);
					$data['publication']		=json_encode(array("file_name"=>$_FILES["publication"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["publication"]["size"]));
					if($id && file_exists('images/users/publication/'.$this->input->post('publication_old')))
						unlink('images/users/publication/'.$this->input->post('publication_old'));
				}				
				if($_FILES["restrictions"]["name"])
				{
					$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["restrictions"]["name"]);
					move_uploaded_file($_FILES["restrictions"]["tmp_name"],"images/users/restrictions/".$attachmnet_name);
					$data['restrictions']		=json_encode(array("file_name"=>$_FILES["restrictions"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["restrictions"]["size"]));
					if($id && file_exists('images/users/restrictions/'.$this->input->post('restrictions_old')))
						unlink('images/users/restrictions/'.$this->input->post('restrictions_old'));
				}
				if($_FILES["terms"]["name"])
				{
					$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["terms"]["name"]);
					move_uploaded_file($_FILES["terms"]["tmp_name"],"images/users/terms/".$attachmnet_name);
					$data['terms']		=json_encode(array("file_name"=>$_FILES["terms"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["terms"]["size"]));
					if($id && file_exists('images/users/terms/'.$this->input->post('terms_old')))
						unlink('images/users/terms/'.$this->input->post('terms_old'));
				}
				if($_FILES["financial_summary"]["name"])
				{
					$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["financial_summary"]["name"]);
					move_uploaded_file($_FILES["financial_summary"]["tmp_name"],"images/users/financial_summary/".$attachmnet_name);
					$data['financial_summary']		=json_encode(array("file_name"=>$_FILES["financial_summary"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["financial_summary"]["size"]));
					if($id && file_exists('images/users/financial_summary/'.$this->input->post('financial_summary_old')))
						unlink('images/users/financial_summary/'.$this->input->post('financial_summary_old'));
				}
				if($_FILES["company_details"]["name"])
				{
					$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["company_details"]["name"]);
					move_uploaded_file($_FILES["company_details"]["tmp_name"],"images/users/company_details/".$attachmnet_name);
					$data['company_details']		=json_encode(array("file_name"=>$_FILES["company_details"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["company_details"]["size"]));
					if($id && file_exists('images/users/company_details/'.$this->input->post('company_details_old')))
						unlink('images/users/company_details/'.$this->input->post('company_details_old'));
				}
				if($_FILES["supplimentary_material"]["name"])
				{
					$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["supplimentary_material"]["name"]);
					move_uploaded_file($_FILES["supplimentary_material"]["tmp_name"],"images/users/supplimentary_material/".$attachmnet_name);
					$data['supplimentary_material']		=json_encode(array("file_name"=>$_FILES["supplimentary_material"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["supplimentary_material"]["size"]));
					if($id && file_exists('images/users/supplimentary_material/'.$this->input->post('supplimentary_material_old')))
						unlink('images/users/supplimentary_material/'.$this->input->post('supplimentary_material_old'));
				}
				if(!empty($data))	
				{
					 $this->usersobj->update_user($id, $data);
					   // to create the user logs <--
					 $this->load->model('logs_model', 'logsobj');
					 $user_login                                                    			= 	$this->session->userdata('USER');
					 $logs['user_id']															=	$id;
					 $logs['logs']																=	'Changed advisor information ';
					 $logs['module']															= 	'prof';
					 $logs['item_id']															= 	$id;
					 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
					 $this->logsobj->insert_logs($logs);
					//-->
			
				  
					$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">User updated successfully</p><br><br>');
				}	
			}
		}else if($form!='' && $form=='investor' &&  $this->level==2)
		{
		
			  $data['investor_category']	=	$this->input->post('investor_category');
			  $data['funding_stage']		=	implode(",",$this->input->post('funding_stage'));
			 // $data['budget_range_start']	=	$this->input->post('budget_range_start');
			 // $data['budget_range_end']		=	$this->input->post('budget_range_end');
			  $data['investment_prefernce']	=	$this->input->post('investment_prefernce');
			  $data['social_venture']		=	$this->input->post('social_venture');
			  $this->usersobj->update_user($id, $data);
			   // to create the user logs <--
			 $this->load->model('logs_model', 'logsobj');
			 $user_login                                                    			= 	$this->session->userdata('USER');
			 $logs['user_id']															=	$id;
			 $logs['logs']																=	'Changed investor information';
			 $logs['module']															= 	'prof';
			 $logs['item_id']															= 	$id;
			 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
			 $this->logsobj->insert_logs($logs);
			//-->
			  $this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">User updated successfully</p><br><br>');
		}else if($form!='' && $form=='investor_addtnl' &&  $this->level==2)
		{
			if($_FILES["portfolio"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["portfolio"]["name"]);
				move_uploaded_file($_FILES["portfolio"]["tmp_name"],"images/users/portfolio/".$attachmnet_name);
				$data['portfolio']		=json_encode(array("file_name"=>$_FILES["portfolio"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["portfolio"]["size"]));
				if($id && file_exists('images/users/portfolio/'.$this->input->post('portfolio_old')))
					unlink('images/users/portfolio/'.$this->input->post('portfolio_old'));
			}
			if($_FILES["funding_specification"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["funding_specification"]["name"]);
				move_uploaded_file($_FILES["funding_specification"]["tmp_name"],"images/users/funding_specification/".$attachmnet_name);
				$data['funding_specification']		=json_encode(array("file_name"=>$_FILES["funding_specification"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["funding_specification"]["size"]));
				if($id && file_exists('images/users/funding_specification/'.$this->input->post('funding_specification_old')))
					unlink('images/users/funding_specification/'.$this->input->post('funding_specification_old'));
			}
			if($_FILES["restrictions"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["restrictions"]["name"]);
				move_uploaded_file($_FILES["restrictions"]["tmp_name"],"images/users/restrictions/".$attachmnet_name);
				$data['restrictions']		=json_encode(array("file_name"=>$_FILES["restrictions"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["restrictions"]["size"]));
				if($id && file_exists('images/users/restrictions/'.$this->input->post('restrictions_old')))
					unlink('images/users/restrictions/'.$this->input->post('restrictions_old'));
			}
			if($_FILES["assumptions"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["assumptions"]["name"]);
				move_uploaded_file($_FILES["assumptions"]["tmp_name"],"images/users/assumptions/".$attachmnet_name);
				$data['assumptions']		=json_encode(array("file_name"=>$_FILES["assumptions"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["assumptions"]["size"]));
				if($id && file_exists('images/users/assumptions/'.$this->input->post('assumptions_old')))
					unlink('images/users/assumptions/'.$this->input->post('assumptions_old'));
			}
			if($_FILES["financial_summary"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["financial_summary"]["name"]);
				move_uploaded_file($_FILES["financial_summary"]["tmp_name"],"images/users/financial_summary/".$attachmnet_name);
				$data['financial_summary']		=json_encode(array("file_name"=>$_FILES["financial_summary"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["financial_summary"]["size"]));
				if($id && file_exists('images/users/financial_summary/'.$this->input->post('financial_summary_old')))
					unlink('images/users/financial_summary/'.$this->input->post('financial_summary_old'));
			}
			if($_FILES["company_details"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["company_details"]["name"]);
				move_uploaded_file($_FILES["company_details"]["tmp_name"],"images/users/company_details/".$attachmnet_name);
				$data['company_details']		=json_encode(array("file_name"=>$_FILES["company_details"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["company_details"]["size"]));
				if($id && file_exists('images/users/company_details/'.$this->input->post('company_details_old')))
					unlink('images/users/company_details/'.$this->input->post('company_details_old'));
			}
			if($_FILES["supplimentary_material"]["name"])
			{
				$attachmnet_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["supplimentary_material"]["name"]);
				move_uploaded_file($_FILES["supplimentary_material"]["tmp_name"],"images/users/supplimentary_material/".$attachmnet_name);
				$data['supplimentary_material']		=json_encode(array("file_name"=>$_FILES["supplimentary_material"]["name"],'path_name'=>$attachmnet_name,"upload_date"=>microtime(true),"size"=>$_FILES["supplimentary_material"]["size"]));
				if($id && file_exists('images/users/supplimentary_material/'.$this->input->post('supplimentary_material_old')))
					unlink('images/users/supplimentary_material/'.$this->input->post('supplimentary_material_old'));
			}	
			if(!empty($data))	
			{
				  $this->usersobj->update_user($id, $data);
				   // to create the user logs <--
				 $this->load->model('logs_model', 'logsobj');
				 $user_login                                                    			= 	$this->session->userdata('USER');
				 $logs['user_id']															=	$id;
				 $logs['logs']																=	'Changed investor information';
				 $logs['module']															= 	'prof';
				 $logs['item_id']															= 	$id;
				 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
				 $this->logsobj->insert_logs($logs);
				//-->
				  $this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">User updated successfully</p><br><br>');
			} 
		}else if($form!='' && $form=='investor_seeking' && $this->level==2 ){
			$data['market']					=	implode(",",$this->input->post('market'));
			 $data['budget_range_start']	=	$this->input->post('budget_range_start');
			 $data['budget_range_end']		=	$this->input->post('budget_range_end');
			 $ar=$this->input->post('seeking');
			 $data['seeking']				=	implode(",",$this->input->post('seeking'));
			 $this->usersobj->update_user($id, $data);
			   // to create the user logs <--
			 $this->load->model('logs_model', 'logsobj');
			 $user_login                                                    			= 	$this->session->userdata('USER');
			 $logs['user_id']															=	$id;
			 $logs['logs']																=	'Changed investor seeking information';
			 $logs['module']															= 	'prof';
			 $logs['item_id']															= 	$id;
			 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
			 $this->logsobj->insert_logs($logs);
			//-->
			  $this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">User updated successfully</p><br><br>');
		}
		else if($form!='' && $form=='password')
		{
			 if($this->user_id!='')
				$id							=	$this->user_id  ;
			else{
				redirect('users');
			}
			
			$this->load->model('Users_model', 'usersobj');
			$this->load->library('encrypt');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('old_pwd', 'old password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('new_pwd', 'New Password', 'trim|required|xss_clean|min_length[6]');
			$this->form_validation->set_rules('conf_pwd', 'Confirm Password', 'trim|required|xss_clean|matches[new_pwd]|min_length[6]');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
				//$this->advance_register($id, 'edit');	
				redirect('users/advance_register/'.$id.'/edit')	;
			} else {  
			       
				$user_res	=	$this->usersobj->get($id );
				$old_pwd=$this->input->post('old_pwd');
				$new_pwd=$this->input->post('new_pwd');
				$db_pwd=$this->encrypt->decode($user_res->password);
				if($db_pwd==$old_pwd)
				{
					
					$data['password']=$this->encrypt->encode($new_pwd);
					$this->usersobj->update_user($id, $data);
					$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">Password changed successfully </p>');
					//$this->advance_register($id, 'edit');
					redirect('users/advance_register/'.$id.'/edit')	;	
					
				}else
				{
					$this->session->set_userdata('VALIDATION_ERRORS', '<p class="err">Invalid old password</p>');
					//$this->advance_register($id, 'edit');	
					redirect('users/advance_register/'.$id.'/edit')	;
				}
			}
		}else if($form!='' && $form=='form_privacy')
		{
			 if($this->user_id!='')
				$id							=	$this->user_id  ;
			else{
				redirect('users');
			}
			
			$this->form_validation->set_rules('privacy', 'Privacy', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
				//$this->advance_register($id, 'edit');	
				redirect('users/advance_register/'.$id.'/edit')	;
			} else {  
				$data['privacy']=$this->input->post('privacy');
				$this->usersobj->update_user($id, $data);
				$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">Privacy Settings updated successfully </p>');
				//$this->advance_register($id, 'edit');
				redirect('users/advance_register/'.$id.'/edit')	;	
			}
		}else if($form!='' && $form=='level_one_account')
		{
			 if($this->user_id!='')
				$id							=	$this->user_id  ;
			else{
				redirect('users');
			}
			
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
				//$this->advance_register($id, 'edit');	
				redirect('users/advance_register/'.$id.'/edit')	;
			} else {  
				/*<-- changing login seesion details*/
				$user_login 															= $this->session->userdata('USER');
				$user_login['FIRST_NAME']												= $this->input->post('first_name') ;
				$user_login['LAST_NAME']												= $this->input->post('last_name');
				$this->session->set_userdata('USER', $user_login);
				/*-->*/
				$user_res	=	$this->usersobj->get($id);
				if($user_res->email_digest!=$this->input->post('digest'))
				{
					if($this->input->post('digest')==1)
					{
						$this->email_subscribe($id,$user_res->email);
						$message="<ul class='alert_size'><li class='alert_width'>We have sent you an email that contains a confirm link. </li> <li class='alert_width'> Your subscription for email digest is not complete until you <u>click the link</u> in the email to verify your email address.</li><li class='alert_width'>If you don't receive the email check your spam or bulk mail folder to see if it was misfiled.</li></ul>";
						$this->session->set_userdata('ALERT_MESAAGE', $message);
					}	
					else
						$this->email_unsubscribe($user_res->email);
				}				
			    $data['first_name']         = $this->input->post('first_name');
				$data['last_name'] 	        = $this->input->post('last_name');
				$data['email_digest'] 	    = $this->input->post('digest');

				$this->usersobj->update_user($id, $data);
				 // to create the user logs <--
				 $this->load->model('logs_model', 'logsobj');
				 $logs['user_id']															=	$id;
				 $logs['logs']																=	'Changed account details';
				 $logs['module']															= 	'prof';
				 $logs['item_id']															= 	$id;
				 $logs['item_name']															= 	$user_login['FIRST_NAME']." ".$user_login['LAST_NAME'];
				 $this->logsobj->insert_logs($logs);
				//-->
				 $this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">User updated successfully</p><br><br>');
				
			}
		}
		
		//$this->advance_register($id, 'edit');	
		redirect('users/advance_register/'.$id.'/edit')	;
	}

    function check_image($field) {

        if (!$_FILES["profile_picture"]["name"] == '') {

            if (($_FILES["profile_picture"]["type"] == "image/gif")
                    || ($_FILES["profile_picture"]["type"] == "image/jpeg")
                    || ($_FILES["profile_picture"]["type"] == "image/pjpeg")
                    || ($_FILES["profile_picture"]["type"] == "image/png")
            ) {
                if ($_FILES["profile_picture"]["error"] > 0) {
                    $this->form_validation->set_message('check_image', 'Image upload error');
                    return false;
                } else {
                    if (file_exists('images/advert/' . $_FILES["profile_picture"]["name"])) {
                        $this->form_validation->set_message('check_image', 'Image name already existing');
                        return false;
                    } else {
                        return true;
                    }
                }
            } else {
                $this->form_validation->set_message('check_image', 'Invalid image type!....Please upload any jpg/jpeg/gif/png file');
                return false;
            }
        } else {
            $this->form_validation->set_message('check_image', 'Please select image');
            return false;
        }
    }

    

    function user_profile($id = "") {
		if($this->level==2 ||($this->level==1 && ($this->user_id==$id || $id==''))){
			$this->load->model('Users_model', 'usersobj');
			$data['page_title']                 = 	'User:Profile';
			$data['base_url']                   = 	$this->config->item('base_url');
			$user                               =	$this->session->userdata('USER');  
			$data['level']						=	$user['LEVEL'];
			$data['user_id']                    = 	$user['ID'];
			
			if ($id) {
				$userid                         = 	$id;
				$user_res                                                       = $this->usersobj->get($id);
				if($user_res->privacy=='private')
				{
					redirect('users/privacy_block');
				} 
				if($user_res->privacy=='connections')
				{
					$where['user_id']					=	$id;
					$where['status']					=	'Confirm';
					$where['module_user_id']			=	$this->user_id;
					$connected_users					=	$this->usersobj->check_connection($where);					
					if(empty($connected_users))
					{
						redirect('users/privacy_block');		
					}	
				} 
				
				/* $another_user_array             = array(
														'an_id'            => $id,
													);
				$this->session->set_userdata('ANOTHER_USER',$another_user_array); */
				
				
			} else {
			
				$userid                         = 	$user['ID'];
				
			}
			$data['banner_user_id']      		= $userid  ;
			
			$data['user_banner']				=	1;
			$where['user_id']					=	$user['ID'] ;
			//echo $where['user_id'];exit;
			//$user_res							=	$this->usersobj->get_user_profile($userid );
			
			//$data['user_res']			        = 	$user_res;
			//$clnCategoryList       				=   $this->usersobj->getRelationalCategoryList($userid );
			//$data['cleanteckCategoryIds']		=	$clnCategoryList;
			if($this->user_id==$userid){
				$where['user_id']				= $userid;
				$connected_users				=	$this->usersobj->get_connection($where);
				$connected_users_ids				=	array();
				$connected_users_ids[]				=	$userid;
				foreach($connected_users as $row){
					/* if($row->user_id!=$userid) */
						$connected_users_ids[]=$row->userid;
					/* else
						$connected_users_ids[]=$row->module_user_id; */
				}
				
				$connected_users_id_str				=	implode(',',$connected_users_ids);
				$connection_request_var				=	'';
			}else{
				$connected_users_id_str				=	 $userid;
				$connection_request_var				=    1;
			}
			$data["total_rows"]						= count($this->usersobj->recent_activity($connected_users_id_str,'','',$connection_request_var));
			$data["recs_per_page"]					= 	$this->recs_per_page;
			/*added new nimsha*/
			$data['user_image']						=	$this->prof_image;
			$this->load->view('header',$data);
			$this->load->view("user_profile", $data);
			$this->load->view('footer');
		}else if($this->level=='1'){
				$data['message']='Please upgrade your profile to view the full user details';
				$this->load->view('header', $data);
				$this->load->view("level_2_check",$data);
				$this->load->view('footer');
		}else{
			redirect('users');
		}	
    }
	 function load_recent_activity(){
			$id= $_POST['user_id'];
			$offset							=	$_POST['loaded_rows'];
			if($this->user_id==$id){
				$where['user_id']					=	$id;
				$connected_users					=	$this->usersobj->get_connection($where);
				$connected_users_ids				=	array();
				$connected_users_ids[]				=	$id;
				//print_R($connected_users);exit;
				foreach($connected_users as $row){
					//if($row->user_id!=$id)
						$connected_users_ids[]=$row->userid;
					/* else
						$connected_users_ids[]=$row->module_user_id; */
				}
				
				$connected_users_id_str				=	implode(',',$connected_users_ids);
				$connection_request_var				=	'';
			}else{
				$connected_users_id_str				=	 $id;
				$connection_request_var				=    1;
			}
			//$total_rows								=  	count($this->usersobj->recent_activity($connected_users_id_str));
			$recs_per_page							= 	$this->recs_per_page;
			$recent_act								=  	$this->usersobj->recent_activity($connected_users_id_str,$this->recs_per_page,$offset,$connection_request_var);
			//print_r($recent_act);exit;
			$where['user_id']						=	$this->user_id ;
			if(count($recent_act)>=1 && $recent_act[0]['logs']!=''){
				$i = 0;
				foreach($recent_act as $row){
					$recent_activity[$i]					= 	$row;
					if(isset($row['item_type']) && isset($row['item_id'])){
						$where['type']						=	$row['item_type'];
						$where['solution_id']				=	$row['item_id'];
						$where['user_logs_id']				=	$row['user_logs_id'];
						$res_like                 			= 	$this->usersobj->check_user_like($where);
						$res_fav                 			= 	$this->usersobj->check_user_favourite($where);
						if($res_like)
							$recent_activity[$i]['like_unlike']		=	1;
						else
							$recent_activity[$i]['like_unlike']		=	0;
						if($res_fav)
							$recent_activity[$i]['favourite']		=	1;
						else
							$recent_activity[$i]['favourite']		=	0;
					}
					$i++;
				}
			}
			$recent_act								=	isset($recent_activity)?$recent_activity:$recent_act;
	
	
		if(count($recent_act)>=1 && $recent_act[0]['logs']!=''){
		
			$i=0;
			/* $recent_result="<input type='hidden' value='".$total_rows."' name='total_rows'><input type='hidden' value='".$recs_per_page."' name='recs_per_page'>"; */
			$recent_result = '';
			foreach($recent_act as $recent){
				$i++;
				$img_path="images/profile_images/";
						
					if(file_exists($img_path.$recent['item_image']) && $recent['item_image']!=''){ 
						$prof_image='<img src="'.base_url().$img_path.$recent['item_image'].'" style="max-height:65px;max-width:65px;" class="pro">';
						$prof_image_dis='<img src="'.base_url().$img_path.$recent['item_image'].'" class="use3" border="0">';
					 }else{ 
						$prof_image='<img src="'.base_url().'images/profile_images/default_profile_image.gif" style="max-height:65px;max-width:65px;" class="pro">';
						$prof_image_dis='<img src="'.base_url().'images/profile_images/default_profile_image.gif" class="use3" border="0">';
					}
					if($this->user_id==$recent['user_id']) { 
						$user_name='<a href="'.base_url().'users/index/act/prof">'.$recent['first_name']." ".$recent['last_name'].' </a> ';
					}else{
						$user_name='<a href="'.base_url().'users/index/act/another_prof/id/'.$recent['user_id'].'">'. $recent['first_name']." ".$recent['last_name'] .'</a>';
					} 
					$ts = strtotime(str_replace("-","/",$recent['cur_date'])) - strtotime(str_replace("-","/",$recent['time']));
					if($ts>31536000) $val = round($ts/31536000,0).' year';
					else if($ts>2419200) $val = round($ts/2419200,0).' month';
					else if($ts>604800) $val = round($ts/604800,0).' week';
					else if($ts>86400) $val = round($ts/86400,0).' day';
					else if($ts>3600) $val = round($ts/3600,0).' hour';
					else if($ts>60) $val = round($ts/60,0).' minute';
					else $val = round($ts).' second';
					$activity_action='';
					 if(isset($recent['item_id']) && $recent['item_id']!=0){ 
						$item_desc_share = '';
						$item_name_share ='';
						$url ='';
						$activity_action.='<ul><li>';
									$item	= "";
									if(isset($recent['item_id']))
										$item = $recent['item_id'];
									else 
										$item = 0;
									if(isset($recent['item_type'])) 
										$item .= " ".$recent['item_type'];
									else  
										$item .= " "."0";
									if(isset($recent['user_logs_id'])) 
										$item .= " ".$recent['user_logs_id'];
									else  
										$item .= " "."0";
								
							$activity_action.='<a href="#" class="like_unlike" id="like" value="'.$item.'>" >';
							if(isset($recent['like_unlike']) && $recent['like_unlike']=="1") $activity_action.='Unlike';
							else 
							$activity_action.='Like';
							$activity_action.='</a>
							</li>
							<li>';
							$style = "";
							if(isset($recent['favourite']) && $recent['favourite']=="1") {
								$style	=	"color:blue";
								$text_var	=	"Favourite";
							} else {
								$style	=	"color:rgb(141, 141, 141)";
								$text_var	=	"Favourite";
							}
							$activity_action.='<a href="#" class="user_favourite" id="user_favourite" style="'.$style.'" value="'.$item.'" >'.$text_var.'</a>
							</li>
							<li><a href="#" class="user_forward" id="user_forward"  >Share</a></li>';
							if(!empty($recent['item_id']) && ($recent['item_type']=='investor'||$recent['item_type']=='advisor'||$recent['item_type']=='general')){ 
								$url		=	base_url().'users/index/act/another_prof/id/'.$recent['item_id'];
								$item_desc_share = "Shared a profile";
								if($recent['item_name']=='')
									$item_name_share = '';
								else
									$item_name_share = $recent['item_name'];
								 
							}else if(empty($recent['item_id']) && ($recent['item_type']=='investor'||$recent['item_type']=='advisor'||$recent['item_type']=='general')){ 
								 $url       =   base_url().'users/index/act/another_prof/id/'.$recent['user_id'];
								 $item_name_share = $recent['first_name']." ".$recent['last_name'];
								 $item_desc_share = "Shared a profile";
							} else if(!empty($recent['item_id'])) {
								if($recent['item_type']=='discussion'){
									$wh['id']		=	$recent['item_id'];
									$dis_res 		=   $this->usersobj->get_discussion($wh);
									$url_sh		=	'';
									if($dis_res){
										$u_id			=	$dis_res->created_by;	
										if($u_id)
											$url_sh			=    base_url().'users/index/act/another_prof/id/'.$u_id;
										
											
									}
									$item_name_sh 	= $recent['first_name']." ".$recent['last_name'];
									
									$addthis_disc   =   addthis_share($item_name_sh,'Shared a discussion',"list",$url_sh);
								}else{
									$url   	=   base_url().$recent['item_type'].'/index/act/full/id/'.$recent['item_id'];
									$item_desc_share = "Shared a ".$recent['item_type'];
									if(isset($recent['item_name']))
										$item_name_share = $recent['item_name'];
								}
							}
							$activity_action.='<li>'.addthis_share($item_name_share,$item_desc_share,"list",$url).'</li>';
							$activity_action.='</ul>';
					 }
					 if($recent['item_type']!='discussion'){
							$share_action='<div class="shareThis" id="slidepanel" style="clear:both;">
							
							
							<input type="text" placeholder="Enter the email id here" name="forward_email" id="forward_email" onfocus="if(this.value==this.defaultValue) this.value=\'\';" onBlur="if(this.value==\'\') this.value=this.defaultValue;">
							<input type="submit" value="Forward"  class="btn_user_forward submit1" id="btn_user_forward" />
							
							';
							$item_id = isset($recent['item_id'])?$recent['item_id']:'' ;
							$item_type = isset($recent['item_type'])?$recent['item_type']:'' ;
							$logs_id = isset($recent['user_logs_id'])?$recent['user_logs_id']:'' ;
							$share_action.='<input type="hidden" name="item_type" value="'.$item_type.'" />
							<input type="hidden" name="item_id" value="'.$item_id.'" />
						</div>
					 
						<div class = "email_check" id="email_check"></div>';
					}else{
						$share_action='<div class="shareThis" id="slidepanel" style="clear:both;width:100%;">
						
						
						<input type="text" placeholder="Enter the email id here" name="forward_email" id="forward_email" style="width:62%;" onfocus="if(this.value==this.defaultValue) this.value=\'\';" onBlur="if(this.value==\'\') this.value=this.defaultValue;">
						<input type="submit" value="Forward"  class="btn_user_forward submit1" id="btn_user_forward" style="margin-top:10px;margin-right:7px;float:right;" />
						
						';
						$item_id = isset($recent['item_id'])?$recent['item_id']:'' ;
						$item_type = isset($recent['item_type'])?$recent['item_type']:'' ;
						$logs_id = isset($recent['user_logs_id'])?$recent['user_logs_id']:'' ;
						$share_action.='<input type="hidden" name="item_type" value="'.$item_type.'" />
						<input type="hidden" name="item_id" value="'.$item_id.'" />
					</div>
				 
					<div class = "email_check" id="email_check"></div>';
				}
					$activity_action.=$share_action;
					
					if(isset($recent['item_type']) && $recent['item_type']!='discussion'){
						if((!empty($recent['item_id']) && $id==$recent['user_id'] && ($recent['item_type']=='investor'||$recent['item_type']=='advisor'||$recent['item_type']=='general'))|| $recent['item_type']=='solutions'||$recent['item_type']=='products'||$recent['item_type']=='group'){
							$recent_result.='
							<div class="feed">
								<div class="feedActivity">'.$prof_image.'<p class="">'.$user_name." ";
						
									$recent_result.='has '.strtolower($recent['logs']);
									if(!empty($recent['item_id']) && ($recent['item_type']=='investor'||$recent['item_type']=='advisor'||$recent['item_type']=='general')){ 
										$recent_result.='<a href="'.base_url().'users/index/act/another_prof/id/'.$recent['item_id'].'">';
										 if(isset($recent['item_name'])) $recent_result.= nbs(1).$recent['item_name'];  
									} else if(!empty($recent['item_id'])) {
											$recent_result.='<a href="'.base_url().$recent['item_type'].'/index/act/full/id/'.$recent['item_id'].'">';
											if(isset($recent['item_name']))
												$recent_result.=nbs(1).$recent['item_name']; 
									}else{ 
										$recent_result.=nbs(1).$recent['item_name'];
									}
									$recent_result.='</a>	  </p>';
									if(file_exists($img_path.$recent['old_profile_picture']) && $recent['old_profile_picture']!=''){ 
										$recent_result.='<img src="'.base_url().$img_path.$recent['old_profile_picture'].'" style="max-height:202px;max-width:202px;" class="pro">';
									} 
									$recent_result.='</div>
									 <div class="feedActions">'.$activity_action;
										$recent_result.='<p class="time">';
											if($val>1)
												$val .= 's';
											$recent_result.=$val.' ago
										</p>
									 </div>';
									$recent_result.='</div>';
					}
				} else  if(!empty($recent['item_id']) && ($recent['item_type']=='discussion')){ 
					 $extra	=	explode(',',$recent['extra']);
					 if(count($extra)==2){
						$dis_image = $extra[0];
						$visible 	= $extra[1];
					 }else{
						$visible		= $extra[0];
					 }
					
					 $discussion ='';
					 if($dis_image!='' || $recent['item_name']!=''){
						$discussion.='<div class="field1 profile2 post1 feeddis">'.$prof_image_dis.'<ul class="clusterMem"><li><p><span style="color: #0285B5;	font-weight: bold;	text-shadow: 0 0 1px #fff;font-size:13px;">'.$user_name.'</span><span style="font-weight:normal;"> has '.strtolower($recent['logs']).'</span></p></li><li>'.nl2br($recent['item_name']);
					if($recent['user_id']==$this->user_id){
						$discussion.='<a href="javascript:void(0)" name="Delete" title="Delete discussion" style="position:relative;float:right;"><img src="'.base_url().'images/deleteIcon2.jpg" border="0" class="delete2 del_dis" id="'.$item.'" ></a>';
					}
					$discussion.='</li>';
					if(file_exists('images/user_discussion/'.$dis_image) && $dis_image!=''){ 
						$discussion.='<li><img src="'.base_url().'images/user_discussion/'.$dis_image.'" style="max-height:202px;max-width:202px;" class="pro"></li>';
					} 
					if($val>1)
						$val .= 's';
					$wh['id']		=	$item_id;
					$dis_res 		=   $this->usersobj->get_discussion($wh);
					$u_id			=	 $dis_res->created_by;	
					$url			=    base_url().'users/index/act/another_prof/id/'.$u_id;
					$discussion.='<li class="likeThisdis">'.$val.' ago </li><li class="likeAct"><a href="#" title="favourite" class="user_favourite share2" id="user_favourite" style="'.$style.'" value="'.$item.'" >'.$text_var.'</a><span><a href="#" class="user_forward share2" id="user_forward" >Share</a></span>'.$addthis_disc.'</li>'.$share_action;
						//$recent_result.=$activity_action;
					//$recent_result.=' <li class="likeAct">'.$activity_action.'</li>';
					
					$where['parent_id']	= $recent['item_id'];
					
					$com_res = $this->usersobj->get_comments($where);
					if($com_res){
					foreach($com_res as $com){
						$item	= "";
						if($com->id)
							$item = $com->id;
						else 
							$item = 0;
						if(isset($recent['item_type'])) 
							$item .= " ".$recent['item_type'];
						else  
							$item .= " "."0";
						if($com->user_logs_id) 
							$item .= " ".$com->user_logs_id;
						else  
							$item .= " "."0";
						$ts_c = strtotime(str_replace("-","/",$recent['cur_date'])) - strtotime(str_replace("-","/",$com->modified_date));
						if($ts_c>31536000) $val = round($ts_c/31536000,0).' year';
						else if($ts_c>2419200) $val = round($ts_c/2419200,0).' month';
						else if($ts_c>604800) $val = round($ts_c/604800,0).' week';
						else if($ts_c>86400) $val = round($ts_c/86400,0).' day';
						else if($ts_c>3600) $val = round($ts_c/3600,0).' hour';
						else if($ts_c>60) $val = round($ts_c/60,0).' minute';
						else $val = round($ts_c).' second'; 
						if($val>1)
								$val .= 's';
							
						$discussion.='<li class="subComment3">';
						if($com->commented_by==$this->user_id){
							$discussion.='<a href="javascript:void(0)" name="Delete" title="Delete comment"><img src="'.base_url().'images/deleteIcon2.jpg" border="0" class="delete2 del_comment" id="'.$item.'" ></a>';
						}
						if(file_exists($img_path.$com->profile_picture) && $com->profile_picture!=''){ 
							$discussion.='<img src="'.base_url().$img_path.$com->profile_picture.'" class="use2" border="0">';
						 }else{ 
							$discussion.='<img src="'.base_url().'images/profile_images/default_profile_image.gif" class="use2" border="0">';
						}	
						$discussion.='<ul class="clusterMem"><li class="heading8">'.$com->first_name." ".$com->last_name.'</li><li>'.$com->description.'</li><li class="likeThisdis">'.$val.' ago</li></ul></li> ';
					}
					}
					$discussion.='	
					<li class="comment2">
					   <div class="field1 nComment3">
							<input type="hidden" id= "item_type" name="item_type" value="'.$item_type.'" />
							<input type="hidden" name="item_id" value="'.$item_id.'" />
							<input type="hidden" name="logs_id" value="'.$logs_id.'" />
							<textarea placeholder="Write a comment..." class="expand25-200 comment comment3" id ="discussion_comment" name="discussion_comment" style="overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>
					   </div>
					</li>
			
				</ul>
				</div>';
				$wh['id']				=	 $recent['item_id'];
				$get_disc               = 	 $this->usersobj->get_discussion($wh);
				if($get_disc)
					$created_by 			= $get_disc->created_by;
				if($visible=='private'){
					
					if($this->user_id==$created_by){
						$recent_result		.=	$discussion;
					}	
				 }else if($visible=='connections'){
					$where['user_id']					=	$id;
					$connected_users					=	$this->usersobj->get_connection($where);
					$connected_users_ids				=	array();
					$connected_users_ids[]				=	$id;
					foreach($connected_users as $row){
						$connected_users_ids[]=$row->userid;
					}
					if(in_array($this->user_id, $connected_users_ids)){
						$recent_result.=	$discussion;
					}	
				 }else{
					$recent_result.=	$discussion;
				 }
				 }
			}
		}
	}else if($recent_act[0]['first_name']){

		//if($total_rows==0){
			$recent_result='<div class="forward_validation">There is no activity for "'.$recent_act[0]['first_name']." ".$recent_act[0]['last_name'].'"</div>';
		//}
	}else
		$recent_result='';
	echo $recent_result;
	} 
	
	function del_comment(){
		$this->load->model('logs_model', 'logsobj');
		$where['id'] 		= $_POST['id'];
		$where['log_id'] 	= $_POST['logid'];
		//echo $where['id']." ".$where['log_id'];exit;
		if(isset($_POST['type']) && $_POST['type']=='discussion'){
			$this->usersobj->delete_comment($where);
			$data['status']  = 'deleted';
			$this->logsobj->update_log($data,$where['log_id']);
			echo 1;
			//update log
		}else{
			
			$dis_res = $this->usersobj->get_discussion($where);
			$where['parent_id'] = $_POST['id'];
			$wh['parent_id']  	= $where['parent_id'];
			$res 				= $this->usersobj->get_comments($wh);
			//print_r($res);exit;
			$data['status']     = 'deleted';
			foreach($res as $row){
				$this->logsobj->update_log_disc($data,$row->id,'disc');
			}
			if($dis_res->attachment!='' && file_exists('images/user_discussion/'.$dis_res->attachment))
				unlink('images/user_discussion/'.$dis_res->attachment);
			$this->usersobj->delete_comment($where);
			$this->logsobj->update_log($data,$where['log_id']);
			$data['user_id']        =  $this->user_id;
			$data['solution_id']    =  $where['id'];
			$data['type']        	=  'discussion';
			$this->usersobj->delete_user_favourite($data);
			echo 1;
		}
		// redirect('users/index/act/prof', 'refresh');
	}
	function post_discussion(){
	
		if(!isset($_POST['id'])){
		
		$data['description'] 		= $_POST['status'];
		$data['visible'] 			= (isset($_POST['privacy_value']) && $_POST['privacy_value']!='')?$_POST['privacy_value']:'public';
	
		//if($post_image !='' && $post_image =='picture')
		//{	
			

              if(isset($_FILES["post_image"]) && $_FILES["post_image"]["name"]!=""){
				 
					$image_name				=str_replace(".","_",microtime(true)).str_replace(" ","_",$_FILES["post_image"]["name"]);
					$config['allowed_types'] 	=   'gif|jpg|png|jpeg';
					$config['image_library'] = 'gd2';
					$config['source_image'] = $_FILES["post_image"]["tmp_name"];
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 300;
					$config['height'] = 300;									  
					$config['new_image']="images/user_discussion/".$image_name;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$data['attachment']		=	$image_name;
					 
					
					
              }
			$data['created_by'] 	=	$this->user_id;
			//$data['commented_by'] 	= $this->user_id;
			$data['parent_id'] 		= -1;
			
		}else{
			
			$where['id'] 			= $_POST['id'];
			$data['parent_id'] 		= $_POST['id'];
			$get_disc               = $this->usersobj->get_discussion($where);
			$data['created_by'] 	= $get_disc->created_by;
			$data['description']	= $_POST['status_text'];
			$data['visible'] 		= $get_disc->visible;
			
		}
		$data['commented_by'] 		= $this->user_id;
		
		$dis_id                     = $this->usersobj->insert_discussion($data);
		$wh['id']					= $dis_id;
		$comm_res                    = $this->usersobj->get_comments($wh);
		// to create the user logs <--
		 $this->load->model('logs_model', 'logsobj');
		 
		 $logs['user_id']															=	$this->user_id;
		 if(isset($_POST['id']) && $_POST['id']!=''){
			$logs['logs']																=	'Commented on a discussion ';
		 }else 
			$logs['logs']																=	'Started a discussion ';
		 $logs['module']															= 	'disc';
		 $logs['item_id']															= 	$dis_id;
		 $logs['item_name']															= 	$this->first_name." ".$this->last_name;
		 $log_id = $this->logsobj->insert_logs($logs);
		 if($comm_res){
				$ts_c = strtotime(str_replace("-","/",$comm_res[0]->cur_date)) - strtotime(str_replace("-","/",$comm_res[0]->modified_date));
				if($ts_c>31536000) $val = round($ts_c/31536000,0).' year';
				else if($ts_c>2419200) $val = round($ts_c/2419200,0).' month';
				else if($ts_c>604800) $val = round($ts_c/604800,0).' week';
				else if($ts_c>86400) $val = round($ts_c/86400,0).' day';
				else if($ts_c>3600) $val = round($ts_c/3600,0).' hour';
				else if($ts_c>60) $val = round($ts_c/60,0).' minute';
				else $val = round($ts_c).' second'; 
				if($val>1)
						$val .= 's';
				if(file_exists('images/profile_images/'.$comm_res[0]->profile_picture) && $comm_res[0]->profile_picture!=''){
					$img_path=base_url().'images/profile_images/'.$comm_res[0]->profile_picture;
				}else{
					$img_path=base_url().'images/profile_images/default_profile_image.gif';
				 }
				if($this->user_id==$comm_res[0]->created_by) { 
					$user_name='<a href="'.base_url().'users/index/act/prof">'.$comm_res[0]->first_name." ".$comm_res[0]->last_name.' </a> ';
				}
			 if(!isset($_POST['id'])){
				if($comm_res[0]->attachment!='' || $comm_res[0]->description!=''){
 
				$activity_action='';
					 if(isset($comm_res[0]->id) && $comm_res[0]->id!=0){ 
						
						$wh['id']		=	$comm_res[0]->id;
						$dis_res 		=   $this->usersobj->get_discussion($wh);
						$u_id			=	$dis_res->created_by;	
						$item_name_sh   = $comm_res[0]->first_name." ".$comm_res[0]->last_name;
						$url_sh			=    base_url().'users/index/act/another_prof/id/'.$u_id;
						$addthis_disc   =   addthis_share($item_name_sh,'Shared a discussion',"list",$url_sh);
					
						$activity_action.='<li class="likeAct">';
									$item	= "";
									if(isset($comm_res[0]->id))
										$item = $comm_res[0]->id;
									else 
										$item = 0;
									if(isset($log_id)) 
										$item .= " ".'discussion';
									else  
										$item .= " "."0";
									if(isset($log_id)) 
										$item .= " ".$log_id;
									else  
										$item .= " "."0";
								
							$activity_action.='<a href="#" class="like_unlike" id="like" value="'.$item.'>" >';
							$activity_action.='Like';
							$activity_action.='</a>
							';
							$style = "";
							$style	=	"color:rgb(141, 141, 141)";
							$text_var	=	"Favourite";
							$activity_action.='<a href="#" class="user_favourite share2" id="user_favourite" style="'.$style.'" value="'.$item.'" >'.$text_var.'</a><span>
							<a href="#" class="user_forward share2" id="user_forward"  >Share</a></span>'.$addthis_disc.'</li>
						';
					 }
					 $activity_action.='<div class="shareThis" id="slidepanel" style="clear:both;width:100%;">
						
						
						<input type="text" placeholder="Enter the email id here" name="forward_email" id="forward_email" style="width:62%;" >
						<input type="submit" value="Forward"  class="btn_user_forward submit1" id="btn_user_forward" style="margin-top:10px;margin-right:7px;float:right;" />
						
						';
						$item_id   = $comm_res[0]->id ;
						$item_type = 'discussion' ;
						$logs_id   = $log_id;
						$activity_action.='<input type="hidden" name="item_type" value="'.$item_type.'" />
						<input type="hidden" name="item_id" value="'.$item_id.'" />
					</div>
				 
					<div class = "email_check" id="email_check"></div>';
				
				$discussion='<div class="field1 profile2 post1 feeddis"><img border="0" class="use3" src="'.$img_path.'"><ul class="clusterMem"><li><p><span style="color: #0285B5;	font-weight: bold;	text-shadow: 0 0 1px #fff;font-size:13px;">'.$user_name.'</span><span style="font-weight:normal;"> has started a discussion </span></p></li><li>'.nl2br($comm_res[0]->description);
				if($comm_res[0]->created_by==$this->user_id){
					$discussion.='<a href="javascript:void(0)" name="Delete" title="Delete discussion" style="position:relative;float:right;"><img src="'.base_url().'images/deleteIcon2.jpg" border="0" class="delete2 del_dis" id="'.$item.'" ></a>';
				}
				$discussion.='</li>';
				if(file_exists('images/user_discussion/'.$comm_res[0]->attachment) && $comm_res[0]->attachment!=''){ 
					$discussion.='<li><img src="'.base_url().'images/user_discussion/'.$comm_res[0]->attachment.'" style="max-height:202px;max-width:202px;" class="pro"></li>';
				} 
				
				$discussion.='<li class="likeThisdis">'.$val.' ago </li>'.$activity_action;
				$discussion.='	
					<li class="comment2">
					   <div class="field1 nComment3">
							<input type="hidden" id= "item_type" name="item_type" value="'.$item_type.'" />
							<input type="hidden" name="item_id" value="'.$item_id.'" />
							<input type="hidden" name="logs_id" value="'.$logs_id.'" />
							<textarea placeholder="Write a comment..." class="expand25-200 comment comment3" id ="discussion_comment" name="discussion_comment" style="overflow: hidden; padding-top: 0px; padding-bottom: 0px;"></textarea>
					   </div>
					</li>
			
				</ul>
				</div>';
				echo $discussion;
				}
			 } else{
				$item	= "";
				if(isset($comm_res[0]->id))
					$item = $comm_res[0]->id;
				else 
					$item = 0;
				if(isset($log_id)) 
					$item .= " ".'discussion';
				else  
					$item .= " "."0";
				if(isset($log_id)) 
					$item .= " ".$log_id;
				else  
					$item .= " "."0";
				echo '<li class="subComment3"><a title="Delete comment" name="Delete" href="javascript:void(0)"><img border="0" id="'.$item.'" class="delete2 del_comment" src="'.base_url().'images/deleteIcon2.jpg"></a><img border="0" class="use2" src="'.$img_path.'"><ul class="clusterMem"><li class="heading8">'.$user_name.'</li><li>'.$comm_res[0]->description.'</li><li class="likeThisdis">'.$val.' ago</li></ul></li>';
			 }
		}	 
		//-->
		/* if(isset($_POST['id']) && $_POST['id']!=''){
			echo 1;
		}else{
			redirect('users/index/act/prof')	;
		} */
	}
	function user_profile_detail_view($id=''){
		if($this->level==2 ||($this->level==1 && ($this->user_id==$id || $id==''))){
			$this->load->model('Users_model', 'usersobj');
			$this->load->model('advisor_categorys_model', 'adv_catobj');
			$this->load->model('investor_categorys_model', 'inv_catobj');
			$data['page_title']                 = 	'User:Profile';
			$data['base_url']                   = 	$this->config->item('base_url');
			$user                               =	$this->session->userdata('USER');                                                                                                   
			$data['level']						=	$user['LEVEL'];
			$data['user_id']                    = 	$user['ID'];
			
			if ($id) {
				
				$userid                         = 	$id;
				/* $another_user_array             = array(
														'an_id'            => $id,
													);
				$this->session->set_userdata('ANOTHER_USER',$another_user_array);
				 */
			} else { 
			
				$userid                         = 	$user['ID'];
				
		   }
			$data['banner_user_id']      		= $userid  ;
			
			$data['user_banner']				=	1;
			$where['user_id']					=	$user['ID'] ;
			//echo $where['user_id'];exit;
			$user_res							=	$this->usersobj->get_user_profile($userid);
			
			$data['user_res']			        = 	$user_res;
			if($user_res->cleantek_user_category=='advisor'){
				$data["advisorCategoryIds"]      	=  $this->adv_catobj->getRelationalCategoryList($userid);
			}else if($user_res->cleantek_user_category=='investor'){
				$data['investor_res']           = $this->inv_catobj->get($user_res->investor_category);
			}
			$wh['id']                      		= 	$user_res->id;
			$wh['market']                      	= 	$user_res->market;
			$data['seeking_res']				=	$this->usersobj->get_seeking_criteria($wh);
			$clnCategoryList       				=   $this->usersobj->getRelationalCategoryList($userid );
			$data['cleanteckCategoryIds']		=	$clnCategoryList;
			//Connected users
			/* $connected_users					=	$this->usersobj->get_connected_investor_advisor($userid);
			$connected_users_ids				=	array();
			$connected_users_ids[]				=	$userid;
			//print_R($connected_users);exit;
			foreach($connected_users as $row){
				if($row->status=='Confirm'){
					if($row->user_id!=$userid)
						$connected_users_ids[]=$row->user_id;
					else
						$connected_users_ids[]=$row->module_user_id;
				}
			}
			
			$where['user_ids']					=	implode(',',$connected_users_ids);
			$data['total_connection']			=	count($this->usersobj->get_users('','',$where)); */
			$where['user_id']					=  	$userid;
			$log_user							=	$this->usersobj->get_connection($where);
			$data['total_connection']			=	count($log_user);
			$data["recs_per_page"]				= 	$this->recs_per_page_connection;
			//$data['connected_users']			=	$this->usersobj->get_users('','',$where);
			//$per_page							=	2;
			
			$wh['user_id']						= 	$user['ID'];
			$wh['module_user_id']				= 	$id;
			$con_result 						= 	$this->usersobj->check_connection($wh);
			if($con_result){
				if($con_result->status=='Send')
					$data['connect']            =   1;
				else if($con_result->status=='Confirm')
					$data['connect']            =   2;
			}else
				$data['connect']            =   0;
			$this->load->view('header',$data);
			$this->load->view("user_profile_detail_view", $data);
			$this->load->view('footer');
		}else if($this->level=='1'){
				$data['message']='Please upgrade your profile to view the full user details';
				$this->load->view('header', $data);
				$this->load->view("level_2_check",$data);
				$this->load->view('footer');
		}else{
			redirect('users');
		}	
	}
	function load_connection(){
		$recs_per_page						= 	$this->recs_per_page_connection;
		$offset								=	$_POST['loaded_rows'];
		$userid 							= 	$_POST['user_id'];
		$connection_type 					= 	$_POST['connection_type'];
		
		$connected_users					=	$this->usersobj->get_connected_investor_advisor($userid);
		$connected_users_ids				=	array();
		//$connected_users_ids[]				=	$userid;
		foreach($connected_users as $row){
			if($row->status=='Confirm'){
				if($row->user_id!=$userid)
					$connected_users_ids[]=$row->user_id;
				else
					$connected_users_ids[]=$row->module_user_id;
			}
		}
		
		$where['user_ids']					=	implode(',',$connected_users_ids);
		$total_rows							=	count($this->usersobj->get_users('','',$where));
		$count_common_connection			=	0;
		//$log_user						=	$this->usersobj->get_connected_investor_advisor($this->user_id);
		$where['user_id']				=  $this->user_id;
		$log_user						=	$this->usersobj->get_connection($where);
		$log_users_ids				=	array();
				
		foreach($log_user as $row){
						
			$log_users_ids[]=$row->userid;
						
		}
		$total 								= count($log_users_ids);
	//$log_users_ids[]				=	$this->user_id;
		/* foreach($log_user as $row){
			if($row->status=='Confirm'){
				if($row->user_id!=$this->user_id)
					$log_users_ids[]=$row->user_id;
				else
					$log_users_ids[]=$row->module_user_id;
			}
		} */
		if($userid !=$this->user_id){
		
			$count_common_connection		= 	count(array_intersect($connected_users_ids, $log_users_ids));
			if(isset($connection_type) && $connection_type!=''){
				$common_connection			= 	array_intersect($connected_users_ids, $log_users_ids);
				$where['user_ids']			=	implode(',',$common_connection);
			}
		}
		//$data['total_connection']			=	count($this->usersobj->get_users('','',$where));
		$result						=	"<input type='hidden' value='".$total_rows ."' name='total_rows'><input type='hidden' value='".$count_common_connection ."' name='count_common_connection'><input type='hidden' value='".$recs_per_page."' name='recs_per_page'>";
		$where['search_name'] 				= 	$_POST['search_name'];
		$connectedusers						= array();
		if($where['user_ids'])
			$connectedusers						=	$this->usersobj->get_users($recs_per_page,$offset,$where);
		if(!empty($connectedusers)){
			 foreach($connectedusers as $con){
					
			 if(file_exists('images/profile_images/'.$con->profile_picture) && $con->profile_picture!=''){
					$img_path=base_url().'images/profile_images/'.$con->profile_picture;
				}else{
					$img_path=base_url().'images/profile_images/default_profile_image.gif';
				 }
				 $count_ant_common_connection			=	'';
				if($con->id !=$this->user_id){
					$where['user_id']				=  $con->id;
					$log_user						=	$this->usersobj->get_connection($where);
					$log_ant_users_ids				=	array();
				
					foreach($log_user as $row){
						
								$log_ant_users_ids[]=$row->userid;
						
						}
					
					$total_ant_connection				=	count($log_user);
					$count_ant_common_connection		= 	count(array_intersect($log_users_ids, $log_ant_users_ids));
				}else{
					$total_ant_connection				=	$total;
				}
				$name = ucfirst($con->first_name)." ".$con->last_name;
				//$name =  htmlentities(str_replace("'", "\'", $name));
				
				$tool_tip_profile = '<div class="toolTip2"><a href="'.base_url().'users/index/act/another_prof/id/'.$con->id.'"><img src="'.$img_path.'" class="toolImg" ></a><div class="toolDiv"> <p class="name1"><a href="'.base_url().'users/index/act/another_prof/id/'.$con->id.'">'.$name.'</a></p><p style="color:rgb(0,0,0);">'.ucfirst($con->cleantek_user_category).'</p><p style="color:rgb(0,0,0);border-top: 1px solid rgb(204, 204, 204); margin-top: 20px;margin-bottom: 20px;">All('.$total_ant_connection.')';
				if($con->id !=$this->user_id && $count_ant_common_connection!=0){
					$tool_tip_profile .=' Mutual('.$count_ant_common_connection.')</p></div></div>';
				}else{
					$tool_tip_profile .='</p></div></div>';
				}
				
	
				$tool_tip_profile =  str_replace("'", "&rsquo;", $tool_tip_profile);
				$connection = '';
				$connection_status ='';
				if($con->privacy=='connections'){
					if($this->user_id!=$con->id){
						$wh['user_id'] = $this->user_id;
						$wh['module_user_id'] = $con->id;
						$con_result = $this->usersobj->check_connection($wh);
						if($con_result){
							if($con_result->status=='Send'){
								$connection = "<img title='Already sent request' class ='action_img connect' src='".base_url()."images/wait.png'>";
								$connection_status ="<input type='hidden' id='connection_status' value='1'>";
							}
						}else{
							$connection = "<img src='".base_url()."images/Connection.png' class ='action_img connect' title='Invite ".$con->first_name." to connect' >";
							$connection_status ="<input type='hidden' id='connection_status' value='3'>";
							
						}
					}
				}
				$username = ucfirst($con->first_name)." ".$con->last_name;
				if(strlen($username) >30)
					$username = substr(ucfirst($con->first_name)." ".$con->last_name,0,30).'...';
				else
					$username = ucfirst($con->first_name)." ".$con->last_name;
				$result						.= '<li><abbr title=\''.$tool_tip_profile.'\'	
						 rel="tooltip"><img src="'.$img_path.'" border="0" class="propic3">
						
						<a href="'.base_url().'users/index/act/another_prof/id/'.$con->id.'">
						
				</a></abbr><div> <abbr title=\''.$tool_tip_profile.'\'	
						 rel="tooltip"><p class="name1"><a class="view_full" href="javascript:void(0)">'.$username.'</a></p><p>'.ucfirst($con->cleantek_user_category).'</p></abbr><p><input type="hidden" id="user_name" value="'.$con->first_name.'" >'.$connection_status.'<input type="hidden" id="hidden_type" value="'.$con->cleantek_user_category.'" ><input type="hidden" id="hidden_id" value="'.$con->id.'" >'.$connection.'</p></div></li>';
		 }
		echo $result;
		}else
			echo 0;
		
	}
	
    function basic_information() {

        $this->load->model('Users_model', 'usersobj');
        $data['page_title']                                                     = 'User:Basic Information';
        $data['base_url']                                                       = $this->config->item('base_url');
        $user                                                                   = $this->session->userdata('USER');
        $data['user_id']                                                        = $user['ID'];
        $data['user_res']                                                       = $this->usersobj->get($data['user_id']);
		$clnCategoryList       													=  $this->usersobj->getRelationalCategoryList($data['user_id']);
		$data["cleanteckCategoryIds"]   										=  $clnCategoryList;
		$this->load->view('header');
        $this->load->view("basic_information", $data);
        $this->load->view('footer');
    }

    function my_solution() {
    	/* $this->load->model('Solution_model', 'solutionsobj');
		$user                           = 	$this->session->userdata('USER');
		$where['solution_type']         = 	"Need";
		$where['submitted_by']          = 	$user['ID'];
		$data['user_id']                = 	$user['ID'];
		$config["base_url"] 			= 	rel_path() . "users/index/act/sol";
		$config["total_rows"] 			= 	count($this->solutionsobj->count_solution_submitted_by($where));
		$config["per_page"] 			= 	$this->recs_per_page;
		$config["uri_segment"] 			= 	$this->uri_segment;
		$config["cur_page"] 			= 	0;
		$this->pagination->initialize($config);
		
		if($this->uri->segment(5) == "")
			$needOffset = "0";
		else
			$needOffset = $this->uri->segment(5);
		
		$data['sol_res_need'] 			= 	$this->solutionsobj->get_solution_submitted_by($config["per_page"],$needOffset,$where);
		$data['page_links_need'] 		= 	$this->pagination->create_links();
		
		$where['solution_type']         = 	"Offer";
		$where['submitted_by']          = 	$user['ID'];
		$config1["base_url"] 			= 	rel_path() . "users/index/act/sol/page/";
		$config1["total_rows"] 			= 	count($this->solutionsobj->count_solution_submitted_by($where));
		$config1["per_page"] 			= 	$this->recs_per_page;
		$config1["uri_segment"] 		= 	6;
		$config1["cur_page"] 			= 	0;
		$this->pagination->initialize($config1);
		
		if($this->uri->segment(6) == "")
			$needOffset = "0";
		else
			$needOffset = $this->uri->segment(6);
		$data['sol_res_offer'] 			= 	$this->solutionsobj->get_solution_submitted_by($config1["per_page"],$needOffset,$where);
		$data['page_links_offer'] 		= 	$this->pagination->create_links();
		$data['page_title']				= 	'User:My Posts';
		$data['base_url']   			= 	$this->config->item('base_url');
		$data['solutionsobj']           = 	$this->solutionsobj;
        $this->load->view('header');
        $this->load->view("my_solution_view", $data);
        $this->load->view('footer'); */
			$this->load->model('category_model', 'categorysobj');
			$data['cat_res'] 				= 	$this->categorysobj->get_categories("","","",'categories_name');	
			$this->load->model('product_model', 'prodobj');
			$data['country_res'] 			= 	$this->prodobj->get_country("","");	
			$data['base_url']		   		= 	rel_path();
			$data['type']					=	$type;
			$data['recs_per_page']			= 	$this->recs_per_page;
			 //loading buudget range
			$price_ranges['']                                                      = 'View All';
			$start                                                                  = SOLUTION_BUDGET_START_RANGE;
			$end                                                                    = SOLUTION_BUDGET_END_RANGE;
			$interval = SOLUTION_BUDGET_RANGE_VALUE;
			for ($start; $start < $end; $start = $start + $interval) {
				$range1                                                             = $start + 1;
				$range2                                                             = $start + $interval;
				$price_ranges[$range1 . '-' . $range2] = $range1 . "   -   " . $range2;
			}
			$data['price_ranges']			 = $price_ranges;
			
			$this->load->view('header', $data);
			$this->load->view("solution_list_type",$data);
			$this->load->view('footer');
    }
	
	function my_product() {
    	$this->load->model('Product_model', 'productsobj');
		
		$user                           = 	$this->session->userdata('USER');
		$data['user_id']                = 	$user['ID'];
		$config["base_url"] 			= 	rel_path() . "users/index/act/pro";
		$config["total_rows"] 			= 	$this->productsobj->product_count('','need');
		$config["per_page"] 			= 	3;
		$config["uri_segment"] 			= 	$this->uri_segment;
		$config["cur_page"] 			= 	0;
		$this->pagination->initialize($config);
		
		if($this->uri->segment(5) == "")
			$needOffset = "0";
		else
			$needOffset = $this->uri->segment(5);
		$where['user_id']				=	$user['ID'];
		$data['pro_res_need'] 			= 	$this->productsobj->get_products($config["per_page"],$needOffset,$where,'need');
		
		$data['page_links_need'] 		= 	$this->pagination->create_links();
		
		$config1["base_url"] 			= 	rel_path() . "users/index/act/pro/page/";
		$config1["total_rows"] 			= 	$this->productsobj->product_count('','offer');
		$config1["per_page"] 			= 	$this->recs_per_page;
		$config1["uri_segment"] 		= 	6;
		$config1["cur_page"] 			= 	0;
		$this->pagination->initialize($config1);
		
		if($this->uri->segment(6) == "")
			$offerOffset = "0";
		else
			$offerOffset = $this->uri->segment(6);
		$data['pro_res_offer'] 			= 	$this->productsobj->get_products($config["per_page"],$offerOffset,$where,'offer');
		$data['page_links_offer'] 		= 	$this->pagination->create_links();
		$data['page_title']				= 	'User:My Posts';
		$data['base_url']   			= 	$this->config->item('base_url');
		$data['productsobj']           = 	$this->productsobj;
        $this->load->view('header');
        $this->load->view("my_product_view", $data);
        $this->load->view('footer');
    }
	
	function my_social_venture() {
    	$this->load->model('social_venture_model', 'social_ventureobj');
		$user                           = 	$this->session->userdata('USER');
		$where['social_venture_type']   = 	"Need";
		$where['submitted_by']          = 	$user['ID'];
		$data['user_id']                = 	$user['ID'];
		$config["base_url"] 			= 	rel_path() . "users/index/act/soc";
		$config["total_rows"] 			= 	count($this->social_ventureobj->count_social_venture_submitted_by($where));
		$config["per_page"] 			= 	$this->recs_per_page;
		$config["uri_segment"] 			= 	$this->uri_segment;
		$config["cur_page"] 			= 	0;
		$this->pagination->initialize($config);
		
		if($this->uri->segment(5) == "")
			$needOffset = "0";
		else
			$needOffset = $this->uri->segment(5);
		
		$data['soc_res_need'] 			= 	$this->social_ventureobj->get_social_venture_submitted_by($config["per_page"],$needOffset,$where);
		$data['page_links_need'] 		= 	$this->pagination->create_links();
		
		$where['social_venture_type']   = 	"Offer";
		$where['submitted_by']          = 	$user['ID'];
		$config1["base_url"] 			= 	rel_path() . "users/index/act/soc/page/";
		$config1["total_rows"] 			= 	count($this->social_ventureobj->count_social_venture_submitted_by($where));
		$config1["per_page"] 			= 	$this->recs_per_page;
		$config1["uri_segment"] 		= 	6;
		$config1["cur_page"] 			= 	0;
		$this->pagination->initialize($config1);
		
		if($this->uri->segment(6) == "")
			$needOffset = "0";
		else
			$needOffset = $this->uri->segment(6);
		$data['soc_res_offer'] 			= 	$this->social_ventureobj->get_social_venture_submitted_by($config1["per_page"],$needOffset,$where);
		$data['page_links_offer'] 		= 	$this->pagination->create_links();
		$data['page_title']				= 	'CleanTekMarket:My Posts';
		$data['base_url']   			= 	$this->config->item('base_url');
		$data['social_ventureobj']      = 	$this->social_ventureobj;
        $this->load->view('header');
        $this->load->view("my_social_venture_view", $data);
        $this->load->view('footer');
    }
   	/**
	 * Purpose:
	 * Get all the data from user_favourite table.
	 * This method returns My Favaourite items.
	 *
	 * @author Hitech
	 * @since Feb 2013
	 *
	 */
    function my_favourites()
    {
    	//@todo: populate data for favourite solutions
    	$this->load->model('Solution_model', 'solutionsobj');
    	$this->load->model('Group_model', 'groupobj');
    	$data['page_title']                                                     = 'User:My Favourite';
    	$data['base_url']                                                       = $this->config->item('base_url');
    	$user                                                                   = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user['ID'];
    	$where['submitted_by']                                                  = $user['ID'];
    	$data['sol_res']                                                        = $this->solutionsobj->get_my_favourite_solution("", "", $where);
    	$data['solutionsobj']                                                   = $this->solutionsobj;
    	
    	
    	//@todo : retrive Group favorite information.
    	$userInfo = $this->usersobj->get($user['ID']);
    	
    	$where['submitted_by']                                                  = $user['ID'];
    	$data['group_res']                                                      = $this->groupobj->get_my_favourite_group("", "", $where);
    	$data['groupobj'] 														= $this->groupobj;
    	$data['userInfo']   													= $userInfo;
    	$data['grouplist']   													= "get_groups";
    	
    	//@todo : retrive Group Discussion favorite information.
    	$userInfo = $this->usersobj->get($user['ID']);
    	 
    	$where['submitted_by']                                                  = $user['ID'];
    	$data['groupDiscussionThreads']                                         = $this->groupobj->get_my_favourite_group_discussion("", "", $where);
    	$data['groupobj'] 														= $this->groupobj;
    	$data['userInfo']   													= $userInfo;
    	$data['grouplist']   													= "get_groups";
    	$this->load->view('header');
    	$this->load->view("my_favourite_view", $data);
    	$this->load->view('footer');
    }

    function check_expiration_date($cc_year) {
        //Field validation succeeded.  Validate against database
        $cc_mn                                                                  = $this->input->post('cc_mn');
        $cc_date                                                                = date("Y-m-d", mktime(0, 0, 0, $cc_mn, date("d"), $cc_year));
        $cur_date                                                               = date("Y-m-d");
        if ($cc_date <= $cur_date) {
            $this->form_validation->set_message('check_expiration_date', 'Invalid expiration date');
            return false;
        } else {
            return true;
        }
    }

    function Do_direct_checkout() {
	     $paymentInfo                                                            = $this->session->userdata('paymentInfo');
    
        $this->config->load('paypal');
        $config                                                                 = array(
                                                                                    'Sandbox'           => $this->config->item('Sandbox'), // Sandbox / testing mode option.
                                                                                    'APIUsername'       => $this->config->item('APIUsername'), // PayPal API username of the API caller
                                                                                    'APIPassword'       => $this->config->item('APIPassword'), // PayPal API password of the API caller
                                                                                    'APISignature'      => $this->config->item('APISignature'), // PayPal API signature of the API caller
                                                                                    'APISubject'        => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
                                                                                    'APIVersion'        => $this->config->item('APIVersion')  // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
                                                                                );
        //$this->session->set_userdata('config', $config);
        // Show Errors
        if ($config['Sandbox']) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }
       
        $this->load->library('paypal/Paypal_pro', $config);

       //$PayPalResult                                                          	 = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
	  // echo $PayPalResult['TOKEN'];

		$ProfileDetails															=	array(
																						'PROFILESTARTDATE'   =>Date('Y-m-d').'T'.Date('h:i:s')                                                                                    
																					);
		$BillingPeriod															=	array(
																						'BILLINGPERIOD'   => $paymentInfo['Order']['period'],
																						'BILLINGFREQUENCY'=> $paymentInfo['Order']['frequency'],
																						'AMT'			  =>$paymentInfo['Order']['Amt'],
																						'CURRENCYCODE'	=>CURRENCY_CODE	
																					);	
		$CCDetails																=	array(
																						'CREDITCARDTYPE'   	=> $paymentInfo['CreditCard']['credit_type'] ,                                                                                   
																						'ACCT'				=> $paymentInfo['CreditCard']['card_number'],
																						'EXPDATE'			=> $paymentInfo['CreditCard']['expiration_month'].$paymentInfo['CreditCard']['expiration_year'] 																						
																						 
																					);	
		$ScheduleDetails														=	array(
																						'DESC'   => 'CleanTekMarket Registration.....'.$paymentInfo['Order']['Amt'].'AUD per '.$paymentInfo['Order']['period'] 		                                                                                  
																					);	
		$PayerInfo																=	array(
																						'FIRSTNAME'   => $paymentInfo['Member']['first_name'] ,                                                                                  
																						'LASTNAME'   => $paymentInfo['Member']['last_name']                                                                                   
																					);	
		$ActivationDetails														=	array(
																						'INITAMT'   => $paymentInfo['Order']['Amt'] 							                                                                                 
																					);															
		$DataArray                                                     			= array(
                                                                                   	'ProfileDetails'         => $ProfileDetails,
																					'BillingPeriod'    	     => $BillingPeriod ,
																					'CCDetails'				=> $CCDetails ,
																					'ScheduleDetails'		=>$ScheduleDetails ,
																					'PayerInfo'				=>$PayerInfo,	
																					'ActivationDetails'		=>$ActivationDetails	
                                                                                );	
																				
																				
       $PayPalResult                                                           = $this->paypal_pro->CreateRecurringPaymentsProfile($DataArray);
	   if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
             $error                                                          = '<p>'.$PayPalResult['ERRORS'][0]['L_LONGMESSAGE'].'</p>';	
            return $error;
            //$this->load->view('paypal_error',$errors);
        } else {
            
            //redirect($PayPalResult['REDIRECTURL']);
			$this->session->set_userdata('paypalresult', $PayPalResult);
            $this->level2insertion();			
            //echo "Successful";
        }
    }
	function Set_express_checkout() {
		$paymentInfo                                                            = $this->session->userdata('paymentInfo');
        
		$SECFields                                                              = array(
																					'currencycode'  => CURRENCY_CODE,
                                                                                    'returnurl'     => base_url() . 'users/paypal_return_url', // Required.  URL to which the customer will be returned 
                                                                                    'cancelurl'     => base_url() . 'users/paypal_return_url/can', // Required.  URL to which the customer will be returned if 
                                                                                    'skipdetails'   => '1', // This is a custom field not included in the PayPal 
                                                                                    'email'         => $paymentInfo['Member']['email'], // Email address of the buyer as entered during 	
                                                                                );
        $Payments                                                               = array();
        $PaymentOrderItems                                                      = array();
        //array_push($PaymentOrderItems, $Item);
        $Billing                                                                = array();
        $Payment['order_items']                                                 = $PaymentOrderItems;
        array_push($Payments, $Payment);
        $BuyerDetails                                                           = array();


        $ShippingOptions                                                        = array();

        $BillingAgreements                                                      = 	Array();
		$BillingAgreements[0]														=	Array
																					  (
																						'L_BILLINGTYPE' => 'RecurringPayments',																				 
																						'L_BILLINGAGREEMENTDESCRIPTION' => 'CleanTekMarket Registration.....'.$paymentInfo['Order']['Amt'].'AUD per '.$paymentInfo['Order']['period'] 																			 
																					  );
																				 

        $PayPalRequestData                                                      = array(
                                                                                    'SECFields'             => $SECFields,
                                                                                    'Payments'              => $Payments,
                                                                                    'BuyerDetails'          => $BuyerDetails,
                                                                                    'ShippingOptions'       => $ShippingOptions,
                                                                                    'BillingAgreements'     => $BillingAgreements
                                                                                );
        $this->config->load('paypal');
        $config                                                                 = array(
                                                                                    'Sandbox'           => $this->config->item('Sandbox'), // Sandbox / testing mode option.
                                                                                    'APIUsername'       => $this->config->item('APIUsername'), // PayPal API username of the API caller
                                                                                    'APIPassword'       => $this->config->item('APIPassword'), // PayPal API password of the API caller
                                                                                    'APISignature'      => $this->config->item('APISignature'), // PayPal API signature of the API caller
                                                                                    'APISubject'        => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
                                                                                    'APIVersion'        => $this->config->item('APIVersion')  // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
                                                                                );
        //$this->session->set_userdata('config', $config);
        // Show Errors
        if ($config['Sandbox']) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        }
      
        $this->load->library('paypal/Paypal_pro', $config);

        $PayPalResult                                                           = $this->paypal_pro->SetExpressCheckout($PayPalRequestData);
		//echo"<pre>";print_r($PayPalResult);exit;
        if (!$this->paypal_pro->APICallSuccessful($PayPalResult['ACK'])) {
            $errors                                                             = array('Errors' => $PayPalResult['ERRORS']);
			
            return $errors;
            //$this->load->view('paypal_error',$errors);
        } else {
            //echo"<pre>";print_r($PayPalResult['REDIRECTURL']);
            redirect($PayPalResult['REDIRECTURL']);
            //echo "Successful";
        }
    }

    function paypal_return_url($cancel='') {
        $paymentInfo                                                            = $this->session->userdata('paymentInfo');
        if (isset($_GET['token']) && $cancel=='') {
				$ProfileDetails															=	array(
																								'PROFILESTARTDATE'   =>Date('Y-m-d').'T'.Date('h:i:s')                                                                                    
																							);
				$BillingPeriod															=	array(
																								'BILLINGPERIOD'   => $paymentInfo['Order']['period'],
																								'BILLINGFREQUENCY'=> $paymentInfo['Order']['frequency'],
																								'AMT'			  =>$paymentInfo['Order']['Amt'],
																								'CURRENCYCODE'	=>CURRENCY_CODE	
																							);	
				$CRPPFields																=	array(
																								'TOKEN'   	=> $_GET['token']
																								);	
				$ScheduleDetails														=	array(
																								'DESC'   => 'CleanTekMarket Registration.....'.$paymentInfo['Order']['Amt'].'AUD per '.$paymentInfo['Order']['period'] 		                                                                       
																							);	
				$PayerInfo																=	array(
																								'FIRSTNAME'   => $paymentInfo['Member']['first_name'] ,                                                                                  
																								'LASTNAME'   => $paymentInfo['Member']['last_name']                                                                                   
																							);	
				$ActivationDetails														=	array(
																								'INITAMT'   => $paymentInfo['Order']['Amt'] 							                                                                                 
																							);															
				$DataArray                                                     			= array(
																							'ProfileDetails'         => $ProfileDetails,
																							'BillingPeriod'    	     => $BillingPeriod ,
																							'CRPPFields'			=> $CRPPFields ,
																							'ScheduleDetails'		=>$ScheduleDetails ,
																							'PayerInfo'				=>$PayerInfo,	
																							'ActivationDetails'		=>$ActivationDetails	
																						);	
				 $this->config->load('paypal');
				$config                                                                 = array(
																							'Sandbox'           => $this->config->item('Sandbox'), // Sandbox / testing mode option.
																							'APIUsername'       => $this->config->item('APIUsername'), // PayPal API username of the API caller
																							'APIPassword'       => $this->config->item('APIPassword'), // PayPal API password of the API caller
																							'APISignature'      => $this->config->item('APISignature'), // PayPal API signature of the API caller
																							'APISubject'        => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
																							'APIVersion'        => $this->config->item('APIVersion')  // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
																						);
				//$this->session->set_userdata('config', $config);
				// Show Errors
				if ($config['Sandbox']) {
					error_reporting(E_ALL);
					ini_set('display_errors', '1');
				}
			   
				$this->load->library('paypal/Paypal_pro', $config);																		
																						
			   $paypalresult                                                           = $this->paypal_pro->CreateRecurringPaymentsProfile($DataArray);
				echo "<pre>";print_r($paypalresult);		
			 if (isset($paypalresult['ACK']) && $paypalresult['ACK'] == 'Success') {
               $this->session->set_userdata('paypalresult', $paypalresult);
				$this->level2insertion('express');	
            } else {
				//$data['user_res']                                               = $this->session->set_userdata('user_res');
                $error                                                          = urldecode($paypalresult['ERRORS'][0]['L_LONGMESSAGE']);
                $error                                                          = "<p>" . $error . "</p>";
                $this->session->set_userdata('VALIDATION_ERRORS', $error);
                $this->advance_register($paymentInfo['id']);
            } 
        } else {
           $error                                                              = "<p>Paypal transaction cancelled </p>";
            $this->session->set_userdata('VALIDATION_ERRORS', $error);
            $this->advance_register($paymentInfo['id']); 
        }
    }
	
	

  

    function change_password($suc='') {

        if($suc)
		{
			$data['suc']=1;
		}
		$data['page_title']                                                     = 'User:Change Password';
        $data['base_url']                                                       = $this->config->item('base_url');
        $data['action']                                                         = "users/index/act/change";
        $this->load->view('header');
        $this->load->view("change_password", $data);
        $this->load->view('footer');
    }

    function change_password_save() {
		 if($this->user_id!='')
			$id							=	$this->user_id  ;
		else{
			redirect('users');
		}
        $this->load->model('Users_model', 'usersobj');
        $this->load->library('encrypt');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_pwd', 'old password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('new_pwd', 'New Password', 'trim|required|xss_clean|min_length[6]');
		$this->form_validation->set_rules('conf_pwd', 'Confirm Password', 'trim|required|xss_clean|matches[new_pwd]|min_length[6]');
        if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
			$this->change_password() ;
        } else {           
			$user_res	=	$this->usersobj->get_user_profile($id );
			$old_pwd=$this->input->post('old_pwd');
			$new_pwd=$this->input->post('new_pwd');
			$db_pwd=$this->encrypt->decode($user_res->password);
			if($db_pwd==$old_pwd)
			{
				
				$data['password']=$this->encrypt->encode($new_pwd);
				$this->usersobj->update_user($id, $data);
				$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">Password changed successfully </p>');
				$this->change_password('suc') ;
				
			}else
			{
				$this->session->set_userdata('VALIDATION_ERRORS', '<p class="err">Invalid old password</p>');
				$this->change_password() ;
			}
        }
       
    }

    /* function edit_profile(){
      $this->load->model('Users_model', 'usersobj');
      $data['base_url']   =  $this->config->item('base_url');
      $data['action']		=  "users/index/act/edit";
      $user				=  $this->session->userdata('USER');
      $professions['']	=  '-----select Profession------';
      $professions[1]		=  'Profession 1';
      $data['professions']=  $professions;
      $data['user_res']	=  $this->usersobj->get($user['ID']);
      $this->load->view('header');
      $this->load->view("edit_profile",$data);
      $this->load->view('footer');
      } */

    function logout($close='') {

         $user                = $this->session->userdata('USER');
		$user_id			 = $user['ID'];
		$data['is_login']    = 0;
		$data['session_id']	 ='';
	/* 	$result = $this->usersobj->get($user['ID']);
		$where['session_id'] = $result->session_id;
		$this->usersobj->delete_ci_session_user($where); */
		$this->usersobj->update_user($user['ID'], $data);
        $this->session->unset_userdata('USER');
		$this->session->unset_userdata('logs');
		$this->session->unset_userdata('USER_UPGRADE_PLAN'); 
		//$this->session->sess_destroy();
		$this->load->helper('cookie');
		delete_cookie("user_email");
		delete_cookie("user_pwd");
		if(!empty($close))
		{
			redirect();		
		}	
		else
			redirect('users');
    }
	
	function check_online_users() {
    
		$data['user_data']	 ='';
		$this->usersobj->delete_ci_session_user($data);
		$result = $this->usersobj->check_online_users();
        print_r($result);
    }

    function activation($encrypted_id) {
        $this->load->library('encrypt');
        $this->load->model('Users_model', 'usersobj');
        $this->load->library('form_validation');
        $id                                                                     = $this->encrypt->decode($encrypted_id);
		
        $row                                                                    = $this->usersobj->get($id);
        $data['email']                                                       	= $row->email;
        if ($row->email) {
            $data['verified']                                                   = 1;
            $this->usersobj->update_user($id, $data);
            $this->load->view('header', $data);
            $this->load->view("user_activation", $data);
            $this->load->view('footer', $data);
        } else {
            echo "Sorry.....<br/>Your Activation URL is incorrect";
        }
    }

    function level2insertion($express='') {
		$paymentInfo                                                            = $this->session->userdata('paymentInfo');
        $paypalresult                                                           = $this->session->userdata('paypalresult');
		$id                                                                     = $paymentInfo['id'];
        //$data                                                                   = $this->session->userdata('user_res');
		$this->load->model("users_model");
		$this->load->model("Users_order_model");
		$bill_data['user_id']													= $paymentInfo['id'];
		if(!$express)
		{	
			$bill_data['transaction_id']										= $paypalresult['TRANSACTIONID'];
			$bill_data['payment_type']											= 'paypal_direct';			
		}else{
			$bill_data['payment_type']											= 'paypal_express';
		}		
		$bill_data['country']													= $paymentInfo['Member']['country'];	
		$bill_data['state']														= $paymentInfo['Member']['state'];	
		$bill_data['city']														= $paymentInfo['Member']['city'];	
		$bill_data['street']													= $paymentInfo['Member']['street'];	
		$bill_data['post_code']													= $paymentInfo['Member']['post_code'];	
		$bill_data['phone']														= $paymentInfo['Member']['phone'];		
		$bill_data['cc_type']													= $paymentInfo['CreditCard']['credit_type'];		
		$bill_data['cc_number']													= substr($paymentInfo['CreditCard']['card_number'], -4);		
		$bill_data['cvv2']														= $paymentInfo['CreditCard']['cvv2']   ;		
		$bill_data['billing_period']											= $paypalresult['REQUESTDATA']['BILLINGPERIOD'];		
		$bill_data['amount']													= $paypalresult['REQUESTDATA']['AMT'];		
		$bill_data['profile_id']												= $paypalresult['PROFILEID'];		
		$bill_data['order_status']												= 'Active';		
		$order_id=$this->Users_order_model->insert_order($bill_data); 
		$plan=$this->session->userdata('USER_UPGRADE_PLAN');
		$this->load->model('businessfeature_model','bfobj');
		$plan_details=$this->bfobj->get_bussinessmodel_features($plan["plan_id"] );
		if(!empty($plan_details ))
		{
			foreach($plan_details as $raw)
			{
				$plan_data['user_id']=$paymentInfo['id'];
				$plan_data['plan_title']=$raw->plan_title;
				$plan_data['plan_id']=$raw->businessmodel_id;
				$plan_data['planfeature_id']=$raw->planfeature_id;
				$plan_data['planfeature_title']=$raw->feature_title;
				$plan_data['business_feature_id']=$raw->businessfeature_id;
				$plan_data['feature_value']=$raw->businessfeatureval;
				$plan_data['order_id']=$order_id;
				$this->bfobj->insert_user_businessmodel($plan_data); 
			}
		}
         /* $this->load->view('header');
        $this->load->view("register_success");
        $this->load->view('footer');*/
		$user_login 															= $this->session->userdata('USER');
		$user_login['LEVEL']													= 2;
		$user_login['ORDER_ID']													= $order_id;
		$this->session->set_userdata('USER',$user_login);
			
		$this->session->unset_userdata('USER_UPGRADE_PLAN');
		//$this->session->unset_userdata('user_res');
		$this->load->library( 'email' );
		$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
		$this->email->to( $paymentInfo['Member']['email'] );
		$this->email->subject( 'Registration - CleanTekMarket' );
		$this->email->set_mailtype("html");
		$emaildata['message']='<p>You have completed the registration successfully</p>  <p>Thank you</p> <p>cleantekmarket.com</p>';
		$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
		//echo $this->load->view( 'emails/news_letter', $emaildata, true );
		$this->email->send();
		//exit;		
		$this->load->helper('send_notification');		
		$message="<p>You have completed the registration successfully</p>  <p>Thank you</p> <p>cleantekmarket.com</p>";
		$receviors_id=array($id);
		send_notification('0',$receviors_id,$message,'Registration - CleanTekMarket');
		$this->session->unset_userdata('USER_UPGRADE_PLAN');
        //$this->session->unset_userdata('user_res');
        $this->session->unset_userdata('paymentInfo');		
        $this->session->unset_userdata('paypalresult');		
		// to create the user logs <--
		 $this->load->model('logs_model', 'logsobj');
		 $logs['user_id']															=	$bill_data['user_id'];
		 $logs['logs']																=	'Profile upgraded';
		 $logs['module']															= 	'prof';
		 $logs['item_id']															= 	$bill_data['user_id'];
		 $logs['item_name']															= 	$paymentInfo['Member']['first_name']." ".$paymentInfo['Member']['last_name']     ;
		 $this->logsobj->insert_logs($logs);
		//-->
		$this->session->set_userdata('VALIDATION_ERRORS','<p class="succ">Your advance registration completed successfully</p>');
		redirect('users/index/act/prof');
    }

    function twitter_login() {
        $this->config->load('twitter');
        $CONSUMER_KEY                                                           = $this->config->item('CONSUMER_KEY');
        $CONSUMER_SECRET                                                        = $this->config->item('CONSUMER_SECRET');
        //$connection                                                           = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        $params                                                                 = array(
                                                                                    'consumer_key'      => $CONSUMER_KEY,
                                                                                    'consumer_secret'   => $CONSUMER_SECRET
                                                                                );
        $this->load->library('twitter/twitteroauth', $params);

        /* Get temporary credentials. */
        $OAUTH_CALLBACK                                                         = $this->config->item('OAUTH_CALLBACK');
        $request_token                                                          = $this->twitteroauth->getRequestToken($OAUTH_CALLBACK);

        /* Save temporary credentials to session. */
        //$_SESSION['oauth_token']                                              = $token = $request_token['oauth_token'];
        $this->session->set_userdata('oauth_token', $request_token['oauth_token']);
        //$_SESSION['oauth_token_secret']                                       = $request_token['oauth_token_secret'];
        $this->session->set_userdata('oauth_token_secret', $request_token['oauth_token_secret']);

        /* If last connection failed don't display authorization link. */
        switch ($this->twitteroauth->http_code) {
            case 200:
                /* Build authorize URL and redirect user to Twitter. */
                $url                                                            = $this->twitteroauth->getAuthorizeURL($request_token['oauth_token']);
                header('Location: ' . $url);
                break;
            default:
                /* Show notification if something went wrong. */
                echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

    function twitter_login_callback() {//echo $this->session->userdata('oauth_token')."session <br>".$_REQUEST['oauth_token']."oauth_token <br>".$_REQUEST['denied'];
		
        if (isset($_REQUEST['denied'])) {
            $this->session->unset_userdata('oauth_token');
            $this->session->unset_userdata('oauth_token_secret');
            redirect();
        }

        //$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        $this->config->load('twitter');
        $CONSUMER_KEY                                                           = $this->config->item('CONSUMER_KEY');
        $CONSUMER_SECRET                                                        = $this->config->item('CONSUMER_SECRET');
        $params                                                                 = array(
                                                                                    'consumer_key'          => $CONSUMER_KEY,
                                                                                    'consumer_secret'       => $CONSUMER_SECRET,
                                                                                    'oauth_token'           => $this->session->userdata('oauth_token'),
                                                                                    'oauth_token_secret'    => $this->session->userdata('oauth_token_secret')
                                                                                );
        $this->load->library('twitter/twitteroauth', $params);

        /* Request access tokens from twitter */
        $access_token                                                           = $this->twitteroauth->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        //$_SESSION['access_token']                                             = $access_token;
        $this->session->set_userdata('access_token', $access_token);

        /* Remove no longer needed request tokens */
        $this->session->unset_userdata('oauth_token');
        $this->session->unset_userdata('oauth_token_secret');

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $this->twitteroauth->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            //$_SESSION['status'] = 'verified';
            $this->session->set_userdata('status', 'verified');
           
            $content                                                            = $this->twitteroauth->get('account/verify_credentials');
			if (isset($content->id)) {
                $this->session->set_userdata('twitter_content', $content);
                $this->load->model("users_model");
                $result                                                         = $this->users_model->check_twitter_id($content->id);
				if ($result) {
					
					$this->session->unset_userdata('twitter_content');	
                    $this->load->library('encrypt');
					$soc_media_array                                            	= array(
																					'EMAIL'		=> $result[0]->email,
																					'PASSWORD'  => $this->encrypt->decode($result[0]->password)
																				);
					$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
					$this->check_login();	
                } else {
                    $data['action']                                             = "users/index/act/twitter";
                    $this->load->view('header');
                    $this->load->view("twitter_login_view", $data);
                   // $this->load->view('footer');
                }
            } else {
                redirect();
            }
        } else {
            /* Save HTTP status for error dialog on connnect page. */
            //header('Location: ./clearsessions.php');
            $this->session->unset_userdata('oauth_token');
            $this->session->unset_userdata('oauth_token_secret');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('access_token');
            redirect('users/twitter_login');
        }
    }
	
    function twitter_register() {
		$this->load->library('encrypt');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email|is_unique[user.email]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
            $data['action']                                                     ="users/index/act/twitter";
            $this->load->view('header');
            $this->load->view("twitter_login_view", $data);
            $this->load->view('footer');
        } else {
            $this->load->model("users_model");
            $content                                                           		 = $this->session->userdata('twitter_content');
			if($content!=''){
			
				$user                                                               = explode(' ', $content->name, 2);
				$data['first_name']                                                 = $user[0];
				$data['last_name']                                                  = $user[1];
				$data['email']                                                      = $this->input->post('email');
				$data['login_auth_key']                                             = $content->id;
				$password															= substr($data['email'], 0, strpos($data['email'], '@')).rand(1, 15);
				$password_enc														=  $this->encrypt->encode($password	);
				$data['password']                                                   = $password_enc;
				$data['registered_via']                                             = 'twitter';
				$data['user_type']                                                  = 'general';
				$data['published']                                                  = 1;
				$data['verified']                                                   = 0;
				$data['profile_update_date']=date('Y-m-d h:i:s'); 
				$user_id=$this->users_model->insert_user($data);
				$enc_id                                                             = $this->encrypt->encode($user_id);
				$this->load->library( 'email' );
				$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
				$this->email->to( $data['email'] );
				$this->email->subject( 'Verify your email account - CleanTekMarket' );
				$this->email->set_mailtype("html");
				$emaildata['message']='<p><h4>Welcome to CleanTek Market.</h4></p><br><p>Your username is : '. $data['email'] .'</p><p>Your password is : '.$password.'</p><br><p>Please activate your account by clicking <a target="_blank" style="border:none;color:#0084b4;text-decoration:none;font-size:14px;font-weight:bold;font-family:' . 'Helvetica Neue' . ',Helvetica,Arial,sans-serif" href="' . base_url() . 'users/index/act/activation/id/' . $enc_id. '">here</a> or click the link below:</p><p><a target="_blank" style="border:none;color:#0084b4;text-decoration:none" href="' . base_url() . 'users/index/act/activation/id/' . $enc_id    . '">' . base_url() . 'users/index/act/activation/id/' . $enc_id    . '</a></p><br> <p>Thank you</p> <p>CleanTekMarket.com</p>';
				$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
				//echo $this->load->view( 'emails/news_letter', $emaildata, true );
				$this->email->send();
				$this->session->unset_userdata('twitter_content');
				
				/*<-- free registration for 1 year*/
				$plan["price"] 		= '';	
				$plan["plan_id"]	=  1;	
				$plan["free"]		=  1;	
				$this->session->set_userdata('USER_UPGRADE_PLAN',$plan);
				$this->user_id=$user_id ;
				$this->advance_register_save();
				$this->session->unset_userdata('USER');
				$this->user_id='';
				/* ---> */
				/* $soc_media_array                                            	= array(
																				'EMAIL'		=> $data['email']  ,
																				'PASSWORD'  => $password
																			);
				$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array); 
				$this->check_login();*/
				$this->session->set_userdata('VALIDATION_ERRORS','<p>Registration completed successfully.<br>
				Please check your email to complete the verification process.</p>');
				redirect();
				
			}else{
				redirect();
			}
			
		}	
    }

    function linkedin_login() {
 /*        $API_CONFIG                                                             = array(
                                                                                    'appKey'        => 'b9soriy1h6q4',
                                                                                    'appSecret'     => 'cuvygjnlLOOsxKgk',
                                                                                    'callbackUrl'   => NULL
                                                                                );   */
		$API_CONFIG                                                             = array(
                                                                                    'appKey'        => '7538wgaapng0n5',
                                                                                    'appSecret'     => 'SNj7OmObxz91bJSa',
                                                                                    'callbackUrl'   => NULL
                                                                                ); 
        $protocol                                                               = 'http';
        // set the callback url
        $API_CONFIG['callbackUrl']                                              = base_url() . 'users/linkedin_login?response=1'; //$protocol . '://' . $_SERVER['SERVER_NAME'] . ((($_SERVER['SERVER_PORT'] != PORT_HTTP) || ($_SERVER['SERVER_PORT'] != PORT_HTTP_SSL)) ? ':' . $_SERVER['SERVER_PORT'] : '') . $_SERVER['PHP_SELF'] . '?' . LINKEDIN::_GET_TYPE . '=initiate&' . LINKEDIN::_GET_RESPONSE . '=1';
        $this->load->library('linkedin/linkedin', $API_CONFIG);
        $_GET['response']                                                       = isset($_GET['response']) ? $_GET['response'] : '';


        if (!$_GET['response']) {
            // LinkedIn hasn't sent us a response, the user is initiating the connection
            // send a request for a LinkedIn access token
            $response                                                           = $this->linkedin->retrieveTokenRequest();

            if ($response['success'] === TRUE) {
                // store the request token
                //  $_SESSION['oauth']['linkedin']['request']                   = $response['linkedin'];
                $this->session->set_userdata('oauth', $response['linkedin']);

                // redirect the user to the LinkedIn authentication/authorisation page to initiate validation.
                //header('Location: ' . LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);

                redirect(LINKEDIN::_URL_AUTH . $response['linkedin']['oauth_token']);
            } else {
                // bad token request
                echo "Request token retrieval failed:<br /><br />RESPONSE:<br /><br /><pre>" . print_r($response, TRUE) . "</pre><br /><br />LINKEDIN OBJ:<br /><br /><pre>" . print_r($OBJ_linkedin, TRUE) . "</pre>";
            }
        }
        $oauth                                                                  = $this->session->userdata('oauth');
        if (isset($_GET['oauth_verifier'])) {
            $response                                                           = $this->linkedin->retrieveTokenAccess($oauth['oauth_token'], $oauth['oauth_token_secret'], $_GET['oauth_verifier']);
            if ($response['success'] === TRUE) {
                // the request went through without an error, gather user's 'access' tokens
                // $_SESSION['oauth']['linkedin']['access']                     = $response['linkedin'];
                $this->session->set_userdata('oauth_access', $response['linkedin']);
                // set the user as authorized for future quick reference
                // $_SESSION['oauth']['linkedin']['authorized']                 = TRUE;			  
                // redirect the user back to the demo page
                //header('Location: ' . $_SERVER['PHP_SELF']);
                header('Location:' . base_url() . 'users/linkedin_callback');
            } else {
                echo "error at 1536";
            }
        } else {
			
            redirect();
        }
    }

   function linkedin_callback() {
      /*   $API_CONFIG                                                             = array(
                                                                                    'appKey'        => 'b9soriy1h6q4',
                                                                                    'appSecret'     => 'cuvygjnlLOOsxKgk',
                                                                                    'callbackUrl'   => NULL
                                                                                ); */
		$API_CONFIG                                                             = array(
                                                                                    'appKey'        => '7538wgaapng0n5',
                                                                                    'appSecret'     => 'SNj7OmObxz91bJSa',
                                                                                    'callbackUrl'   => NULL
                                                                                ); 																		
        $this->load->library('linkedin/linkedin', $API_CONFIG);
        $oauth_access                                                           = $this->session->userdata('oauth_access');
        $this->linkedin->setTokenAccess($oauth_access);
        $this->linkedin->setResponseFormat('XML');
        $response                                                               = $this->linkedin->profile('~:(id,first-name,last-name,picture-url,email-address)');
        if ($response['success'] === TRUE) {
            $response['linkedin']                                               = new SimpleXMLElement($response['linkedin']);
            $response                                                           = $response['linkedin'];
			
            if (isset($response->id)) {

                $result                                                         = array();
                $properties                                                     = array('id', 'first-name', 'last-name', 'email-address');
                foreach ($properties as $p) {
                    $result[$p]                                                 = (string) $response->$p;
                }
			    $this->session->set_userdata('linkedin_content', $result);
                $this->load->model("users_model");
                $db_result                                                         = $this->users_model->check_linked_id($response->id);
			     if ($db_result) {
                    $this->session->unset_userdata('linkedin_content');
					$this->load->library('encrypt');
					$soc_media_array                                            	= array(
																					'EMAIL'		=> $db_result[0]->email,
																					'PASSWORD'  => $this->encrypt->decode($db_result[0]->password)
																				);
					$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
					$this->check_login();
                } else {					
					if(isset($result['email-address']) && $result['email-address']!='' )
					{
						
						 $user_email                                                     = $this->usersobj->email_check($result['email-address']);
						 if($user_email)
						 {
							$this->session->set_userdata('VALIDATION_ERRORS','<p class="err">\''.$result['email-address'].'\' is already existing.</p>');
							redirect('users/login');
						 }
						//$data['username']                                           = $user_profile['username'];
						$data['first_name']                                         = $result['first-name'];
						$data['last_name']                                          = $result['last-name'];
						$data['user_type']                                          = 'general';
						$data['registered_via']                                  	= 'linkedin';
						$data['login_auth_key']                                     = $result['id'];
						$data['email']                                              = $result['email-address'];
						$password													= substr($result['email-address'], 0, strpos($result['email-address'], '@')).rand(1, 15);
						$data['password']											= $this->encrypt->encode($password);
						$data['profile_update_date']								=	date('Y-m-d h:i:s'); 
						$data['verified']                                           = 1;
						$data['published']                                          = 1;
						$user_id                                                     = 	$this->usersobj->insert_user($data);
						$enc_id                                                     = $this->encrypt->encode($user_id);
						$this->load->library( 'email' );
						$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
						$this->email->to($result['email-address']  );
						$this->email->subject( 'Registration completed successfully  - CleanTekMarket' );
						$this->email->set_mailtype("html");
						$emaildata['message']='<p><h4>Welcome to CleanTek Market.</h4></p><br><p>Your username is : '.$result['email-address'] .'</p><p>Your password is : '.$password.'</p><<br> <p>Thank you</p> <p>CleanTekMarket.com</p>';
						$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
						//echo $this->load->view( 'emails/news_letter', $emaildata, true );
						$this->email->send();
						$soc_media_array                                             = array(
																						'EMAIL'		=> $result['email-address'],
																						'PASSWORD'  => $password
																						);
						$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
						/*<-- free registration for 1 year*/
						$plan["price"] 		= '';	
						$plan["plan_id"]	=  1;	
						$plan["free"]		=  1;	
						$this->session->set_userdata('USER_UPGRADE_PLAN',$plan);
						$this->user_id=$user_id ;
						$this->advance_register_save();
						$this->session->unset_userdata('USER');
						$this->user_id='';
						/* ---> */
						$this->check_login();
					}else{
						$data['action']                                             =  "users/index/act/linkedin";
						$this->load->view('header');
						$this->load->view("twitter_login_view", $data);
						$this->load->view('footer');
					}
                }
            } else {
                redirect('users');
            }
        }
    }

    function linkedin_register() {
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email|is_unique[user.email]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('VALIDATION_ERRORS', validation_errors());
            $data['action']                                                     = "users/index/act/linkedin";
            $this->load->view('header');
            $this->load->view("twitter_login_view", $data);
            $this->load->view('footer');
        } else {
            $this->load->model("users_model");
            $content                                                            = $this->session->userdata('linkedin_content');            
			if($content!=''){
				$data['first_name']                                                 = $content['first-name'];
				$data['last_name']                                                  = $content['last-name'];
				$data['email']                                                      = $this->input->post('email');
				$password															= substr($data['email'], 0, strpos($data['email'], '@')).rand(1, 15);
				$this->load->library('encrypt');
				$password_enc														=  $this->encrypt->encode($password	);
				$data['password']                                                   = $password_enc;
				$data['login_auth_key']                                             = $content['id'];
				$data['registered_via']                                             = 'linkedin';
				$data['user_type']                                                  = 'general';
				$data['verified']                                                   = 1;
				$data['published']                                                  = 1;
				$data['profile_update_date']=date('Y-m-d h:i:s'); 
				$user_id=$this->users_model->insert_user($data);
				$enc_id                                                             = $this->encrypt->encode($user_id);
				$this->load->library( 'email' );
				$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
				$this->email->to( $data['email'] );
				$this->email->subject( 'Registration completed successfully  - CleanTekMarket' );
				$this->email->set_mailtype("html");
				$emaildata['message']='<p><h4>Welcome to CleanTekMarket.</h4></p><br><p>Your username is : '.$data['email'] .'</p><p>Your password is : '.$password.'</p><br> <p>Thank you</p> <p>CleanTekMarket.com</p>';
				$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
				//echo $this->load->view( 'emails/news_letter', $emaildata, true );
				$this->email->send();
				$this->session->unset_userdata('linkedin_content');
				$soc_media_array                                            	= array(
																				'EMAIL'		=> $data['email']  ,
																				'PASSWORD'  => $password
																			);
				$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
				/*<-- free registration for 1 year*/
				$plan["price"] 		= '';	
				$plan["plan_id"]	=  1;	
				$plan["free"]		=  1;	
				$this->session->set_userdata('USER_UPGRADE_PLAN',$plan);
				$this->user_id=$user_id ;

				$this->advance_register_save();
				$this->session->unset_userdata('USER');
				$this->user_id='';
				/* ---> */
				$this->check_login();
			}else{	
				redirect();
			}
        }
    }

    function user_favourite() {
        $this->load->model("users_model", "usersobj");
        $data['solution_id']                                                    = $_POST['id'];
        $user_login                                                             = $this->session->userdata('USER');
        $data['user_id']                                                        = $user_login['ID'];
       if(isset($_POST['type']) && $_POST['type']!="")
			$data['type']                                                       = trim($_POST['type']);
		
		if(isset($_POST['logs_id']) && $_POST['logs_id']!="")
			$data['user_logs_id']                                               = trim($_POST['logs_id']);
        $result                                                                 = $this->usersobj->check_user_favourite($data);
        if (isset($result)) {
			$this->usersobj->delete_user_favourite($data);
            echo 0;
        } else {
            $res                                                                = $this->usersobj->add_user_favourite($data);
            echo 1;
        }
    }
    
    function user_favourite_group_discussion() {
    	$this->load->model("users_model", "usersobj");
    	$data['solution_id']                                           			= $_POST['group_discussion_id'];
    	$user_login                                                             = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user_login['ID'];
    	$data['type']                                                           = 'groupdiscussion';
    	$result                                                                 = $this->usersobj->check_user_favourite($data);
    	if (isset($result)) {
    		$this->usersobj->delete_user_favourite($data);
    		echo 0;
    	} else {
    		$res                                                                = $this->usersobj->add_user_favourite($data);
    		echo 1;
    	}
    }
    
    function user_favourite_group() {
    	$this->load->model("users_model", "usersobj");
    	$data['solution_id']                                           			= $_POST['group_id'];
    	$user_login                                                             = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user_login['ID'];
    	$data['type']                                                           = 'group';
    	$result                                                                 = $this->usersobj->check_user_favourite($data);
    	if (isset($result)) {
    		echo 0;
    	} else {
    		$res                                                                = $this->usersobj->add_user_favourite($data);
    		echo 1;
    	}
    }

    function user_like() {
        $this->load->model("users_model", "usersobj");
        $data['solution_id']                                                    = $_POST['id'];
        $user_login                                                             = $this->session->userdata('USER');
        $data['user_id']                                                        = $user_login['ID'];
		if(isset($_POST['type']) && $_POST['type']!="")
			$data['type']                                                       = trim($_POST['type']);
		if(isset($_POST['logs_id']) && $_POST['logs_id']!="")
			$data['user_logs_id']                                               = trim($_POST['logs_id']);
        //$res=$this->usersobj->add_user_like($data);
        $result                                                                 = $this->usersobj->check_user_like($data);
        if ($result) {
			$this->usersobj->delete_user_like($data);
           if(isset($_POST['cntreq']) && !empty($_POST['cntreq']))
           {
				$count                                                              = $this->usersobj->count_user_like($data);
            	echo $count;
           }
           else
				echo "Like";
        } else {
            $res                                                                = $this->usersobj->add_user_like($data);
            if(isset($_POST['cntreq']) && !empty($_POST['cntreq']))
            {
            	$count                                                              = $this->usersobj->count_user_like($data);
            	echo $count;
            }
            else
		   		echo "Unlike";
        } 
    }  
 
	function user_forward(){
		$this->load->model('Users_model', 'usersobj');
		$receiver   =  $_POST['forward_email'];
		$item_type  =  $_POST['item_type'];
		$item_id   	=  $_POST['item_id'];
		 if($item_type=='products'){
			$ctrl_name	=	'product';
		}else if($item_type=='investor'|| $item_type=='advisor'|| $item_type=='general'){
			$ctrl_name	=	$item_type; 
			$item_type  =   'users';
		}else if($item_type=='solutions'){
			$ctrl_name	=	'solution'; 
		}else if($item_type=='discussion'){
			$where['id']=	$item_id;
			$dis_res 	= $this->usersobj->get_discussion($where);
			$item_id	=	$dis_res->created_by;
			$ctrl_name	=	$item_type;
		}else if($item_type=='group'){
			$ctrl_name	=	'Cluster';
		} else if($item_type=='groupdiscussion'){
			$ctrl_name	=	'Cluster discussion';
		} else
			$ctrl_name	=	$item_type; 
		
		
		$user_login = $this->session->userdata('USER');
		$result=$this->usersobj->get($user_login['ID']);

		if($result) {
			if($item_type=="news")
				$url=base_url()."news/index/act/news_detail/id/".$item_id;
			else if($item_type=="blog")
				$url=base_url()."blog/index/act/blog_detail/id/".$item_id;
			else if($item_type=="article")
				$url=base_url()."blog/index/act/blog_detail/id/".$item_id;
			else if($item_type=="discussion")
				$url=base_url()."users/index/act/another_prof/id/".$item_id;
			else if($item_type=="groupdiscussion")
				$url=base_url()."group/index/act/full/id/".$item_id;
			else
				$url=base_url().$item_type."/index/act/full/id/".$item_id;
		//	else
			//	$url=base_url().$item_type."/index/act/news_detail/id/".$item_id;
			
			$this->load->library( 'email' );
			$this->email->from($result->email,$result->first_name." ".$result->last_name);
			$this->email->to( $receiver  );
			$this->email->subject( 'Your friend likes to share a '. $ctrl_name.' - CleanTekMarket' );
			$this->email->set_mailtype("html");
			if($ctrl_name=='investor'|| $ctrl_name=='advisor')
				$ctrl_name_art = 'an '.$ctrl_name;
			else
				$ctrl_name_art = 'a '.$ctrl_name;
			$emaildata['message']='<p>'.$result->first_name." ".$result->last_name.' shared '.$ctrl_name_art.' on CleanTekMarket with you.<br/><br/>To see the '.$ctrl_name.', visit<br/>'.$url.'<br/><br/>Thank you<br/><b> - <a target="_blank" href="'.base_url().'users/index/act/another_prof/id/'.$result->id.'">'.ucfirst($result->first_name)." ".ucfirst($result->last_name).'</a></b><br/>'.ucfirst($result->cleantek_user_category).'</p>  <p>cleantekmarket.com</p>';
			$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
			if($this->email->send()) 
				echo 1;
			else
				echo 0;
			
		}
	}
	
	function connection() {
		$this->load->model("users_model", "usersobj");
		$this->load->model("product_model", "prodsobj");
		$this->load->model("solution_model", "solsbj");
		$this->load->model("group_model", "groupobj");
		$user_login                                                         = $this->session->userdata('USER');
    	$where['user_id']                                                   = $user_login['ID'];
		$where['module_id']                                                 = $_POST['id'];
		$where['module_user_id'] 											= $_POST['id'];
		//$module_user_id 													= $_POST['id'];
		if(isset($_POST['type']) && trim($_POST['type'])!=""){
			$where['module']                                                 = trim($_POST['type']);
			$module			                                                 = 'user';
		}
		if($where['module']=='products'||$where['module']=='solutions'||$where['module']=='group'){
			if($where['module']=='products'){
				$module			                                                 = 'product';
				/* $pro_res = $this->prodsobj->check_advisor_investor_confirmation($where);
				if($pro_res){
					if($pro_res->mod_user_id==$where['user_id']){
						echo 2;exit;
					}else{ */
						$mod_result = $this->prodsobj->get($where['module_id']);
						$title		= $mod_result->title;
						$where['module_user_id'] = $mod_result->submitted_by;
					/* }
				}else{
					$mod_result = $this->prodsobj->get($where['module_id']);
					$where['module_user_id'] = $mod_result->submitted_by;
				} */
			}
			if($where['module']=='solutions'){
				$module			                                                 = 'solution';
				/* $sol_res = $this->solsbj->check_advisor_investor_confirmation($where);
				if($sol_res){
					if($sol_res->mod_user_id==$where['user_id']){
						echo 2;exit;
					}else{ */
						$mod_result  = $this->solsbj->get($where['module_id']);
						$title		 = $mod_result->title;
						$where['module_user_id'] = $mod_result->submitted_by;
					/* }
				}else{
					$mod_result = $this->solsbj->get($where['module_id']);
					$where['module_user_id'] = $mod_result->submitted_by;
				} */
			}if($where['module']=='group'){
				$module			                                                 = 'group';
				/* $gro_res = $this->groupobj->check_user_confirmation($where);
				if($gro_res){
					if($gro_res->mod_user_id==$where['user_id']){
						echo 2;exit;
					}else{ */
						$mod_result = $this->groupobj->get($where['module_id']);
						$title = $mod_result->group_name;
						$where['module_user_id'] = $mod_result->group_created_by;
					/* }
				}else{
					$mod_result = $this->groupobj->get($where['module_id']);
					$module_name = $mod_result->group_name;
					$where['module_user_id'] = $mod_result->group_created_by;
				} */
			}
		}
		
		$result 					= $this->usersobj->check_connection($where);
		$user_res                   = $this->usersobj->get($user_login['ID']);
		$mod_user_res               = $this->usersobj->get($where['module_user_id']);
		if($result){
		// echo $result->status;exit;
			if($result->status=='Send')
				echo 1;
			else if($result->status=='Confirm')
				echo 2;
		}else{
			$where['status']			= 'Send';
			
			$this->usersobj->insert_connection($where);

			$sender_id                  = $where['user_id'];
			$receiver_id                = array($where['module_user_id']);
			//print_r($receiver_id );exit;
			$confirm					=	'onclick="return confirm('."'Are you sure to approve this ".$module."?'".')"';
			$reject_confirm				=	'onclick="return confirm('."'Are you sure to reject this ".$module."?'".')"';
			$enc_sender_id				=	urlencode($this->encrypt->encode($sender_id));
			$enc_module_id				=	urlencode($this->encrypt->encode($where['module_id']));
			$enc_module					=	urlencode($this->encrypt->encode($where['module']));
			$enc_ower					=	urlencode($this->encrypt->encode($where['module_user_id']));
			// to create the user logs <--
			$this->load->model('logs_model', 'logsobj');
			$logs['item_id']             = 	$where['module_user_id'];
			$logs['item_name']           = 	$mod_user_res->first_name." ".$mod_user_res->last_name;
			$logs['user_id']             = 	$where['user_id'];
			$logs['logs']              	 =  "sent connection invitation to";
			$logs['module']              = 	'prof';
			$this->logsobj->insert_logs($logs);
			
			$logs['item_id']             = 	$where['user_id'];
			$logs['item_name']           = 	$user_res->first_name." ".$user_res->last_name;
			$logs['user_id']             = 	$where['module_user_id'];
			$logs['logs']              	 =  "received the connection invitation from";
			$logs['module']              = 	'prof';
			$this->logsobj->insert_logs($logs);
			if(isset($mod_result)){
				/* if($where['module']=='group')
					$message					=	"Hello ".$mod_user_res->first_name." ".$mod_user_res->last_name. ", <br>  I'd like to add you to my CleanTekMarket network through the ".$module." <a target='_blank' href='".base_url().$where['module']."/index/act/full/id/".$where['module_id']."'>".$title."</a>.<br><br> - <b><a target='_blank' href='".base_url()."users/index/act/another_prof/id/".$user_login['ID']."'>".$user_login['FIRST_NAME']." ".$user_login['LAST_NAME']."</a></b><br>".$user_res->cleantek_user_category."<br><a href='".base_url()."users/index/act/disapprove/module_id/".$enc_module_id."/user/".$enc_sender_id."/module/".$enc_module."/owner/".$enc_ower."'  ".$reject_confirm." class='save'>Reject</a>&nbsp;&nbsp;&nbsp;<a href='".base_url()."users/index/act/approve/module_id/".$enc_module_id."/user/".$enc_sender_id."/module/".$enc_module."/owner/".$enc_ower."'  ".$confirm." class='save'>Accept</a>";	
				else */
				$message					=	"Hello ".$mod_user_res->first_name." ".$mod_user_res->last_name. ", <br>  I'd like to add you to my CleanTekMarket network through the ".$module." <a target='_blank' href='".base_url().$where['module']."/index/act/full/id/".$where['module_id']."'>".$mod_result->title."</a>.<br><br> - <b><a target='_blank' href='".base_url()."users/index/act/another_prof/id/".$user_login['ID']."'>".$user_login['FIRST_NAME']." ".$user_login['LAST_NAME']."</a></b><br>".$user_res->cleantek_user_category;	
			}else{
				$message					=	"Hello ".$mod_user_res->first_name." ".$mod_user_res->last_name. ", <br>  I'd like to add you to my CleanTekMarket network.<br/><br> - <b><a target='_blank' href='".base_url()."users/index/act/another_prof/id/".$user_login['ID']."'>".$user_login['FIRST_NAME']." ".$user_login['LAST_NAME']."</a></b><br>".$user_res->cleantek_user_category;	
			}
			$message_mail               = $message;
			$message                   .= "<br> <a href='".base_url()."users/index/act/disapprove/module_id/".$enc_module_id."/user/".$enc_sender_id."/module/".$enc_module."/owner/".$enc_ower."'  ".$reject_confirm." class='save'>Reject</a>&nbsp;&nbsp;&nbsp;<a href='".base_url()."users/index/act/approve/module_id/".$enc_module_id."/user/".$enc_sender_id."/module/".$enc_module."/owner/".$enc_ower."'  ".$confirm." class='save'>Accept</a>";
			$message_mail				.=	"<br> <a href='".base_url()."users/index/act/disapprove/module_id/".$enc_module_id."/user/".$enc_sender_id."/module/".$enc_module."/owner/".$enc_ower."/bymail/1'  ".$reject_confirm." class='save'>Reject</a>&nbsp;&nbsp;&nbsp;<a href='".base_url()."users/index/act/approve/module_id/".$enc_module_id."/user/".$enc_sender_id."/module/".$enc_module."/owner/".$enc_ower."/bymail/1'  ".$confirm." class='save'>Accept</a>";
			$subject					=	'Connection Confirmation Request - CleanTekMarket';	
			$this->load->helper('send_notification');
			send_notification($sender_id ,$receiver_id,$message,$subject);
			$this->load->library( 'email' );
			$this->email->from($user_res->email,$user_res->first_name." ".$user_res->last_name);
			$this->email->to($mod_user_res->email);
			$this->email->subject($subject);
			$this->email->set_mailtype("html");
			$emaildata['message']		=	$message_mail;
			$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
			//echo $this->load->view( 'emails/news_letter', $emaildata, true );
			$this->email->send(); 
			echo 3;
		}
		
    }
	
	function user_confirmation($module_id,$user_id,$module,$owner='',$status='',$bymail)
	{
		//echo $module_id." ".$user_id." ".$module." ".$owner;
			
		//
			$this->load->model("users_model", "usersobj");
			$this->load->model("product_model", "prodsobj");
			$this->load->model("solution_model", "solobj");
			$this->load->model("group_model", "groupobj");
			$module_id					=	$this->encrypt->decode(urldecode($module_id));
			$user_id					=	$this->encrypt->decode(urldecode($user_id));
			$module						=	$this->encrypt->decode(urldecode($module));
			$owner						=	$this->encrypt->decode(urldecode($owner));
		if($owner==$this->user_id){
		//echo $module_id." ".$user_id." ".$module." ".$owner;exit;
			$this->load->model("users_model", "usersobj");
			$user_res                 	= 	$this->usersobj->get($user_id);
			if($owner!='')
				$module_res             = 	$this->usersobj->get($owner);
			$where['module_id']			=	$module_id;
			$where['user_id']			=	$user_id;
			$where['module_user_id']	=	$owner;
			$where['module']			=	$module;
			if($module=='products'){
				$module					=	'product';	//$module_res->cleantek_user_category;
			}else if($module=='solutions'){
				$module					=	'solution';	//$module_res->cleantek_user_category;
			}else{
				$module					=	$module;	//$module_res->cleantek_user_category;
			}
			
			if($where['module']=='products'){
				$mod_res = $this->prodsobj->get($module_id);
			}
			if($where['module']=='solutions'){
				$mod_res = $this->solobj->get($module_id);
			}
			$new						=	0;
			$flag						=	0;
			$flag_cancel				=	0;
			$result 					=	$this->usersobj->check_connection($where);
			//print_r($result);exit;
			if($result)
			{	
				if(isset($status) && $status=='Cancel'){
					$data['status']		=	'Send';
					$this->usersobj->update_connection($data,$where);
					$flag_cancel       	= 	1;
				}else if($result->status=='Send'){
					$data['status']		=	'Confirm';
					$this->usersobj->update_connection($data,$where);
					$new      			=	1;
				}else if($result->status=='Confirm'){
					$flag      			=	1;
				}
			}			
			else{
				echo "Invalid user";
				exit;
			}		
		
			if($new==1)
			{
				$this->load->helper('send_notification');
				$receiver_id			=	array($user_id);
				$user_login             = 	$this->session->userdata('USER');
				$sender_id       		= 	$user_login['ID'];
				if($mod_res){
					//if($where['module']=='products')
					$message		=	$module_res->first_name." has accepted your invitation via the ".$module."<a target='_blank' href='".base_url().$where['module']."/index/act/full/id/".$where['module_id']."'> ".$mod_res->title."</a>!<br/><br/> - <b><a target='_blank' href='".base_url()."users/index/act/another_prof/id/".$module_res->id."'>".$module_res->first_name." ".$module_res->last_name."</a></b><br/>".$module_res->cleantek_user_category;
				}else
					$message			=	$module_res->first_name." has accepted your invitation  !<br/><br/> - <b><a target='_blank' href='".base_url()."users/index/act/another_prof/id/".$module_res->id."'>".$module_res->first_name." ".$module_res->last_name."</a></b><br/>".$module_res->cleantek_user_category;
					//send external mail
					$this->load->library( 'email' );
					$this->email->from($mod_user_res->email,$mod_user_res->first_name." ".$mod_user_res->last_name);
					$this->email->to($user_res->email);
					$this->email->subject($subject);
					$this->email->set_mailtype("html");
					$emaildata['message']		=	$message;
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send(); 
				send_notification($sender_id ,$receiver_id,$message,$module_res->first_name." joined your network");
				 // to create the user logs <--
				$this->load->model('logs_model', 'logsobj');
				$logs['item_id']             = 	$owner;
				$logs['item_name']           = 	$module_res->first_name." ".$module_res->last_name;
				$logs['user_id']             = 	$user_id;
				$logs['logs']              	 =  "a new connection with ".$module_res->cleantek_user_category;
				$logs['module']              = 	'prof';
				$this->logsobj->insert_logs($logs);
				
				$logs['item_id']             = 	$user_id;
				$logs['item_name']           = 	$user_res->first_name." ".$user_res->last_name;
				$logs['user_id']             = 	$module_id;
				$logs['logs']              	 =  "a new connection with ".$user_res->cleantek_user_category;
				$logs['module']              = 	'prof';
				$this->logsobj->insert_logs($logs);
				   //-->
				//echo $module_res->id." ".$user_id;exit;
				if(isset($bymail) && $bymail==1){
					$val_message =  array(
									'title'            => 'Connection Confirmation',
									'content'     	   => '<p>Connection request for the user '.$user_res->first_name." ".$user_res->last_name.' approved successfully</p>'
								);
					$this->session->set_userdata('VALIDATION_MESSAGE',$val_message);
					//print_r($this->session->userdata('VALIDATION_MESSAGE'));exit;
					redirect('users/index/act/another_prof/id/'.$user_id);
					
				}else{
					$this->session->set_userdata('VALIDATION_ERRORS', '<p class="succ">Connection request for the user "'.$user_res->first_name." ".$user_res->last_name.'" approved successfully</p>');
					redirect('internal_mail/index/act/notification');
				}
			}	
			if($flag==1)
			{
				if(isset($bymail) && $bymail==1){
					$val_message =  array(
									'title'            => 'Connection Confirmation',
									'content'          => '<p>Connection request for the user '.$user_res->first_name." ".$user_res->last_name.' has already been approved</p>'
								);
					$this->session->set_userdata('VALIDATION_MESSAGE',$val_message);
					redirect('users/index/act/another_prof/id/'.$user_id);
					
				}else{
					$this->session->set_userdata('VALIDATION_ERRORS', '<p>Connection request for the user "'.$user_res->first_name." ".$user_res->last_name.'" has already been approved</p>');
					redirect('internal_mail/index/act/notification');
				}
			}
			if($flag_cancel==1)
			{
				if(isset($bymail) && $bymail==1){
					$val_message =  array(
									'title'            => 'Connection Confirmation',
									'content'          => '<p>Connection request for the user '.$user_res->first_name." ".$user_res->last_name.' has pending </p>'
								);
					$this->session->set_userdata('VALIDATION_MESSAGE',$val_message);
					redirect('users/index/act/prof');
					
				}else{
					$this->session->set_userdata('VALIDATION_ERRORS', '<p>Connection request for the user "'.$user_res->first_name." ".$user_res->last_name.'" has pending </p>');
					redirect('internal_mail/index/act/notification');
				}
			}
		 }else{
			$val_message =  array(
							'title'            => 'Connection Confirmation',
							'content'          => '<p>This message was sent to an email address that is not associated with your CleanTekMarket account.</p>'
						);
			$this->session->set_userdata('VALIDATION_MESSAGE',$val_message);
			redirect('users/index/act/prof');
		} 
				
	}
/* 	function user_unlike_solution() {
        $this->load->model("users_model", "usersobj");
        $data['solution_id']                                                    = $_POST['sol_id'];
        $user_login                                                             = $this->session->userdata('USER');
        $data['user_id']                                                        = $user_login['ID'];
        $data['type']                                                           = 'solution';
        //$res=$this->usersobj->add_user_like($data);
        $result                                                                 = $this->usersobj->delete_user_like($data);
        if ($result) {
            $count                                                              = $this->usersobj->count_user_like($data);
            echo $count;
        } else {
            
            echo 0;
        }
    }
     */
    function user_like_group_discussion() {
    	$this->load->model("users_model", "usersobj");
    	$data['solution_id']                                                    = $_POST['group_discussion_id'];
    	$user_login                                                             = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user_login['ID'];
    	$data['type']                                                           = 'groupdiscussion';
    	//$res=$this->usersobj->add_user_like($data);
    	$result                                                                 = $this->usersobj->check_user_like($data);
    	if ($result) {
    		$this->usersobj->delete_user_like($data);
    		$count                                                              = $this->usersobj->count_user_like($data);
    		echo $count;
    	} else {
    		$res                                                                = $this->usersobj->add_user_like($data);
    		$count                                                              = $this->usersobj->count_user_like($data);
    		echo $count;
    	}
    }
    
    function user_unlike_group_discussion() {
    	$this->load->model("users_model", "usersobj");
    	$data['solution_id']                                                    = $_POST['group_discussion_id'];
    	$user_login                                                             = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user_login['ID'];
    	$data['type']                                                           = 'groupdiscussion';
    	//$res=$this->usersobj->add_user_like($data);
    	$result                                                                 = $this->usersobj->delete_user_like($data);
    	if ($result) {
    		$count                                                              = $this->usersobj->count_user_like($data);
    		echo $count;
    	} else {
    
    		echo 0;
    	}
    }
    
    function user_like_group() {
    	$this->load->model("users_model", "usersobj");
    	$data['solution_id']                                                    = $_POST['group_id'];
    	$user_login                                                             = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user_login['ID'];
    	$data['type']                                                           = 'group';
    	//$res=$this->usersobj->add_user_like($data);
    	$result                                                                 = $this->usersobj->check_user_like($data);
    	if ($result) {
    		$this->usersobj->delete_user_like($data);
    		$count                                                              = $this->usersobj->count_user_like($data);
    		echo $count;
    	} else {
    		$res                                                                = $this->usersobj->add_user_like($data);
    		$count                                                              = $this->usersobj->count_user_like($data);
    		echo $count;
    	}
    }
    
    function user_unlike_group() {
    	$this->load->model("users_model", "usersobj");
    	$data['solution_id']                                                    = $_POST['group_id'];
    	$user_login                                                             = $this->session->userdata('USER');
    	$data['user_id']                                                        = $user_login['ID'];
    	$data['type']                                                           = 'group';
    	//$res=$this->usersobj->add_user_like($data);
    	$result                                                                 = $this->usersobj->delete_user_like($data);
    	if ($result) {
    		$count                                                              = $this->usersobj->count_user_like($data);
    		echo $count;
    	} else {
    
    		echo 0;
    	}
    }
	
	function del_image($id='') {
		$this->load->model('users_model', 'usersobj');	
		$res 				                                                     = $this->usersobj->get($id);
		//unlink('images/profile_images/'.$res->profile_picture);
		$user_login 															= $this->session->userdata('USER');
		$user_login['USER_IMAGE']												= '';		
		$this->session->set_userdata('USER', $user_login);
		$data['profile_picture']='';
		$this->usersobj->update_user($id, $data);	
		 // to create the user logs <--
		 $user_login                                                    			= 	$this->session->userdata('USER');
		 $this->load->model('logs_model', 'logsobj');
		 $logs['user_id']															=	$id;
		 $logs['logs']																=	'Removed profile picture';
		 $logs['module']															= 	'prof';
		 $logs['item_id']															= 	$id;
		 $logs['item_name']															= 	$res->first_name." ".$res->last_name;
		 $logs['profile_image']														= 	'';
		 $this->logsobj->insert_logs($logs);
		//-->
		//$this->advance_register($id, 'edit');
		redirect("users/index/act/adv_edit");
		
	}
	
	function paypal_recurrent_payment_crone()
	{
		$this->load->model('users_order_model', 'orderobj');	
		$where['payment_type']													= 'paypal_direct';	
		$where['billing_periode']												= 'YEAR';	
		$res1 				                                                    = $this->orderobj->get($where); 
		$where['payment_type']													= 'paypal_direct';	
		$where['billing_periode']												= 'MONTH';	
		$res2 				                                                    = $this->orderobj->get($where);  
		$where['payment_type']													= 'paypal_express';	
		$where['billing_periode']												= 'YEAR';	
		$res3 				                                                    = $this->orderobj->get($where); 
		$where['payment_type']													= 'paypal_express';	
		$where['billing_periode']												= 'MONTH';	
		$res4 				                                                    = $this->orderobj->get($where); 
		$res																	= array_merge ( $res1,$res2,$res3,$res4);	
		if($res)
		{
			foreach ($res as $data)
			{
				$this->config->load('paypal');
				$config                                                                 = array(
																								'Sandbox'           => $this->config->item('Sandbox'), // Sandbox / testing mode option.
																								'APIUsername'       => $this->config->item('APIUsername'), // PayPal API username of the API caller
																								'APIPassword'       => $this->config->item('APIPassword'), // PayPal API password of the API caller
																								'APISignature'      => $this->config->item('APISignature'), // PayPal API signature of the API caller
																								'APISubject'        => '', // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
																								'APIVersion'        => $this->config->item('APIVersion')  // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
																							);
				$this->load->library('paypal/Paypal_pro', $config);	
				$GRPPDFields															= array(
																								'PROFILEID'				=>$data->profile_id
																							);			
				$DataArray                                                     			= array(
																								'GRPPDFields'         => $GRPPDFields																								
																							);				
				$paypalresult                                                           = $this->paypal_pro->GetRecurringPaymentsProfileDetails($DataArray);
				$where																	=array();
				$where['profile_id']													= $paypalresult['PROFILEID'] ;	
				$user_res			                                                    = $this->orderobj->get($where); 
				echo "<pre>";
				print_r($user_res);	
				print_r($paypalresult   )	;
				
				if($user_res)
				{
					$user_data['user_id']	=$user_res[0]->user_id;
					$user_data['payment_type']=$user_res[0]->payment_type;
					$user_data['country']	=$user_res[0]->country ;
					$user_data['state']		=$user_res[0]->state ;
					$user_data['city']		=$user_res[0]->city ;
					$user_data['street']	=$user_res[0]->street ;
					$user_data['post_code']	=$user_res[0]->post_code ;
					$user_data['phone']		=$user_res[0]->phone ;
					$user_data['billing_period']=$user_res[0]->billing_period ;
					$user_data['amount']	=$user_res[0]->amount ;
					$user_data['profile_id']=$user_res[0]->profile_id ;
					$user_data['cc_type']	=$user_res[0]->cc_type ;
					$user_data['cc_number']	=$user_res[0]->cc_number ;
					$user_data['cvv2']		=$user_res[0]->cvv2 ;
					$user_data['order_status']=$paypalresult['STATUS'] ;
					$this->orderobj->insert_order($user_data);		
					
					
					$this->load->library( 'email' );
					$this->email->from( CLEANTEK_EMAIL, CLEANTEK_EMAIL_NAME );
					$this->email->to( $user_res[0]->email );
					$this->email->subject( 'Recurrent Payment - CleanTekMarket' );
					$this->email->set_mailtype("html");
					$emaildata['message']='<p>Your recurrent payment for CleanTekMarket subscription  completed successfully</p>  <p>Thank you</p> <p>cleantekmarket.com</p>';
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send();
					//exit;		
					$this->load->helper('send_notification');		
					$message="<p>You have completed the registration successfully</p>  <p>Thank you</p> <p>cleantekmarket.com</p>";
					$receviors_id=array($user_res[0]->user_id);
					send_notification('0',$receviors_id,$message,'Recurrent Payment - CleanTekMarket');	
				}
				//echo 'user id '.$data->user_id." is ".$paypalresult['STATUS'] ."<br>";
				//exit;
			}
		}	
	}
	  function google_checkout() {
	
        //load the google checkout library
	     $this->load->library('google_checkout/gcheckout');
       
        //setup the variables for google checkout (of course you don't have to do iot this way but this is pulling values from a config file)
		 
		//echo  $this->config->item('checkout_merchant_id');
		$this->config->load('google_checkout');
        $merchant_id  = $this->config->item('checkout_merchant_id');
        $merchant_key = $this->config->item('checkout_merchant_key');
        $server_type  = $this->config->item('checkout_server_type');
        $currency     = $this->config->item('checkout_currency');
        $edit_url     = $this->config->item('checkout_edit_url');
        $shop_url     = $this->config->item('checkout_shop_url');
        
        //initialize the checkout
	     $this->gcheckout->init($merchant_id, $merchant_key, $server_type, $currency );
        
        //set the trackback urls
        $this->gcheckout->set_cart_urls($edit_url, $shop_url);        
      
		echo $this->gcheckout->do_checkout();
    }

	function google_checkout_response() {
		$this->load->library('google_checkout/googleresponse');
		$xml_response = isset($HTTP_RAW_POST_DATA)?
				$HTTP_RAW_POST_DATA:file_get_contents("php://input");
		$raw_xml = $xml_response;
		$this->load->model('users_order_model', 'orderobj');
		$logfile = "google_checkout_logs.txt";		
		$fh = fopen($logfile, 'a+') or die("can't open file");
		$stringData =  "\r\n\r\n<-------------------------".date('Y-M-d g:i a')."------------------------->\r\n\r\n". $raw_xml."";			
		fwrite($fh, $stringData);	
	
		list($root, $data) = $this->googleresponse->GetParsedXML($raw_xml);
		print_r( $data);
	
	 	if(isset($data['new-order-notification']['shopping-cart']['items']['item']['merchant-private-item-data']['VALUE']) && $data['new-order-notification']['shopping-cart']['items']['item']['merchant-private-item-data']['VALUE']!='')
		{
			$data['google_order_number']	=$data['new-order-notification']['google-order-number']['VALUE'];
			$data['buyer_id']	=$data['new-order-notification']['buyer-id']['VALUE'];
			$this->usersobj->update__google_checkout_temp($data['new-order-notification']['shopping-cart']['items']['item']['merchant-private-item-data']['VALUE'],$data); 
			
			$stringData =  "\r\n\r\n<############1############>\r\n\r\n";			
			fwrite($fh, $stringData);
			
		}else if( isset($data['new-order-notification']['shopping-cart']['items']['item']['item-description']['VALUE'])  && $data['new-order-notification']['shopping-cart']['items']['item']['item-description']['VALUE']!='' )
		{
			$stringData =  "\r\n\r\n<############ 1.5 ############>\r\n\r\n";			
			fwrite($fh, $stringData);
			$where['user_id']=$data['new-order-notification']['shopping-cart']['items']['item']['item-description']['VALUE'];
			$order_res=$this->orderobj->get($where);
			print_R($order_res);
			if(!empty($order_res))
			{
				$temp_data['bill_country']			=	$order_res[0]->country ;
				$temp_data['bill_state']			=	$order_res[0]->state ;
				$temp_data['bill_city']				=	$order_res[0]->city ;
				$temp_data['bill_street']			=	$order_res[0]->street ;
				$temp_data['bill_postcode']			=	$order_res[0]->post_code ;
				$temp_data['bill_phone']			=	$order_res[0]->phone ;
				$temp_data['billing_period']		=	$order_res[0]->billing_period ;
				$temp_data['amount']				=	$order_res[0]->amount ;
				$temp_data['user_id']				=	$order_res[0]->user_id ;
				$temp_data['google_order_number']	=	$data['new-order-notification']['google-order-number']['VALUE'];
				$temp_data['buyer_id']				=	$data['new-order-notification']['buyer-id']['VALUE'];
				$this->usersobj->insert_google_checkout_temp($temp_data);
				
				$stringData =  "\r\n\r\n<############ 2 ############>\r\n\r\n";			
				fwrite($fh, $stringData);
			}	
				
			
		}
	
		if(isset($data['order-state-change-notification']['new-financial-order-state']['VALUE']) && $data['order-state-change-notification']['new-financial-order-state']['VALUE']=='CHARGED' && isset($data['order-state-change-notification']['new-fulfillment-order-state']['VALUE']) && $data['order-state-change-notification']['new-fulfillment-order-state']['VALUE']=='DELIVERED')
		{	
			$stringData =  "\r\n\r\n<############ 3 ############>\r\n\r\n";			
			fwrite($fh, $stringData);
			$temp_data=$this->usersobj->get_google_temp($data['order-state-change-notification']['google-order-number']['VALUE']);	
			
			if(!empty($temp_data))
			{
				$stringData =  "\r\n\r\n<############ 4 ############>\r\n\r\n";			
				fwrite($fh, $stringData);
				if(isset($temp_data->email) && $temp_data->email!='')
				{
					$stringData =  "\r\n\r\n<############ 5 ############>\r\n\r\n";			
					fwrite($fh, $stringData);
					//new order-->
					
					//update user details
					$data['first_name']	=	$temp_data->first_name;
					$data['last_name']	=	$temp_data->last_name;
					$data['email']		=	$temp_data->email;
					$data['user_type']	=	$temp_data->user_type;
					$data['company_name']=	$temp_data->company_name;
					$data['company_location']=	$temp_data->company_location;
					$data['country']	=	$temp_data->country;
					$data['state']		=	$temp_data->state;
					$data['city']		=	$temp_data->city;
					$data['street']		=	$temp_data->street;
					$data['profile_description']=	$temp_data->profile_description;								
					$this->usersobj->update_user($temp_data->user_id, $data);	
					
				}
				$stringData =  "\r\n\r\n<############ 6 ############>\r\n\r\n";			
				fwrite($fh, $stringData);
				//insert new order
				$bill_data['user_id']													= $temp_data->user_id;
				$bill_data['transaction_id']											= $temp_data->google_order_number;
				$bill_data['payment_type']												= 'google_checkout';			
				$bill_data['country']													= $temp_data->bill_country;	
				$bill_data['state']														= $temp_data->bill_state;
				$bill_data['city']														= $temp_data->bill_city;
				$bill_data['street']													= $temp_data->bill_street;
				$bill_data['post_code']													= $temp_data->bill_postcode;
				$bill_data['phone']														= $temp_data->bill_phone;		
				$bill_data['billing_period']											= $temp_data->billing_period;		
				$bill_data['amount']													= $temp_data->amount;	
				$bill_data['profile_id']												= $temp_data->buyer_id;		
				$bill_data['order_status']												= 'Active';		
				$order_id=$this->orderobj->insert_order($bill_data); 
				$this->load->model('businessfeature_model','bfobj');
				$plan_details=$this->bfobj->get_bussinessmodel_features($temp_data->businessmodel_id );
				if(!empty($plan_details ))
				{
					foreach($plan_details as $raw)
					{
						$plan_data['user_id']=$temp_data->user_id;
						$plan_data['plan_title']=$raw->plan_title;
						$plan_data['plan_id']=$raw->businessmodel_id;
						$plan_data['planfeature_id']=$raw->planfeature_id;
						$plan_data['planfeature_title']=$raw->feature_title;
						$plan_data['business_feature_id']=$raw->businessfeature_id;
						$plan_data['feature_value']=$raw->businessfeatureval;
						$plan_data['order_id']=$order_id;
						$this->bfobj->insert_user_businessmodel($plan_data); 
					}
				}
				// to create the user logs <--
				 $logs['user_id']															=	$bill_data['user_id'];
				 $logs['logs']																=	'profile upgraded';
				 $logs['module']															= 	'prof';
				 $logs['item_id']															= 	$bill_data['user_id'];
				 $logs['item_name']															= 	$temp_data->first_name." ".$temp_data->last_name;
				 $this->logsobj->insert_logs($logs);
				//-->
				//Delete temp data from google checkout temp table
				$this->usersobj->delete_google_checkout_temp($temp_data->google_order_number);
				
			}
			
			
		}  
		
			
		
				
	}
	
	function collect_name()
	{
		
		$first_name	=$this->input->post('first_name');
		$last_name	=$this->input->post('last_name');
		$user_login                                                     = $this->session->userdata('USER');
		if($first_name=='' || $last_name=='')
		{
		
			if (isset($user_login) && $user_login['ID'] != "") {  
				if($user_login['FIRST_NAME']=='')
				{
					
					$this->load->view('collect_name');
				}else{
					redirect('users');
				}
			}else{
					redirect('users');
				}
		}else{
			$data['first_name']=$this->input->post('first_name');
			$data['last_name']=$this->input->post('last_name');		
			$this->usersobj->update_user($user_login['ID'], $data);
			$row	=$this->usersobj->get($user_login['ID']);
			$this->load->library('encrypt');
			$soc_media_array                                            	= array(
																			'EMAIL'		=> $row->email,
																			'PASSWORD'  => $this->encrypt->decode($row->password)
																		);
			$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
			$this->check_login();
		}		
	}
	function ajax_subcategories()
	{	
		$this->load->model('product_model', 'prodobj');
		$sub_categories 		=array();
		$parent_id				=	$_POST['cat_ids'];
		/* $parent_cat_ids			=	substr($category, 0, -1);
		$parent_cat_ids			=	explode(",",$parent_cat_ids); */
		
		//foreach($parent_cat_ids	 as $parent_id){
		//	$ids[]				=	$parent_id;
		$sub_categories			=	$this->prodobj->getDepthCategories($parent_id);
		if($sub_categories){
			foreach($sub_categories as $row)
				$ids[] =	$row->categories_id;
				echo json_encode($ids);
		}
	}
	function ajax_advisor_subcategories()
	{	
		$this->load->model('advisor_categorys_model', 'adv_cat');
		$sub_categories 		=array();
		$parent_id				=	$_POST['cat_ids'];
		$sub_categories			=	$this->adv_cat->getAdvisorDepthCategories($parent_id);
		if($sub_categories){
			foreach($sub_categories as $row)
				$ids[] =	$row->id;
				echo json_encode($ids);
		}else{
			echo json_encode(array());
		}
	}
		
	function del_atchmnt($attachment_type='') {
		if($this->user_id)
		{
			$res	=$this->usersobj->get($this->user_id );		
			if($attachment_type=='portfolio')
			{
				$portfolio=json_decode($res->portfolio);
				unlink('images/users/portfolio/'.$portfolio->path_name);			
				$data['portfolio']='';
			}else if($attachment_type=='funding_specification')
			{
				$funding_specification=json_decode($res->funding_specification);
				unlink('images/users/funding_specification/'.$funding_specification->path_name);
				$data['funding_specification']='';
			}else if($attachment_type=='restrictions')
			{
				$restrictions=json_decode($res->restrictions);
				unlink('images/users/restrictions/'.$restrictions->path_name);
				$data['restrictions']='';
			}else if($attachment_type=='assumptions')
			{
				$assumptions=json_decode($res->assumptions);
				unlink('images/users/assumptions/'.$assumptions->path_name);
				$data['assumptions']='';
			}else if($attachment_type=='financial_summary')
			{
				$financial_summary=json_decode($res->financial_summary);
				unlink('images/users/financial_summary/'.$financial_summary->path_name);
				$data['financial_summary']='';
			}else if($attachment_type=='company_details')
			{
				$company_details=json_decode($res->company_details);
				unlink('images/users/company_details/'.$company_details->path_name);
				$data['company_details']='';
			}else if($attachment_type=='supplimentary_material')
			{
				$supplimentary_material=json_decode($res->supplimentary_material);
				unlink('images/users/supplimentary_material/'.$supplimentary_material->path_name);
				$data['supplimentary_material']='';
			}else if($attachment_type=='publication')
			{
				$publication=json_decode($res->publication);
				unlink('images/users/publication/'.$publication->path_name);
				$data['publication']='';
			}else if($attachment_type=='cv')
			{
				$cv=json_decode($res->cv);
				unlink('images/users/cv/'.$cv->path_name);
				$data['cv']='';
			}else if($attachment_type=='terms')
			{
				$terms=json_decode($res->terms);
				unlink('images/users/terms/'.$terms->path_name);
				$data['terms']='';
			}
			$this->usersobj->update_user($this->user_id, $data);
			$this->advance_register($this->user_id,'edit');
		}else
		{
			redirect('users');
		}
			
		
	}
	function benchmark_update_crone($user_id='')
	{
		$check_user['user_id']	=$user_id;
		$this->load->model('bulk_message_model', 'bulkobj');
		$this->load->library('benchmark_email/BMEAPI');
		set_time_limit ( 0 );
		$this->load->model('category_model', 'catobj');
		$this->load->model('group_model', 'groupobj');
		$this->load->library('benchmark_email/BMEAPI');	
		$new_category_list_id=array();
		$new_country_list_id=array();
		$logfile = "benchmark_update_crone_logs.txt";		
		$fh = fopen($logfile, 'a+') or die("can't open file");
		//$fh = fopen($logfile, 'w') or die("can't open file");
		$stringData =  "\r\n\r\n<-------------------------".date('Y-M-d g:i a')."------------------------->\r\n\r\n";			
		fwrite($fh, $stringData);	
		$user_res=$this->bulkobj->get_users($check_user);
		//$user_res=array();
		//print_r($user_res);		
		// exit;
		
		$count=1;
		$ids=array();
		foreach ($user_res as $user)
		{			
			$stringData =  "\r\n"."    ".$count.". < user :".$user->first_name." ".$user->last_name.' id : '.$user->id.">\r\n";		
			fwrite($fh, $stringData);
			$new_id=0;
			if(!in_array($user->id,$ids))
			{
				$new_id=1;
				array_push($ids,$user->id);
			}
			if($user->categories_name!='')
			{
				/*created new list in benchmark for new category */	
				if($user->BM_category_list_id=='')
				{	
					
					if(!isset($new_category_list_id[$user->categories_id]))
					{
						 //<-- email marketing list creation 
							$list_id = $this->bmeapi->listCreate($user->categories_name);
							
							if($list_id)
							{
								$data	=array();
								$data['BM_category_list_id']		=	$list_id;
								$new_category_list_id[$user->categories_id]	=$data['BM_category_list_id']	;
								/*creating  webhook for the list */
								$webhookDetails["contact_list_id"] = $list_id;
								$webhookDetails["unsubscribes"] = "y";
								$webhookDetails["url"] = base_url().'users/BM_webhook_response';
								$retval =$this->bmeapi->webhookCreate($webhookDetails);
								/*-->*/
							}	
							else
							{
								echo "\n\t benchmark Code=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								print_r($user);
								$stringData =  "\r\n"."         <  bencmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
								fwrite($fh, $stringData);
								exit;
							} 
						//-->
						$this->catobj->update_categoties($data,$user->categories_id);
						$stringData =  "\r\n"."         < created a new list for category : ".$user->categories_name." with id : ".$list_id."> \r\n";		
						fwrite($fh, $stringData);
					}	
				}
				/*add users to category list*/
				if($user->BM_category_list_id=='')
				{	
					//<--  Add contacts to email marketing category list 
					$details[0]["email"] 	= $user->email;
					$details[0]["firstname"]= $user->first_name;	
					$details[0]["lastname"] = $user->last_name;	
					$retval = $this->bmeapi->listAddContacts($new_category_list_id[$user->categories_id], $details);						
					if($retval){	
						$stringData =  "\r\n"."         <  Add user to new category contact list of id : ".$new_category_list_id[$user->categories_id]." and name = ".$user->categories_name."> \r\n";		
						fwrite($fh, $stringData);
						$data=array();
						$data['list_id']=$new_category_list_id[$user->categories_id];
						$data['user_id']=$user->id;
						$data['user_email']=$user->email;
						$data['reference_module']='category';
						$data['reference_id']=$user->categories_id;
						$this->bulkobj->insert_benchmark($data);
						//echo $retval;
					}	
					else
					{
						
						echo "\n\tCode=". $this->bmeapi->errorCode;
						echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
						print_r($user);
						$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
						fwrite($fh, $stringData);
						exit;
					}
					//--> 
					
				}else{
					$where['list_id']			=$user->BM_category_list_id;
					$where['user_id']			=$user->id;
					$where['reference_module']	='category';
					$where['reference_id']		=$user->categories_id;
					$list_res=	$this->bulkobj->get_benchmark($where);
					if(isset($list_res) && !empty($list_res))
					{
						$data=array();
						$data['need_delete']=0;
						$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data);
						$stringData =  "\r\n"."         <  user already exist in category list :".$user->categories_name."> \r\n";		
						fwrite($fh, $stringData);
						
					}else{
						//<--  Add contacts to email marketing category list 
						$details[0]["email"] 	= $user->email;
						$details[0]["firstname"]= $user->first_name;	
						$details[0]["lastname"] = $user->last_name;	
						$retval = $this->bmeapi->listAddContacts($user->BM_category_list_id, $details);						
						if($retval){	
							$stringData =  "\r\n"."         <  Add user to category contact list of id : ".$user->BM_category_list_id."> \r\n";		
							fwrite($fh, $stringData);	
							$data=array();
							$data['list_id']=$user->BM_category_list_id;
							$data['user_id']=$user->id;
							$data['user_email']=$user->email;
							$data['reference_module']='category';
							$data['reference_id']=$user->categories_id;
							$this->bulkobj->insert_benchmark($data);	
						}	
						else
						{
							
							echo "\n\tCode=". $this->bmeapi->errorCode;
							echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
							print_r($user);
							$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
							fwrite($fh, $stringData);
							exit;
						}
						//--> 
							
						
					}
				}
				
			}else
			{
				$stringData =  "\r\n"."         < User category is null > \r\n";		
				fwrite($fh, $stringData);
			}			
			if($user->cleantek_user_category=='investor')
			{
				$where=array();
				$where['list_id']			= BM_INVESTORS_LIST_ID;
				$where['user_id']			= $user->id;
				$where['reference_module']	= 'investor';
				$where['reference_id']		= $user->id;
				$list_res=	$this->bulkobj->get_benchmark($where);
				if(isset($list_res) && !empty($list_res))
				{
					$data=array();
					$data['need_delete']=0;
					$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data);
					$stringData =  "\r\n"."         <  user already exist in investors list> \r\n";		
					fwrite($fh, $stringData);
					
				}else{
					//<--  Add contacts to email marketing investors list 
					$details[0]["email"] 	= $user->email;
					$details[0]["firstname"]= $user->first_name;	
					$details[0]["lastname"] = $user->last_name;	
					$retval = $this->bmeapi->listAddContacts(BM_INVESTORS_LIST_ID, $details);						
					if($retval){	
						$stringData =  "\r\n"."         <  Add user to investors contact list of id : ".BM_INVESTORS_LIST_ID."> \r\n";		
						fwrite($fh, $stringData);	
						$data=array();
						$data['list_id']=BM_INVESTORS_LIST_ID;
						$data['user_id']=$user->id;
						$data['user_email']=$user->email;
						$data['reference_module']='investor';
						$data['reference_id']=$user->id;
						$this->bulkobj->insert_benchmark($data);	
					}	
					else
					{
						
						echo "\n\tCode=". $this->bmeapi->errorCode;
						echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
						print_r($user);
						$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
						fwrite($fh, $stringData);
						exit;
					}
					//--> 
						
					
				}
			}else if($user->cleantek_user_category=='advisor')
			{
				$where=array();
				$where['list_id']			= BM_ADVISORS_LIST_ID;
				$where['user_id']			= $user->id;
				$where['reference_module']	= 'advisor';
				$where['reference_id']		= $user->id;
				$list_res=	$this->bulkobj->get_benchmark($where);
				if(isset($list_res) && !empty($list_res))
				{
					$data=array();
					$data['need_delete']=0;
					$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data);
					$stringData =  "\r\n"."         <  user already exist in advisors list> \r\n";		
					fwrite($fh, $stringData);
					
				}else{
					//<--  Add contacts to email marketing advisors list 
					$details[0]["email"] 	= $user->email;
					$details[0]["firstname"]= $user->first_name;	
					$details[0]["lastname"] = $user->last_name;	
					$retval = $this->bmeapi->listAddContacts(BM_ADVISORS_LIST_ID, $details);						
					if($retval){	
						$stringData =  "\r\n"."         <  Add user to advisors contact list of id : ".BM_ADVISORS_LIST_ID."> \r\n";		
						fwrite($fh, $stringData);	
						//echo $retval;
						$data=array();
						$data['list_id']=BM_ADVISORS_LIST_ID;
						$data['user_id']=$user->id;
						$data['user_email']=$user->email;
						$data['reference_module']='advisor';
						$data['reference_id']=$user->id;
						$this->bulkobj->insert_benchmark($data);	
					}	
					else
					{
						
						echo "\n\tCode=". $this->bmeapi->errorCode;
						echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
						print_r($user);
						$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
						fwrite($fh, $stringData);
						exit;
					}
					//--> 
						
					
				}
			}else if($user->cleantek_user_category=='general')
			{
				$where=array();
				$where['list_id']			= BM_GENERAL_USERS_LIST_ID;
				$where['user_id']			= $user->id;
				$where['reference_module']	= 'general';
				$where['reference_id']		= $user->id;
				$list_res=	$this->bulkobj->get_benchmark($where);
				if(isset($list_res) && !empty($list_res))
				{
					$data=array();
					$data['need_delete']=0;
					$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data);
					$stringData =  "\r\n"."         <  user already exist in general users list> \r\n";		
					fwrite($fh, $stringData);
					
				}else{
					//<--  Add contacts to email marketing general users list 
					$details[0]["email"] 	= $user->email;
					$details[0]["firstname"]= $user->first_name;	
					$details[0]["lastname"] = $user->last_name;	
					$retval = $this->bmeapi->listAddContacts(BM_GENERAL_USERS_LIST_ID, $details);						
					if($retval){	
						$stringData =  "\r\n"."         <  Add user to general users  contact list of id : ".BM_GENERAL_USERS_LIST_ID."> \r\n";		
						fwrite($fh, $stringData);	
						$data=array();
						$data['list_id']=BM_GENERAL_USERS_LIST_ID;
						$data['user_id']=$user->id;
						$data['user_email']=$user->email;
						$data['reference_module']='general';
						$data['reference_id']=$user->id;
						$this->bulkobj->insert_benchmark($data);	
					}	
					else
					{
						
						echo "\n\tCode=". $this->bmeapi->errorCode;
						echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
						print_r($user);
						$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
						fwrite($fh, $stringData);
						exit;
					}
					//--> 
						
					
				}
			}
			if($new_id==1)
			{
				/*created new list in benchmark for new country */	
				if($user->country_name!='')
				{
					if($user->BM_Country_list_Id=='')
					{	
						
						if(!isset($new_country_list_id[$user->country_code]))
						{
							 //<-- email marketing list creation for country
								$list_id = $this->bmeapi->listCreate($user->country_name);
								
								if($list_id)
								{
									$new_country_list_id[$user->country_code]	=$list_id	;
									/*creating  webhook for the list */
									$webhookDetails["contact_list_id"] = $list_id;
									$webhookDetails["unsubscribes"] = "y";
									$webhookDetails["url"] = base_url().'users/BM_webhook_response';
									$retval =$this->bmeapi->webhookCreate($webhookDetails);
									/*-->*/
								}	
								else
								{
									echo "\n\t benchmark Code=". $this->bmeapi->errorCode;
									echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
									print_r($user);
									$stringData =  "\r\n"."         <  bencmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
									fwrite($fh, $stringData);
									exit;
								} 
							//-->
							$this->bulkobj->update_country($user->country_code,$list_id);
							$stringData =  "\r\n"."         < created a new list for country : ".$user->country_name." with id : ".$list_id."> \r\n";		
							fwrite($fh, $stringData);
						}	
					}
					/*add users to country list*/
					if($user->BM_Country_list_Id=='')
					{	
						
						//<--  Add contacts to email marketing country list 
						$details[0]["email"] 	= $user->email;
						$details[0]["firstname"]= $user->first_name;	
						$details[0]["lastname"] = $user->last_name;	
						$retval = $this->bmeapi->listAddContacts($new_country_list_id[$user->country_code], $details);						
						if($retval){	
							$stringData =  "\r\n"."         <  Add user to new country  list of id : ".$new_country_list_id[$user->country_code]." and name = ".$user->country_name."> \r\n";		
							fwrite($fh, $stringData);	
							$data=array();
							$data['list_id']=$new_country_list_id[$user->country_code];
							$data['user_id']=$user->id;
							$data['user_email']=$user->email;
							$data['reference_module']='country';
							$data['reference_id']=$user->country_code;
							$this->bulkobj->insert_benchmark($data);
						}	
						else
						{
							
							echo "\n\tCode=". $this->bmeapi->errorCode;
							echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
							print_r($user);
							$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
							fwrite($fh, $stringData);
							exit;
						}
						//--> 
						
					}else{
						$where['list_id']			=$user->BM_Country_list_Id;
						$where['user_id']			=$user->id;
						$where['reference_module']	='country';
						$where['reference_id']		=$user->country_code;
						$list_res=	$this->bulkobj->get_benchmark($where);
						if(isset($list_res) && !empty($list_res))
						{
							/* $data=array();
							$data['need_delete']=0;
							$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data); */
							$stringData =  "\r\n"."         <  user already exist in country list :".$user->country_name."> \r\n";		
							fwrite($fh, $stringData);
							
						}else{
							//<--  Add contacts to email marketing country list 
							$details[0]["email"] 	= $user->email;
							$details[0]["firstname"]= $user->first_name;	
							$details[0]["lastname"] = $user->last_name;	
							$retval = $this->bmeapi->listAddContacts($user->BM_Country_list_Id, $details);						
							if($retval){	
								$stringData =  "\r\n"."         <  Add user to country contact list of id : ".$user->BM_Country_list_Id."> \r\n";		
								fwrite($fh, $stringData);	
								/*delete from country list if there occure any country assigned for same user*/
								$where['list_id']			=$user->BM_Country_list_Id;
								$where['user_id']			=$user->id;
								$where['reference_module']	='country';
								$list_res=	$this->bulkobj->get_benchmark($where);
								if(isset($list_res) && !empty($list_res))
								{
									$data=array();
									$data['need_delete']=1;
									$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data);
									$stringData =  "\r\n"."         <  change user 'need_delete 'status to 1 for deleting  from country list :".$list_res[0]->list_id."> \r\n";		
									fwrite($fh, $stringData);

								}
								/*adding new contacts to DB*/
								$data=array();
								$data['list_id']=$user->BM_Country_list_Id;
								$data['user_id']=$user->id;
								$data['user_email']=$user->email;
								$data['reference_module']='country';
								$data['reference_id']=$user->country_code;
								$this->bulkobj->insert_benchmark($data);		
							
							}	
							else
							{
								
								echo "\n\tCode=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								print_r($user);
								$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
								fwrite($fh, $stringData);
								exit;
							}
							//--> 
							
						}
					}
				}	
				else
				{
					$stringData =  "\r\n"."         < Country name is null> \r\n";		
					fwrite($fh, $stringData);
				}	
			}else
			{
				$stringData =  "\r\n"."         < Repeating same user for same country :".$user->country_name."> \r\n";		
				fwrite($fh, $stringData);
			}
			/*Adding users to level 1 list*/
			if($new_id==1)
			{	/*checking user exist in any list(level1 or level 2)*/
				$where=array();
				$where['list_id']			= BM_LEVEL2_LIST_ID;
				$where['user_id']			= $user->id;
				$where['reference_module']	= 'level2';
				$where['reference_id']		= $user->id;
				$list_res=	$this->bulkobj->get_benchmark($where);
				if(isset($list_res) && !empty($list_res))
				{
					$stringData =  "\r\n"."         < User already added in level 2 list> \r\n";		
					fwrite($fh, $stringData);
				}else{
					$where=array();
					$where['list_id']			= BM_LEVEL1_LIST_ID;
					$where['user_id']			= $user->id;
					$where['reference_module']	= 'level1';
					$where['reference_id']		= $user->id;
					$list_res=	$this->bulkobj->get_benchmark($where);
					if(isset($list_res) && !empty($list_res))
					{
						$stringData =  "\r\n"."         < User already added in level 1 list> \r\n";		
						fwrite($fh, $stringData);
					}else{
						$details[0]["email"] 	= $user->email;
						$details[0]["firstname"]= $user->first_name;	
						$details[0]["lastname"] = $user->last_name;	
						$retval = $this->bmeapi->listAddContacts(BM_LEVEL1_LIST_ID, $details);						
						if($retval){	
							$stringData =  "\r\n"."         <  Add user to Level 1 users  contact list of id : ".BM_LEVEL1_LIST_ID."> \r\n";		
							fwrite($fh, $stringData);	
							$data=array();
							$data['list_id']=BM_LEVEL1_LIST_ID;
							$data['user_id']=$user->id;
							$data['user_email']=$user->email;
							$data['reference_module']='level1';
							$data['reference_id']=$user->id;
							$this->bulkobj->insert_benchmark($data);
						}	
						else
						{
							
							echo "\n\tCode=". $this->bmeapi->errorCode;
							echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
							print_r($user);
							$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
							fwrite($fh, $stringData);
							exit;
						}
						//--> 
						
					}
				}
			}else
			{
				$stringData =  "\r\n"."         < Repeating same user for same list> \r\n";		
				fwrite($fh, $stringData);
			}
			
			$count++;
			//exit;
			
		}
		
		$user_order_res=$this->bulkobj->get_user_orders($check_user);
		//$user_order_res=array();
				
		foreach($user_order_res as $order)
		{	
			
			
			$stringData =  "\r\n"."    ".$count.". < user :".$order->first_name." ".$order->last_name.' id : '.$order->userid.">\r\n";		
			fwrite($fh, $stringData);
			if($order->email)
				{
				if($order->order_status=='Active')
				{
					$where=array();
					$where['list_id']			= BM_LEVEL2_LIST_ID;
					$where['user_id']			= $order->userid;
					$where['reference_module']	= 'level2';
					$where['reference_id']		= $order->userid;
					$list_res=	$this->bulkobj->get_benchmark($where);
					if(isset($list_res) && !empty($list_res))
					{
						/* $data=array();
						$data['need_delete']=0;
						$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data); */
						$stringData =  "\r\n"."         <  user already exist in level2 users list> \r\n";		
						fwrite($fh, $stringData);
						
					}else{
						
						if( $order->email)
						{
							//<--  Add contacts to email marketing level 2 users list 
							$details[0]["email"] 	= $order->email;
							$details[0]["firstname"]= $order->first_name;	
							$details[0]["lastname"] = $order->last_name;						
							$retval = $this->bmeapi->listAddContacts(BM_LEVEL2_LIST_ID, $details);						
							if($retval){	
								$stringData =  "\r\n"."         <  Add user to Level 2 users  contact list of id : ".BM_LEVEL2_LIST_ID."> \r\n";		
								fwrite($fh, $stringData);	
								$data=array();
								$data['list_id']=BM_LEVEL2_LIST_ID;
								$data['user_id']=$order->userid;
								$data['user_email']=$order->email;
								$data['reference_module']='level2';
								$data['reference_id']=$order->userid;
								$this->bulkobj->insert_benchmark($data);
							}	
							else
							{
								
								echo "\n\tCode=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								print_r($order);
								$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
								fwrite($fh, $stringData);
								exit;
							}
							//--> 
							
						}		
						
						/*deleting users who upgraded to level 2, from level 1 list*/
						$where=array();
						$where['list_id']			= BM_LEVEL1_LIST_ID;
						$where['user_id']			= $order->userid;
						$where['reference_module']	= 'level1';
						$where['reference_id']		= $order->userid;
						$delete_user_order_res=	$this->bulkobj->get_benchmark($where);	
						if(isset($delete_user_order_res) && !empty($delete_user_order_res))
						{
							 //<--  delete contacts from email marketing list 
							$retval=$this->bmeapi->listDeleteEmailContact(BM_LEVEL1_LIST_ID,$order->email);
							if($retval){
								$stringData =  "\r\n"."         <  Delete user from Level 1 users  contact list of id : ".BM_LEVEL1_LIST_ID."> \r\n";		
								fwrite($fh, $stringData);	
								/*deleting user from DB*/
								$this->bulkobj->delete_benchmark($delete_user_order_res[0]->benchmark_crone_id);	
							}	
							else
							{
								echo "\n\tCode=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								print_r($order);
								$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
								fwrite($fh, $stringData);
								exit;
							}
							//-->  
							
							
						}
					}			
				}else{
					$where=array();
					$where['list_id']			= BM_LEVEL1_LIST_ID;
					$where['user_id']			= $order->userid;
					$where['reference_module']	= 'level1';
					$where['reference_id']		= $order->userid;
					$list_res=	$this->bulkobj->get_benchmark($where);
					if(isset($list_res) && !empty($list_res))
					{
						/* $data=array();
						$data['need_delete']=0;
						$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data); */
						$stringData =  "\r\n"."         <  user already exist in level 1 users list> \r\n";		
						fwrite($fh, $stringData);
						
					}else{
						//<--  Add contacts to email marketing level 1 users list 
						$details[0]["email"] 	= $order->email;
						$details[0]["firstname"]= $order->first_name;	
						$details[0]["lastname"] = $order->last_name;	
						$retval = $this->bmeapi->listAddContacts(BM_LEVEL1_LIST_ID, $details);						
						if($retval){	
							$stringData =  "\r\n"."         <  Add user to Level 1 users  contact list of id : ".BM_LEVEL1_LIST_ID."> \r\n";		
							fwrite($fh, $stringData);	
							$data=array();
							$data['list_id']=BM_LEVEL1_LIST_ID;
							$data['user_id']=$order->userid;
							$data['user_email']=$order->email;
							$data['reference_module']='level1';
							$data['reference_id']=$order->userid;
							$this->bulkobj->insert_benchmark($data);	
						}	
						else
						{
							
							echo "\n\tCode=". $this->bmeapi->errorCode;
							echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
							print_r($order);
							$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
							fwrite($fh, $stringData);
							exit;
						}
						//--> 
						
						
						/*deleting users whose profile expired, from level 1 list*/
						$where=array();
						$where['list_id']			= BM_LEVEL2_LIST_ID;
						$where['user_id']			= $order->userid;
						$where['reference_module']	= 'level2';
						$where['reference_id']		= $order->userid;
						$delete_user_order_res=	$this->bulkobj->get_benchmark($where);	
						if(isset($delete_user_order_res) && !empty($delete_user_order_res))
						{
							 //<--  delete contacts from email marketing level 2 list 
							$retval=$this->bmeapi->listDeleteEmailContact(BM_LEVEL2_LIST_ID,$order->email);
							if($retval){
								$stringData =  "\r\n"."         <  Delete user from Level 2 users  contact list of id : ".BM_LEVEL2_LIST_ID."> \r\n";		
								fwrite($fh, $stringData);	
								/*deleting user from DB*/
								$this->bulkobj->delete_benchmark($delete_user_order_res[0]->benchmark_crone_id);	
							
							}	
							else
							{
								echo "\n\tCode=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								print_r($order);
								$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
								fwrite($fh, $stringData);
								exit;
							}
							//-->  
							
						}
					}
					
					
				}				
			}else
			{	
				$stringData =  "\r\n"."         <  Order emai is null> \r\n";		
				fwrite($fh, $stringData);
				
			}
			$count++;	
		}
		$new_group_list_id=array();
		$group_res=$this->bulkobj->get_join_group($check_user);
		//$group_res=array();
		//print_r($group_res);
		//exit;
		foreach($group_res as $group)
		{		
			$stringData =  "\r\n"."    ".$count.". < user :".$group->first_name." ".$group->last_name.' id : '.$group->user_id.">\r\n";		
			fwrite($fh, $stringData);
			if($group->group_name)
			{
				if($group->BM_list_id=='')
				{	

					if(!isset($new_group_list_id[$group->group_id]))
					{
						//<-- email marketing list creation for group 
							$list_id = $this->bmeapi->listCreate($group->group_name);
							
							if($list_id)
							{
								$data	=array();
								$data['BM_list_id']		=	$list_id;
								$new_group_list_id[$group->group_id]	=$data['BM_list_id'];
								/*creating  webhook for the list */
								$webhookDetails["contact_list_id"] = $list_id;
								$webhookDetails["unsubscribes"] = "y";
								$webhookDetails["url"] = base_url().'users/BM_webhook_response';
								$retval =$this->bmeapi->webhookCreate($webhookDetails);
								/*-->*/
							}	
							else
							{
								echo "\n\t benchmark Code=". $this->bmeapi->errorCode;
								echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
								print_r($group);
								$stringData =  "\r\n"."         <  bencmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
								fwrite($fh, $stringData);
								exit;
							} 
						//-->
						$this->groupobj->update_group($group->group_id,$data);
						$stringData =  "\r\n"."         < created a new list for group : ".$group->group_name." with id : ".$list_id."> \r\n";		
						fwrite($fh, $stringData);
					}
				}	
				/*add users to group list*/
				if($group->BM_list_id=='')
				{	
					//<--  Add contacts to email marketing group list 
					$details[0]["email"] 	= $group->email;
					$details[0]["firstname"]= $group->first_name;	
					$details[0]["lastname"] = $group->last_name;	
					$retval = $this->bmeapi->listAddContacts($new_group_list_id[$group->group_id], $details);						
					if($retval){	
						$stringData =  "\r\n"."         <  Add user to new group list of id : ".$new_group_list_id[$group->group_id]." and name = ".$group->group_name."> \r\n";		
						fwrite($fh, $stringData);	
						$data=array();
						$data['list_id']=$new_group_list_id[$group->group_id];
						$data['user_id']=$group->user_id;
						$data['user_email']=$group->email;
						$data['reference_module']='cluster';
						$data['reference_id']=$group->group_id;
						$this->bulkobj->insert_benchmark($data);
						
					}	
					else
					{
						
						echo "\n\tCode=". $this->bmeapi->errorCode;
						echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
						print_r($group);
						$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
						fwrite($fh, $stringData);
						exit;
					}
					//--> 
					
				}else{
					$where['list_id']			=$group->BM_list_id;
					$where['user_id']			=$group->user_id;
					$where['reference_module']	='cluster';
					$where['reference_id']		=$group->group_id;
					$list_res=	$this->bulkobj->get_benchmark($where);
					if(isset($list_res) && !empty($list_res))
					{
						$data=array();
						$data['need_delete']=0;
						$this->bulkobj->update_benchmark($list_res[0]->benchmark_crone_id,$data);
						$stringData =  "\r\n"."         <  user already exist in group list :".$group->group_name."> \r\n";		
						fwrite($fh, $stringData);
						
					}else{
						//<--  Add contacts to email marketing category list 
						$details[0]["email"] 	= $group->email;
						$details[0]["firstname"]= $group->first_name;	
						$details[0]["lastname"] = $group->last_name;	
						$retval = $this->bmeapi->listAddContacts($group->BM_list_id, $details);						
						if($retval){	
							$stringData =  "\r\n"."         <  Add user to groupli ist of id : ".$group->BM_list_id."> \r\n";		
							fwrite($fh, $stringData);	
							$data=array();
							$data['list_id']=$group->BM_list_id;
							$data['user_id']=$group->user_id;
							$data['user_email']=$group->email;
							$data['reference_module']='cluster';
							$data['reference_id']=$group->group_id;
							$this->bulkobj->insert_benchmark($data);	
						}	
						else
						{
							
							echo "\n\tCode=". $this->bmeapi->errorCode;
							echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
							print_r($group);
							$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
							fwrite($fh, $stringData);
							exit;
						}
						//--> 
							
						
					}
				}
			}else{
				$stringData =  "\r\n"."         <  Group name is null> \r\n";		
				fwrite($fh, $stringData);
			}
			$count++;
		}
		
		/*deleting contacts from list whose '`need_delete' status =1*/
		
		$where=array();
		$where['need_delete']			=1;		
		$del_list_res=	$this->bulkobj->get_benchmark($where);
		if(isset($del_list_res) && !empty($del_list_res))
		{	
			$count=1;
			$stringData =  "\r\n"."    <############## DELETE CONTACTS FROM BENCHMARK EMAIL##############> \r\n";		
			fwrite($fh, $stringData);
			foreach($del_list_res as $raw)
			{
				//<--  delete contacts from email marketing list 
					$retval=$this->bmeapi->listDeleteEmailContact($raw->list_id,$raw->user_email);
					
					if($retval){						
						//echo $retval;
						$stringData =  "\r\n"."    ".$count.". < deleted user email :".$raw->user_email.' with user id : '.$raw->user_id." from ".$raw->reference_module." list of id : ".$raw->list_id.">\r\n";		
						fwrite($fh, $stringData);
						/*deleteing from DB*/
						$this->bulkobj->delete_benchmark($raw->benchmark_crone_id);
					}	
					else
					{
						echo "\n\tCode=". $this->bmeapi->errorCode;
						echo "\n\tMsg=". $this->bmeapi->errorMessage."\n";
						$stringData =  "\r\n"."         <  benchmark error code : ". $this->bmeapi->errorCode." message : ".$this->bmeapi->errorMessage."> \r\n";		
						fwrite($fh, $stringData);
						exit;
					}
					//--> 
				$count++;
			}
		}
								
		
	}	
	function email_unsubscribe($email='')
	{		
		if($email)
		{
			$this->load->model('bulk_message_model', 'bulkobj');
			$where['email']=$email;
			$user_res=$this->bulkobj->get_benchmark($where);
			if(!empty($user_res))
			{
				$this->load->library('benchmark_email/BMEAPI');	
				foreach($user_res as $raw)
				{
					//<--  delete contacts from email marketing list 
					$retval=$this->bmeapi->listDeleteEmailContact($raw->list_id,$raw->user_email);
					/*deleting from DB*/
					$this->bulkobj->delete_benchmark($raw->benchmark_crone_id);
				}	
			}
			/*<-- deleting contacts from resubscribed users list if existing*/
			$retval=$this->bmeapi->listDeleteEmailContact(BM_RE_SUBSCRIBE,$email);
			/*  ---> */
			/*<-- adding contacts in to master un subscribe list */
			$details[0]["email"] = $email;
			$retval = $this->bmeapi->listAddContacts(BM_MASTER_UNSUBSCRIBE, $details);
			/* --> */	
			
		}	
	}
	
	function email_subscribe($id='',$email='')
	{
		/*<--submiting signup form begins here*/
		// INIT CURL
		$ch = curl_init();
		// SET URL FOR THE POST FORM LOGIN
		curl_setopt($ch, CURLOPT_URL, 'http://lb.benchmarkemail.com//code/lbform');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		// IMITATE CLASSIC BROWSER'S BEHAVIOUR : HANDLE COOKIES
		curl_setopt ($ch, CURLOPT_COOKIEJAR,"cookie.txt");
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// SET POST PARAMETERS : FORM VALUES FOR EACH FIELD
		#curl_setopt ($ch, CURLOPT_POSTFIELDS, 'un=pippi2&pw=WEHQQPKG');
		//curl_setopt ($ch, CURLOPT_POSTFIELDS, 'un=Pro11&pw=tub0rgvej14');
		curl_setopt ($ch, CURLOPT_POSTFIELDS, 'successurl='.base_url().'index.php&errorurl='.base_url().'index.php&token='.BM_SIGNUP_TOKEN.'&doubleoptin=&fldEmail='.$email);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		// EXECUTE 1st REQUEST (FORM LOGIN)
		$store = curl_exec ($ch);
		print_R($store);
		$info = curl_getinfo($ch);
		print_r($info);
		/*-->*/
			
	}
	
	function BM_webhook_response()
	{
		
		$logfile = "benchmark_post_logs.txt";		
		$fh = fopen($logfile, 'a+') or die("can't open file");
		$stringData =  "\r\n\r\n<-------------------------".date('Y-M-d g:i a')."------------------------->\r\n\r\n";			
		fwrite($fh, $stringData);	
		foreach ($_POST as $post)
		{
			$stringData =  $post."--------\r\n\r\n";			
			fwrite($fh, $stringData);
		}
		if(isset($_POST['type']) &&  $_POST['type']=='subscribe' )
		{
			if(isset($_POST['email']) && $_POST['email']!='')
			{
				$user_res=$this->usersobj->email_check($_POST['email']);
				if(!empty($user_res))
				{
					$data['email_digest'] 	    = 1;
					$this->usersobj->update_user($user_res[0]->id, $data);
					$this->benchmark_update_crone($user_res[0]->id);	
				}	
			}
			
		}
		if(isset($_POST['type']) &&  $_POST['type']=='unsubscribe' )
		{
			if(isset($_POST['email']) && $_POST['email']!='')
			{
				$email=$_POST['email'];
				$user_res=$this->usersobj->email_check($email);				
				if($user_res)
				{
					$data['email_digest'] 	    = '';
					$this->usersobj->update_user($user_res[0]->id, $data);
					$this->email_unsubscribe($email);
				}	
			}
		}
	}
	
	function invite_user()
	{
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			echo validation_errors();
			exit;
			  
		}else{	
			if($this->user_id!='')
			{
				$this->load->model('Invite_user_model', 'inviteobj');
				$data['user_id']		= $this->user_id;
				$data['invited_email']  = $this->input->post('email');
				$result=$this->inviteobj->get($data);
				if(empty($result))
				{
					$this->inviteobj->insert($data);
				}			
				$from_name=$this->first_name.' '.$this->last_name;
				$this->load->library('email');
				$this->email->from($this->user_email,$from_name);
				$this->email->to($this->input->post('email'));
				$this->email->subject( 'Join CleanTekMarket' );
				$this->email->set_mailtype("html");
				$emaildata['message']=$this->input->post('message');
				$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
				//echo $this->load->view( 'emails/news_letter', $emaildata, true );
				$this->email->send();
				$this->session->set_userdata('MESSAGE',"Inviting email sent successfully");
				redirect($_SERVER['HTTP_REFERER']);
			
			}else{
				redirect('users');
			}
			
		}	
	}
	
	function privacy_block()
	{
		$this->load->view('header');
		$this->load->view("privacy_block");
		$this->load->view('footer');	
	}	
	function user_register_popup()
	{
		$this->load->view('header');
		$this->load->view("user_register");		
	}	
	
	// General user advanced search
		
	function advanced_search($page='',$id='') {
		
			$this->load->model('category_model', 'categorysobj');
			
			$user_login = $this->session->userdata('USER');
			//Cleantek Category
			$this->load->model('category_model', 'categorysobj');
			$wh['parent_id']				= 	array("-1");
			$data['cat_res'][0]				= 	$this->categorysobj->get_categories("", "", $wh, 'categories_name');
			if ($data['cat_res'][0]) {
				foreach ($data['cat_res'][0] as $cat) {
					$par[] = $cat->categories_id;
				}
			}
			
			$wh['parent_id'] 				= 	$par;
			$data['cat_res'][1]				= 	$this->categorysobj->get_categories("", "", $wh, 'categories_name');
			if ($data['cat_res'][1]) {
				foreach ($data['cat_res'][1] as $cat) {
					$par2[] = $cat->categories_id;
				}
			}
			$wh['parent_id'] = $par2;
			$data['cat_res'][2] = 	$this->categorysobj->get_categories("", "", $wh, 'categories_name');
			
			$data['country_res'] 				= 	$this->usersobj->get_country("","");			
			$where["cleantek_usr_cat"]	=	"";	
			if($this->user_id=='')
			{
				$data['level']					=	1;
				$data['userid']					=	'';
				$data['planfeature_value']		=	'N';
			}
			else{
				$data['level']					= 	$this->level;
				$data['userid']            		= 	$user_login['ID'];
				if(isset($page) && $page!=''){
					$where['user_id']			=	$id?$id:$user_login['ID'];
					$data['banner_user_id']     = 	$id?$id:$user_login['ID'];
					$data['user_id']            = 	$id?$id:$user_login['ID'];
				//	$where['fav']			    =	1;
					//$data['page']			    =	1;
					$data['user_banner']		=	1;
				}
			}
			$data["total_rows"] 				= 	count($this->usersobj->search_user("","",$where));
			$data["recs_per_page"]				= 	$this->recs_per_page1;
				
			$user_type['']						=	'View All';
			$user_type['individual']			=	'Individual';
			$user_type['company']				=	'Company';
			$user_type['government']			=	'Government';
			$data['user_type']					=	$user_type;
			$data['page_title']					= 	'CleanTekMarket:User Advanced Search';
			$data['base_url']   				= 	$this->config->item('rel_path');
			
			$this->load->view('header', $data);
			$this->load->view("user_advanced_search",$data);
			$this->load->view('footer');
		}
	
		//Ajax call for search result
		function search_result() {
			$user_login = $this->session->userdata('USER');
			$category						=	$_POST['category'];
			$where["cleantek_usr_cat"]		=	$_POST['user_category'];
			$location						=	$_POST['location'];
			$user_type						=	$_POST['user_type'];
			$where["search_name"]			=	isset($_POST['search_name'])?$_POST['search_name']:"";
			$where["company_name"]			=	isset($_POST['company_name'])?$_POST['company_name']:"";
			$offset							=	$_POST['loaded_rows'];
		//	$where["featured"]				=	1;
			
//			$page							=	$_POST['page'];
			/* if(isset($page) && $page!=''){
				$where['user_id']			=	$_POST['user_id'];
				$where['fav']			    =	1;
			} */
			if($category)
			{	
				if(is_array($category))
					 $where['cat_ids']			=  	implode(",",$category);
				else	
					$where['cat_ids']			=	$category;
			}		
			
			if($location)
			{		
				if(is_array($location))
					 $where['location_ids']			=  	"'".implode("','",$location)."'";
				else	
					$where['location_ids']			=	"'".$location."'";	
			}	
			if($user_type)
			{		
				if(is_array($user_type))
					 $where['clt_user_type']			=  	"'".implode("','",$user_type)."'";
				else	
					$where['clt_user_type']			=	"'".$user_type."'";	
			}	
			//$config["base_url"] 			= 	base_url() . "investors/index/act/search/";
			$config["total_rows"] 			= 	count($this->usersobj->search_user("","",$where));
			$config["per_page"] 			= 	$this->recs_per_page1;
		//	$config["uri_segment"] 			= 	3;
			
		//	$this->pagination->initialize($config);
			
			$res							= 	$this->usersobj->search_user($config["per_page"],$offset,$where);
			//$page_links 					= 	$this->pagination->create_links();
			if($res){
			
				$result						=	"<input type='hidden' value='".$config["total_rows"] ."' name='total_rows'><input type='hidden' value='".$config["per_page"]."' name='recs_per_page'>";
				foreach($res as $data){
					$cleanteckCategoryIds       	=  	$this->usersobj->getRelationalCategoryList($data->id);
					$categoryname="";
					foreach ($cleanteckCategoryIds as $keycat=>$value)
					{
						$categoryname .= $value->categories_name.', ';
					}
					$category_name=substr($categoryname,0,-2);
					if(strlen($category_name)>25){
						$category_name = substr(strip_tags($category_name), 0, 25); 
						if(strrpos($category_name, ", ")!='')
							$category_name = substr($category_name, 0, strrpos($category_name, ", "))."....";
						else
							$category_name = substr($category_name, 0, 25)."....";
					} 
					if(isset($this->user_id) && $this->user_id!='' && $this->user_id!=$data->id && $data->privacy!='private')
					{
						//$user_info = $this->usersobj->get($data->submitted_by);
						$wh['user_id'] = $this->user_id;
						$wh['module_user_id'] = $data->id;
						$module					=  urlencode($this->encrypt->encode($data->cleantek_user_category));	
						$type					=  $this->encrypt->encode($data->cleantek_user_category);	
						$owner_id				=  urlencode($this->encrypt->encode($data->id));	
						$module_name			=  urlencode($this->encrypt->encode($data->first_name));		
						$item=$owner_id." ".$module_name." ".$data->id." ".$module." ".$type;
							
						$con_result = $this->usersobj->check_connection($wh);
						$action_btn='<div class="act_btn"><a href="javascript:void(0)">';
						if($con_result){
							
							if($con_result->status=='Send'){
								$action_btn .= '<img class="connect" id="'.$item.'"  title="Already sent request" src="'.base_url().'images/wait.png" >';
								
							}else if($con_result->status=='Confirm'){
								$action_btn .= '<img class="connect" id="'.$item.'"  title="Send mail" src="'.base_url().'images/mail_send.png" >';
								
							}
						}else{
							$action_btn .=  '<img class="connect" id="'.$item.'"  src="'.base_url().'images/Connection.png" title="Invite '.$data->first_name.' to connect" ';
						}
					
						$action_btn .='</a></div>';
					}else{
						$action_btn='';
					}
					$user_name ='';
					$connection_status='';
					$user_id ="<input type='hidden' id='hidden_id' value='".$data->id."' >";
					if($data->privacy=='connections'){
						$user_name .= "<input type='hidden' id='user_name' value='".$data->first_name."'>";
						
						if($this->user_id!=$data->id){
							$where['user_id'] = $this->user_id;
							$where['module_user_id'] = $data->id;
							$con_result = $this->usersobj->check_connection($where);
							if($con_result){
								if($con_result->status=='Send'){
									$connection_status ="<input type='hidden' id='connection_status' value='1'>";
								}
							}else{
								$connection_status ="<input type='hidden' id='connection_status' value='3'>";
							}
						}
					}/* else if($data->privacy=='private'){
						$connection_status ="<input type='hidden' id='connection_status' value='4'>";
					} */
					if($data->profile_picture != "" && file_exists('images/profile_images/'.$data->profile_picture)){
						$img_path=base_url().'images/profile_images/'.$data->profile_picture;
					}else{
						$img_path=base_url().'images/profile_images/default_profile_image.gif';
					 } 
					 $view_det_var = $data->id." ".$data->cleantek_user_category;
					$result.='<div class="productwrap inv_adv_wrap">'.$action_btn.'<div style="opacity:\'1\'">
					  <div class="thumbImg">
					   <a href="#" class="thumb"><img src="'.$img_path.'"></a>
					  </div>
					  <div class="itemInfo">
					  <ul><li>
					   <h2>'.$user_id.$connection_status.$user_name.'<a class="view_full" href="javascript:void(0)">'.$data->first_name." ".$data->last_name.'</a></h2></li>
					   <li><span class="category1">Category :&nbsp;</span>'.$category_name.'</li>
					   <li><span class="location1">Industry :&nbsp;</span>'.$data->industry.'</li>
					   <li><span class="location1">User Type :&nbsp;</span>'.$data->user_type.'</li>
					   <li><span class="location1">User Category :&nbsp;</span>'.$data->cleantek_user_category.'</li>
					   <li><span class="location1">Investor Category :&nbsp;</span>'.$data->investor_category.'</li>
					   <li><span class="location1">Location :&nbsp;</span>'.$data->country_name.'</li>
					   </ul>
					   <input type="button" id="'.$view_det_var.'" class="prodDetails" value="Details">
					   
					  </div>
					  </div>
					 </div>
					';
					
				}
				
				echo $result;
			}
		}
		//ajax call for full details
		function full_details()
		{
			$where['id']					=	$_POST['id'];
			$where['cleantek_user_category']=   $_POST['cleantek_user_category'];
			//$where['featured']				=   1;
			$data 							= 	$this->usersobj->get_list("","",$where);
			$cleanteckCategoryIds       	=  $this->usersobj->getRelationalCategoryList($where['id']);
			//$data["cleanteckCategoryIds"]   =  $clnCategoryList;
			
			$categoryname="";
			foreach($cleanteckCategoryIds as $cat){
				if($data->id==$cat->user_id)
					$categoryname .= $cat->categories_name.', ';
			}
			$category_name=substr($categoryname, 0, -2);
			if(strlen($category_name)>100){
				$category_name = substr(strip_tags($category_name), 0, 75); 
				$category_name = substr($category_name, 0, strrpos($category_name, ", "))."....";		
			}
			if(isset($data)){
			
				if($data->profile_picture != "" && file_exists('images/profile_images/'.$data->profile_picture)){
					$img_path				=	base_url().'images/profile_images/'.$data->profile_picture;
				}else{
					$img_path				=	base_url().'images/no_image.gif';
				 } 
				 $prof_desc = trim($data->profile_description);
					if(strlen(trim($data->profile_description))!='' && strlen(trim($data->profile_description))>150){
						$prof_desc = substr(strip_tags($data->profile_description), 0, 150); 
						$prof_desc = substr($prof_desc, 0, strrpos($prof_desc, " "))."....";
						
					}else{
						$prof_desc = $prof_desc;
					}
					$connection = '';
					$connection_status = '';
					$user_name = '';
					if($data->privacy=='connections'){
						$user_name .= "<input type='hidden' id='user_name' value='".$data->first_name."'>";
						if($this->user_id!=$data->id){
							$where['user_id'] = $this->user_id;
							$where['module_user_id'] = $data->id;
							$con_result = $this->usersobj->check_connection($where);
							if($con_result){
								if($con_result->status=='Send'){
									$connection = "<img title='Already sent request' class ='action_img' src='".base_url()."images/wait.png' id='connect'>";
									$connection_status ="<input type='hidden' id='connection_status' value='1'>";
								}
							}else{
								$connection = "<img src='".base_url()."images/Connection.png' class ='action_img' title='Invite ".$data->first_name." to connect' id='connect' >";
								$connection_status ="<input type='hidden' id='connection_status' value='3'>";
							}
						}
					}
				$details					=	' <div class=""><h6 class="header6">'.$data->first_name." ".$data->last_name.nbs(5).$connection.'</h6>
					<div class="prodDetails2"><img alt="" src="'.$img_path.'" class="prod1" >
					<div class="itemInfo">
						<h2 class="title1"></h2><p>'.nl2br($prof_desc).'</p>
					</div>
					  <div class="itemInfo">
					  <ul>
						  
						   <li class="item_li_white"><span class="location1">Location :&nbsp;</span>'.$data->country_name.'</li>
						   <li class="item_li_white"><span class="category1">Category :&nbsp;</span>'.$category_name.'</li>
						   <li class="item_li_white"><span class="category1">Industry :&nbsp;</span>'.$data->industry.'</li>
						   <li class="item_li_white"><span class="category1">User Type :&nbsp;</span>'.$data->user_type.'</li>
						   <li class="item_li_white"><span class="category1">User Category:&nbsp;</span>'.$data->cleantek_user_category.'</li>
						   <li class="item_li_white"><span class="category1">Investor Category :&nbsp;</span>'.$data->investor_category.'</li>
					  </ul>
					   </div>
					</div><input type="hidden" id="hidden_id" value="'.$data->id.'" >'.$connection_status.$user_name.'
					
					<a href="javascript:void(0)" class="viewFull view_full">View Full Details</a>
					</div>';
									
				echo $details;
			}else
				echo 0;
		}
		function owner_login($id='') {
			$admin_login   = $this->session->userdata('ADMIN');
			
			if($admin_login['Email']==OWNER_EMAIL)
			{
				$result = $this->usersobj->email_check($admin_login['Email']);
				$password=$this->encrypt->decode($result[0]->password);
				$soc_media_array                                             = array(
																					'EMAIL'		=> OWNER_EMAIL,
																					'PASSWORD'  => $password
																					);
				$this->session->set_userdata("SOCIAL_MEDIA_USER",$soc_media_array);
				$this->check_login();
			}else
			{
				redirect('users');
			}
		}
		
		function close_account()
		{
			$close_accnt=$this->input->post('close_accnt');
			if($close_accnt==1)
				$reason='i have a duplicate account.';
			else if($close_accnt==2)
				$reason='i am getting too many emails.';
			else if($close_accnt==3)
				$reason='i am not getting any value from my membership.';
			else if($close_accnt==4)
				$reason='i am using a different professional networking service.';
			else if($close_accnt==5)
				$reason=strtolower($this->input->post('reason'));		
			if(!empty($reason))	
			{
				if(!empty($this->user_id))
				{
					$this->load->library( 'email' );
					$this->email->from(  $this->user_email,  $this->first_name.' '.$this->last_name   );
					$this->email->to(ADMIN_EMAIL);
					$this->email->subject( 'Account Close Request.' );
					$this->email->set_mailtype("html");
					$emaildata['message']='<p>Hi,</p><p>I would like to delete my account because '.$reason.'</p><p>Regards,<br>&nbsp;&nbsp;&nbsp;'.  ucfirst($this->first_name).' '.$this->last_name.'<br> &nbsp;&nbsp;&nbsp;Email: '.  $this->user_email.'</p>';
					$this->email->message( $this->load->view( 'emails/news_letter', $emaildata, true ) );
					//echo $this->load->view( 'emails/news_letter', $emaildata, true );
					$this->email->send(); 
				}
			}	
			$this->session->set_userdata('VALIDATION_ERRORS','<p>Close account request submitted successfully to Cleantek administrator.</p>');
			$this->logout(1);
			
			
		}

		function close_sample(){
			if(!empty($this->user_id))
			{
				$this->load->model('product_model', 'prodobj');
				$this->load->model('solution_model', 'solobj');
				$this->load->helper('send_notification');
				$where['user_id']=$this->user_id;	
				/*get all products of user*/	
				$prod_res=$this->prodobj->get_user_products($this->user_id);
				//print_R($prod_res);
				foreach($prod_res as $prod)
				{
					/*check product confirmed by any advisor*/
					$res=$this->prodobj->check_advisor_confirmation($prod->id);
					if(!empty($res))
					{
						$message="Hello, <br>".ucfirst($this->first_name)." deleted  a  product ".$prod->type." '".$prod->title."'<br>";
						send_notification($this->user_id,array($res[0]->advisor_id),$message,'Product Delete Notification - "'.$prod->title.'"');	
						$where['seek']			= "advisor";
						$where['product_id']	= $prod->id;
						$this->prodobj->delete_product_confirmation($where);
					}	
					//print_R($res)	;
					/*check product confirmed by any investor*/
					$res=$this->prodobj->check_investor_confirmation($prod->id);
					if(!empty($res))
					{
						$message="Hello, <br>".ucfirst($this->first_name)." deleted  a  product ".$prod->type." '".$prod->title."'<br>";
						send_notification($this->user_id,array($res[0]->investor_id),$message,'Product Delete Notification - "'.$prod->title.'"');	
						$where['seek']			= "investor";
						$where['product_id']	= $prod->id;
						$this->prodobj->delete_product_confirmation($where);
					}
					//print_R($res)	;
					/*deleting product*/
					$this->prodobj->delete_product($prod->id);
					
					
				}
				/*get all solutions of user*/	
				$soln_res=$this->solobj->get_user_solutions($this->user_id);
				foreach($soln_res as $soln)
				{
					/*check solution confirmed by any advisor*/
					$res=$this->solobj->check_advisor_confirmation($soln->id);
					if(!empty($res))
					{
						$message="Hello, <br>".ucfirst($this->first_name)." deleted  a  solution ".$soln->type." '".$soln->title."'<br>";
						send_notification($this->user_id,array($res[0]->advisor_id),$message,'Solution Delete Notification - "'.$soln->title.'"');	
						$where['seek']			= "advisor";
						$where['solution_id']	= $soln->id;
						$this->solobj->delete_solution_confirmation($where);
					}	
					//print_R($res)	;
					/*check solution confirmed by any investor*/
					$res=$this->solobj->check_investor_confirmation($soln->id);
					if(!empty($res))
					{
						$message="Hello, <br>".ucfirst($this->first_name)." deleted  a  solution ".$soln->type." '".$soln->title."'<br>";
						send_notification($this->user_id,array($res[0]->investor_id),$message,'solution Delete Notification - "'.$soln->title.'"');	
						$where['seek']			= "investor";
						$where['solution_id']	= $soln->id;
						$this->solobj->delete_solution_confirmation($where);
					}
					//print_R($res)	;
					/*deleting solution*/
					$this->solobj->delete_solution($soln->id);
					
					
				}
				
				
			}
			
		}
}

?>