<?php

class Dashboard_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function getCourseName($sId) {
        $this->db->select('e_courses.course_name,e_courses.course_id');
        $this->db->from('e_courses');
        $this->db->where('e_enroll.enroll_studentid =' . $sId);
        $this->db->join('e_enroll', "e_courses.course_id = e_enroll.enroll_courseid");
        $this->db->order_by('e_enroll.enroll_id', "asc");
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }
	
    function getScoreByCourse($cId,$student_id) {
        $this->db->select("count(*) as coins");
        $this->db->from('e_score');
        $this->db->where('e_score.score_courseid ='. $cId);
	$this->db->where('e_score.score_studid ='. $student_id);
	$this->db->where("e_score.score_result = 'R'");
        $result = $this->db->get();
	if($result && $result->num_rows()>0){
            $counter = $result->row_array();
			$count = $counter['coins'];
            $count = $count*10;
            return $count;
        }
        return 0;
    }
    function graphdata($student_id)
    {
        $courses=$this->getCourseName($student_id);
        $output=array();
        if(!empty($courses))
        {$data=array();
            foreach($courses as $dat){
                $res=$this->getScoreByCourse($dat->course_id,$student_id);
                $x=array("month"=>$dat->course_name,"count"=>$res);
                array_push($data, $x);
                
            }
            $out=array("data"=>$data,"name"=>"Chapter");
            array_push($output,$out);
        }
        return json_encode($output);
    }
    
    
    
    

}

?>