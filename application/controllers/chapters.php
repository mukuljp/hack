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

class Chapters extends Elearn_Controller {

    public function __construct() {

        parent::__construct();
        $this->controller = strtolower(__CLASS__);
        $this->load->model('Chapter_model', 'chapter');
    }
    //put your code here
    function question($test_id){
	if($this->session->userdata('user_in')!=""){
		$userData = $this->session->userdata('user_in');
		$student_id = $userData[0]->stud_id;
		}else
        $student_id = 1;
	
        $data = array();
		$data['life_available'] =  $this->chapter->getLifeAvailable($student_id);
		$coins = $this->chapter->getCoins($student_id);
		$reduced_coins = $this->chapter->getReducedCoins($student_id);
		//$wrong_coins = $this->chapter->wrongCoins($student_id);
		$total = $coins+$reduced_coins;
		$data['coins_available'] = $total;
	
        $answers = array();
        if(isset($test_id) && $test_id>0){
            $data['questions'] = $this->chapter->getQuestions($test_id);
            foreach($data['questions'] as $question){
                $answers[$question['qus_id']] = $this->chapter->getQusOptions($question['qus_id']);
                
            }
            $data['answers'] = $answers;
            $this->view("questions.php",$data);
        }
        
    }
    function saveStudentAnswer(){
        // need to take it from session
		if($this->session->userdata('user_in')!=""){
		$userData = $this->session->userdata('user_in');
		$student_id = $userData[0]->stud_id;
		}else
        $student_id = 1;
        $ques_id = $_POST["question_id"];
        $answ_id = $_POST["anwr_option"];
        $last = $_POST["last"];
        if($dataV = $this->chapter->saveStudentAnswer($student_id,$ques_id,$answ_id,$last)){
            if($dataV && !empty($dataV)){
                $data['score_board'] = $dataV['score_board'];
                $data['enroll_id'] = $dataV['enroll_id'];
                $data['chapter_id'] = $dataV['chapter_id'];
            }
            else{
                 $data['score_board'] = '';
            }
            $data['status'] = 1; 
        }
        else{
            $data['status'] = 0;
        }
        echo json_encode($data);
    }
    function updateChapterStatus(){
        // need to take it from session
        if($this->session->userdata('user_in')!=""){
		$userData = $this->session->userdata('user_in');
		$student_id = $userData[0]->stud_id;
		}else
        $student_id = 1;
        $ques_id = $_POST["question_id"];
        $this->chapter->updateChapterStat($ques_id,$student_id);
        
    }
    function regainLife(){
	if($this->session->userdata('user_in')!=""){
		$userData = $this->session->userdata('user_in');
		$student_id = $userData[0]->stud_id;
		}else
        $student_id = 1;
	
	$coins = $this->chapter->getCoins($student_id);
	$reduced_coins = $this->chapter->getReducedCoins($student_id);
	$total = $coins+$reduced_coins;
	if($total>100){
	    $this->chapter->increaseLife($student_id);
	    $this->chapter->reduceCoins($student_id);
	}
	else{
	     $this->chapter->increaseLife($student_id);
	}
	$data['status'] = 1;
	echo json_encode($data);
    }
    
    
}

?>
