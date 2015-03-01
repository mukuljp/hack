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

class Redemption extends Elearn_Controller {

    public function __construct() {

        parent::__construct();
        $this->controller = strtolower(__CLASS__);
        $this->load->model('Dashboard_model', 'dashobj');
    }
	function index() {
        $data = array();
        $sId = 1;
        $dataa['course'] = $this->dashobj->getCourseName($sId);
		$i = 0;
		foreach($dataa['course'] as $course){
			$cid = $course->course_id;
			$score = $this->dashobj->getScoreByCourse($cid);
			$dataa['course'][$i]->score = $score[0]->coins;
			$i++;
		}
		//getScoreByCourse
		
        $this->view("redeem", $dataa);
    }
    }

?>

