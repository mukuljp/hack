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

class Dashboard extends Elearn_Controller {

    public function __construct() {

        parent::__construct();
        $this->controller = strtolower(__CLASS__);
        $this->load->model('Dashboard_model', 'dashobj');
		$this->load->model('coursediscussion_model', 'couobj');
		$this->load->model('Chapter_model', 'chapter');
    }

    //put your code here
    function index() {
        $data = array();
        $sId = 1;
	if($this->session->userdata('user_in')!=""){
		$userData = $this->session->userdata('user_in');
		$student_id = $userData[0]->stud_id;
		}else
        $student_id = 1;
	
        $dataa = array();
		$dataa['life_available'] =  $this->chapter->getLifeAvailable($student_id);
		$coins = $this->chapter->getCoins($student_id);
		$reduced_coins = $this->chapter->getReducedCoins($student_id);
		//$wrong_coins = $this->chapter->wrongCoins($student_id);
		$total = $coins+$reduced_coins;
		$dataa['coins_available'] = $total;	
        $dataa['course'] = $this->dashobj->getCourseName($sId);
		$i = 0;
		foreach($dataa['course'] as $course){
			$cid = $course->course_id;
			$score = $this->dashobj->getScoreByCourse($cid,$student_id);
			$dataa['course_data'][$cid] = $score;
			$i++;
		}
		//getScoreByCourse
        $this->view("dashboard", $dataa);
    }
	function course_discussion(){
		$courseId = $this->uri->segment(3, 0);
		$data = array();
		// $data['categories'] = $this->couobj->get_categoroes();
		$data['cname'] = $this->couobj->getMainCourseName($courseId);
		$data['discdetail'] = $this->couobj->getDiscussionDetails($courseId);
		$this->view("course_discussion",$data);
}

}

?>
