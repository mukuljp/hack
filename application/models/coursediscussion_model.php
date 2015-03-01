<?php

class Coursediscussion_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getMainCourseName($cId) {
        $this->db->select('e_courses.course_name,e_courses.course_id');
        $this->db->from('e_courses');
        $this->db->where('e_courses.course_id =' . $cId);
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }
    
    function getDiscussionDetails($cId) {
        $this->db->select('e_discussion.disc_title,e_discussion.disc_question,e_discussion.disc_id');
        $this->db->from('e_discussion');
        $this->db->where('e_courses.course_id =' . $cId);
        $this->db->join('e_courses', "e_courses.course_id = e_discussion.disc_course");
        $this->db->order_by('e_discussion.disc_id', "asc");
        $query = $this->db->get();
        $res_arr = $query->result();
		$i=0;
		foreach($res_arr as $arr){
			$cid = $arr->disc_id;
			$res = $this->getDiscussionReplies($cid);
			//print_r($res);
			$res_arr[$i]->comments = $res;
		}  
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }
	
	function getDiscussionReplies($cId) {
        $this->db->select('*');
        $this->db->from('e_discussion_replies');
        $this->db->where('e_discussion_replies.rep_discid =' . $cId);
        $this->db->join('e_students', "e_discussion_replies.rep_commentor = e_students.stud_id");
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }

}

?>