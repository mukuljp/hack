<?php

class Login_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function login($username,$password) {
        $this->db->select('*'); 
        $this->db->from('e_login');
        $this->db->join('e_students',"e_students.stud_loginid = e_login.login_id");
		$this->db->where('login_name',$username);
		$this->db->where('login_password',md5($password));
        $query = $this->db->get();
		//echo $this->db->last_query();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }
    function user_enrolled_courses($user_id)
    {
        $this->db->select('*'); 
        $this->db->from('e_enroll');
        $this->db->where('enroll_studentid',$user_id);
        $query = $this->db->get();
	$res_arr = $query->result();
         if ($query->num_rows() > 0)
         {
             $courses=array();
             foreach($res_arr as $raw)
             {
                 array_push($courses, $raw->enroll_courseid); 
             }
             return $courses;
         }
        else
            return array();
    }
    
    
}

?>