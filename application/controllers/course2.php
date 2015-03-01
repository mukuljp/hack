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
        $this->load->model('Course_model', 'couobj');
		$this->load->model('Chapter_model', 'chapter');
    }

    //put your code here
    function index() {
        //echo base_url("blf");
        $data = array();
        $data['categories'] = $this->couobj->get_categoroes();
        $data['courses'] = $this->couobj->get_courses();
        $courses_members_count = $this->couobj->get_course_members_count();
        $member_count = array();
        if (!empty($courses_members_count)) {
            foreach ($courses_members_count as $count) {
                $member_count[$count->enroll_courseid] = $count->count_mem;
            }
        }
        $data['courses_members_count'] = $member_count;
        $courses_members_count = $this->couobj->get_course_members_count();

        $course_user_rating = $this->couobj->get_course_user_rating();

        $rating = array();
        if (!empty($course_user_rating)) {
            foreach ($course_user_rating as $rate) {
                $rating[$rate->review_courseid] = round($rate->rating);
            }
        }
        $data['rating'] = $rating;
        $data["colors"] = array("bg-light-blue", "bg-green", "bg-purple", "bg-red", "bg-orange");

        $this->view("home.php", $data);
    }

    function course_detail($course_id = 1, $colour_id = 1) {

        $data['categories'] = $this->couobj->get_categoroes();
        $data['courses'] = $this->couobj->get_courses();
        $data['colour_id'] = $colour_id;
        $data["colors"] = array("bg-light-blue", "bg-green", "bg-purple", "bg-red", "bg-orange");

        $data['course'] = $this->couobj->get_courses($course_id);

        $courses_members_count = $this->couobj->get_course_members_count();
        $member_count = array();
        if (!empty($courses_members_count)) {
            foreach ($courses_members_count as $count) {
                $member_count[$count->enroll_courseid] = $count->count_mem;
            }
        }
        $data['courses_members_count'] = $member_count;

        $courses_members_count = $this->couobj->get_course_members_count($course_id);

        $course_user_rating = $this->couobj->get_course_user_rating($course_id);

        $rating = array();
        if (!empty($course_user_rating)) {
            foreach ($course_user_rating as $rate) {
                $rating[$rate->review_courseid] = round($rate->rating);
            }
        }
        $data['rating'] = $rating;
        $courses_syllabus = $this->couobj->getSyllabusus($course_id);
        $data['enrolled_course_data'] = $courses_syllabus;
        $data['get_course_piechart_data'] = $this->couobj->get_course_piechart_data($course_id);
        $data['course_comments'] = $this->couobj->get_course_comments($course_id);

        $this->view("course_detail_view", $data);
    }


    /* mukul */

    function enrolled_course($enrollment_id, $chapter = FALSE) {
        if($this->session->userdata('user_in')!=""){
		$userData = $this->session->userdata('user_in');
		$student_id = $userData[0]->stud_id;
		}else
        $student_id = 1;
        $data['life_available'] =  $this->chapter->getLifeAvailable($student_id);
        
$coins = $this->chapter->getCoins($student_id);
$reduced_coins = $this->chapter->getReducedCoins($student_id);
$total = $coins+$reduced_coins;
$data['coins_available'] = $total;

         $data["course_over"] = FALSE;
        $data['enroll_id'] = $enrollment_id;
        $courses = $this->couobj->get_enrolled_coursedetails($enrollment_id);
        //print_r($courses);exit;
        $data["course_data"]=$courses;
        $data['enrolled_course_data'] = array();
        if ($courses) {
            //print_r($courses);
            //exit;
            $enrolled_course_data = $this->couobj->getSyllabus_enrolled($courses[0]->enroll_id, $courses[0]->enroll_studentid, $courses[0]->enroll_courseid);
            $data['enrolled_course_data'] = $enrolled_course_data[1];
            $data["chapter_over"]=$enrolled_course_data[2];
            
            //print_r($enrolled_course_data[2]);exi
//print_r($course_contents);
//exit;     

            if ($chapter == FALSE) {
                if (count($enrolled_course_data[0]) == 0) {
                    $data["course_over"] = true;
                } else {
                    $chapterdata = $this->couobj->getsyllabus($enrolled_course_data[0]->sy_id);
                    // print_r($chapterdata);
                    $data['chapter_data'] = $chapterdata;
                    $course_contents = $this->couobj->getchapterContents($enrolled_course_data[0]->sy_id);
                    $data["course_contents"] = $course_contents;
                }
            } else {
                //$course_contents=$this->couobj->check_chapter_access($chapter,$courses[0]->enroll_id,$courses[0]->enroll_studentid,$courses[0]->enroll_courseid);
                $chapterdata = $this->couobj->getsyllabus($chapter);
                // print_r($chapterdata);
                $data['chapter_data'] = $chapterdata;
                $course_contents = $this->couobj->getchapterContents($chapter);
                $data["course_contents"] = $course_contents;
            }
          
            $this->view("enrolled_course_detail", $data);
        } else {
            //error message
            echo "blaa";
        }
    }

    function completedstatus($enroll_id, $chapter_id,$chapter_parent) {
        $courses = $this->couobj->get_enrolled_coursedetails($enroll_id);
        $id=$this->couobj->insertcompleted_status($courses[0]->enroll_id, $courses[0]->enroll_studentid, $courses[0]->enroll_courseid, $chapter_id);
         $chapter_stat= $this->couobj->check_chapter_completed($chapter_parent);
    if ($chapter_stat!=false){
        echo "chapter_complete";
         $chapter_stat= $this->couobj->delete_chapter_stat($id);
        exit;
    
    }
        redirect('course/enrolled_course/' . $enroll_id, 'refresh');
    }

    /* mukul */
     function enroll_new($course_id)
    {
        $usr_array=$this->session->userdata('user_in');
        if($usr_array!=''){
            $enroll = $this->couobj->get_enroll($course_id,$usr_array[0]->stud_id);
            if(empty($enroll))
            {
            $enroll_id = $this->couobj->insert_enroll($course_id,$usr_array[0]->stud_id);
            $user_course=$usr_array[0]->course;
            array_push($user_course,$course_id);
            $usr_array[0]->course=$user_course;
             $this->session->set_userdata('user_in', $usr_array);
              redirect("course/enrolled_course/".$enroll_id);
            }else
            {
                redirect("course/enrolled_course/".$enroll[0]->enroll_id);
            }
        }else{
            redirect("course");
        }
        
    }
    function enroll_start($course_id)
    {
        $usr_array=$this->session->userdata('user_in');
        if($usr_array!=''){
            $enroll = $this->couobj->get_enroll($course_id,$usr_array[0]->stud_id);
            redirect("course/enrolled_course/".$enroll[0]->enroll_id);
        }else{
            redirect("course");
        }
        
    }

}

?>
