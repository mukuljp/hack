<?php

class Course_model extends CI_Model {

 
    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
 function insert_enroll($course_id,$stud_id)
    {
        $data['enroll_joindate']	= date("Y-m-d H:i:s");	
        $data['enroll_studentid']	=$stud_id;     
         $data['enroll_courseid']	=$course_id;      
       foreach ($data as $field => $val)
			$this->$field   = $val;
        $this->db->insert('e_enroll', $this);
		return  $this->db->insert_id();
    }
    function  get_enroll($course_id,$stud_id)
    {
        $this->db->select('*');
        $this->db->from('e_enroll');
        $this->db->where('enroll_studentid', $stud_id);
        $this->db->where('enroll_courseid', $course_id);
        $query = $this->db->get();
        $res_arr = $query->result();
        return $res_arr;
    }
    function get_categoroes() {

        $this->db->select('*');
        $this->db->from('e_catagory');
        $this->db->where('cata_status = 1');
        $this->db->join('e_courses', "e_courses.course_catagory = e_catagory.cata_id");
        $this->db->group_by('cata_id');
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }

    function get_courses($course_id = '') {
        $this->db->select('*');
        $this->db->from('e_courses');
        $this->db->where('course_status = 1');
        if ($course_id)
            $this->db->where('course_id = ' . $course_id);
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }

    function get_course_members_count($course_id = '') {
        $this->db->select('count(enroll_studentid) as count_mem,enroll_courseid');
        $this->db->from('e_enroll');
        $this->db->group_by('enroll_courseid');
        if ($course_id)
            $this->db->where('enroll_courseid = ' . $course_id);
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }

    function get_course_user_rating($course_id = '') {
        $this->db->select('sum(review_rating)/count(review_rating) as rating,review_courseid');
        $this->db->from('e_course_reviews');
        $this->db->group_by('review_courseid');
        if ($course_id)
            $this->db->where('review_courseid = ' . $course_id);
        $query = $this->db->get();
        $res_arr = $query->result();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }
    
     function getSyllabusus( $course_id) {
        $this->db->select('*');
        $this->db->from('e_syllabus');
        $this->db->where('sy_courseid', $course_id);
        $this->db->where('sy_parent', 0);
        $this->db->order_by("sy_sortoder", "asc");
        $query = $this->db->get();
        $res_arr = $query->result();
        //print_r($res_arr);
        $data = array();
        $sub_chapter = true;
        $i = 0;
        foreach ($res_arr as $chapters) {
            $data[$i]['chapter'] = $chapters;
       
                $sub_chapters = $this->get_sub_chapters($chapters->sy_id, $chapters->sy_courseid,"");

                $data[$i]['subchapters'] = $sub_chapters;
            
            $i++;
        }
        //print_r($data);
        return $data;
        ;
    }
    function get_course_piechart_data($course_id)
    {
        $json=array();
        $this->db->select('count(*) as total');
        $this->db->from('e_enroll');
        $query = $this->db->get();
        $res_arr = $query->result();

        if ($query->num_rows() > 0){
            $total=$res_arr[0]->total;
            $this->db->select('count(*) as total,course_name');
            $this->db->from('e_enroll');
            $this->db->join('e_courses',"e_courses.course_id=e_enroll.enroll_courseid");
            $this->db->where('enroll_courseid',$course_id);
            $query = $this->db->get();
            $res_arr = $query->result();
            if ($query->num_rows() > 0){
                
                 $json[0]["label"]=$res_arr[0]->course_name."(".$res_arr[0]->total.")";
                 $json[0]["value"]=$res_arr[0]->total;
                 $json[1]["label"]="Other(".($total-$res_arr[0]->total).")";
                 $json[1]["value"]=$total-$res_arr[0]->total;
            }else{
                 $json[0]["label"]="Other";
                 $json[0]["value"]=$total;
            }
        }
        else{
            $json[0]["label"]="Other";
            $json[0]["value"]=0;
        }
        return json_encode($json);
    }
    function get_course_comments($course_id)
    {
        $this->db->select('*,now() as cur_date');
        $this->db->from('e_course_reviews');
        $this->db->join('e_students',"e_students.stud_id=e_course_reviews.review_studid");
        $this->db->where('review_courseid',$course_id);
        $query = $this->db->get();
        $res_arr = $query->result();
         if ($query->num_rows() > 0)
            return $res_arr;
        else
            return 0;
    }

    function get_enrolled_coursedetails($enrollment_id) {
        $this->db->select('*');
        $this->db->from('e_enroll');
        $this->db->where('enroll_id', $enrollment_id);
         $this->db->join('e_courses as ec', 'ec.course_id=enroll_courseid','left');

        $query = $this->db->get();
        $res_arr = $query->result();
        //echo  $this->db->last_query();
        if ($query->num_rows() > 0)
            return $res_arr;
        else
            return false;
    }
    
   // function getSyllabus

    function getSyllabus_enrolled($enrollment_id, $student_id, $course_id) {
        $this->db->select('*');
        $this->db->from('e_syllabus');
        $this->db->where('sy_courseid', $course_id);
        $this->db->where('sy_parent', 0);
        $this->db->order_by("sy_sortoder", "asc");
        $query = $this->db->get();
        $res_arr = $query->result();
        //print_r($res_arr);
        $chapter=false;
        $data = array();
        $sub_chapter = true;
        $i=0;
        foreach ($res_arr as $chapters) {
            $data[$i]['chapter'] = $chapters;
            //$data[$i]['subchapter'] =
            if ($sub_chapter) {
                $sub_chapters = $this->get_sub_chapters($chapters->sy_id, $chapters->sy_courseid,$enrollment_id);
                //$data[$i]['subchapter'] =array();
                $k=0;
                foreach ($sub_chapters as $subc) {
                    if ($subc->chapt_lastchapter == "") {
                        $subc->active = false;
                       
                    if ($k+1==count($sub_chapters)&&$sub_chapters[$k]->active==TRUE){
                        $chapter=$chapters;
                    }
                        if ($sub_chapter){
                           // echo $k;
                           //if ($k>0)
                            $next_chapter=$sub_chapters[$k];
                            $sub_chapters[$k]->active=true;
                        }
                        $sub_chapter = false;
                        
                    } else {
                        $subc->active = true;
                    }
                   
                     $k++;
                }
                $data[$i]['subchapters'] =$sub_chapters;
            }else{
                $data[$i]['subchapters']=array();
            }
            $i++;
        }
        //print_r($data);
        if (!isset($next_chapter)){
            $next_chapter=array();
        }
        return array($next_chapter,$data,$chapter);
    }

    function get_sub_chapters($chapter_id, $course_id,$enrollment_id) {
        $this->db->select('*');
        $this->db->from('e_syllabus');
        $this->db->where('sy_courseid', $course_id);
        $this->db->where('sy_parent', $chapter_id);
        //$this->db->where('cont_enrollid', $enrollment_id);
        $this->db->join("e_chapter_status ecs", "ecs.chapt_lastchapter=sy_id", "left");
        $this->db->order_by("sy_sortoder", "asc");
        $query = $this->db->get();
        $res_arr = $query->result();
      //  print_r($res_arr);exit;
        return $res_arr;
    }
    
    function getchapterContents($syllabus_id){
        $this->db->select('*');
        $this->db->from('e_contents');
        $this->db->where('cont_syid', $syllabus_id);
        $this->db->order_by("cont_sort_order", "asc");
        $query = $this->db->get();
        $res_arr = $query->result();
        return $res_arr;
    }
    
    function getsyllabus($chapter_id){
         $this->db->select('*');
        $this->db->from('e_syllabus');
        $this->db->where('sy_id', $chapter_id);
        $this->db->join("e_chapter_status ecs", "ecs.chapt_lastchapter=sy_id", "left");
       // $this->db->where('sy_parent', $chapter_id);
        //$this->db->where('cont_enrollid', $enrollment_id);
       
        $query = $this->db->get();
        $res_arr = $query->result();
      //  print_r($res_arr);exit;
        return $res_arr;
    }
    function check_chapter_access($chapter_id,$enrollment_id, $student_id, $course_id){
        //getSyllabus_enrolled
    }
    function insertcompleted_status($enroll_id,$student_id,$course_id,$chapter_id){
        $data=array(
            "chapt_studid"=>$student_id,
            "chapt_courseid"=>$course_id,
            "cont_enrollid"=>$enroll_id,
            "chapt_lastchapter"=>$chapter_id
        );
        $this->db->insert('e_chapter_status', $data); 
        return $this->db->insert_id();
        
    }
    function delete_chapter_stat($chapter_status_id){
        $this->db->where('chapt_id', $chapter_status_id);
        $this->db->delete('e_chapter_status'); 
    }
    
    function check_chapter_completed($chapter_id){
         $this->db->select('count(*) as completed_count');
        $this->db->from('e_syllabus');
        //$this->db->where('sy_courseid', $course_id);
        $this->db->where('sy_parent', $chapter_id);
        //$this->db->where('cont_enrollid', $enrollment_id);
        $this->db->join("e_chapter_status ecs", "ecs.chapt_lastchapter=sy_id", "left");
         $this->db->where('chapt_lastchapter != ', "null");
        
        $query = $this->db->get();
        $res_arr = $query->result();
       // print_r($res_arr);;
        
        $this->db->select('count(*) as total_count');
        $this->db->from('e_syllabus');
        //$this->db->where('sy_courseid', $course_id);
        $this->db->where('sy_parent', $chapter_id);
        $query = $this->db->get();
        $res_arr1 = $query->result();
         // print_r($res_arr1);;
         // exit;
        
          if ($res_arr[0]->completed_count==$res_arr1[0]->total_count)
              return $chapter_id;
          else
              return false;
          
       // return $res_arr;
    }
    
    function get_testid($chaptersys_id){
        $this->db->select('*');
        $this->db->from('e_tests');
        //$this->db->where('sy_courseid', $course_id);
        $this->db->where('test_syid', $chaptersys_id);
        $query = $this->db->get();
       // echo  $this->db->last_query();
        $res_arr = $query->result();
        return $res_arr;
    }
    

}

?>