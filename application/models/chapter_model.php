<?php

class Chapter_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
         $this->load->model('Course_model', 'couobj');
    }

    function getQuestions($test_id) {
        $this->db->where('qus_testid', $test_id);
        $this->db->order_by("qus_sortorder", "asc");
        $result = $this->db->get('e_test_questions');
        return $result->result_array(); 
      
    }
    function getQusOptions($ques_id){
        $this->db->where('opt_qusid', $ques_id);
        $result = $this->db->get('e_test_options');
        return $result->result_array(); 
    }
    function saveStudentAnswer($student_id,$ques_id,$answ_id,$last){
        if(list($test_id,$course_id,$right_id) = $this->getTestCourseFromQid($ques_id)){
            
            if($answ_id==$right_id){
                    $ans_identifier = 'R';
                }
                else{
                    $ans_identifier = 'W';
                    $this->reduceLife($student_id);
                }
            if($this->alreadyAnswered($student_id,$ques_id)){
                $this->upDateAnswer($student_id,$ques_id,$answ_id,$ans_identifier);
            }
            else{
                $this->insertAnswer($student_id,$ques_id,$answ_id,$test_id,$course_id,$ans_identifier);
            }
            if($last=="last"){
                $this->updateChapterStatus($student_id,$test_id,$course_id);
                $data['score_board'] = $this->getThisChapterScoreboard($test_id);
                $data['enroll_id'] = $this->getEnrollId($test_id);
                 $sy_id = $this->getSysIdFromTestid($test_id);
                // $next_sysid = $this->getNextChapterId($sy_id,$course_id);
                 $data['chapter_id'] = $test_id;
                 // $id=$this->couobj->insertcompleted_status($data['enroll_id'], $student_id, $course_id, $sy_id);
                return $data;
            }
            return true;
        }
        return false;
    }
    function getNextChapterId($sy_id,$course_id){
        $where = array('sy_id'=>$sy_id,'sy_courseid'=>$course_id,'sy_parent'=>0);
        $result = $this->db
            ->select('sy_id')
            ->where($where)
            ->order_by('sy_sortorder','ASC')
            ->get('e_syllabus');
        if($result && $result->num_rows()>0){
            $data = $result->result_array();
            return $data['sy_id'];
        }
        return false;
    }
    function getSysIdFromTestid($test_id){
        $result = $this->db
            ->select('test_syid')
            ->where('test_id', $test_id)
            ->get('e_tests');
        if($result && $result->num_rows()>0){
            $data = $result->row_array();
            return $data['test_syid'];
            
        }
        return false;
    }
    function reduceLife($student_id){
        $query = "UPDATE e_students SET stud_life = stud_life - 1 WHERE stud_id = ?";
        $result = $this->db->query($query,array($student_id));
        return true;
        
    }
    function getEnrollId($test_id){
        $result = $this->db
            ->select('enroll_id')
            ->from('e_enroll as ee')
            ->join('e_tests as et','et.test_course=ee.enroll_courseid','join')
            ->where('test_id', $test_id)
            ->get();
            if($result && $result->num_rows()>0){
                $data = $result->row_array();
                return $data['enroll_id'];
            }
        return false;
    }
    function getThisChapterScoreboard($test_id){
        $result = $this->db
            ->where('score_testid', $test_id)
            ->get('e_score');
        if($result && $result->num_rows()>0){
            return $result->result_array(); 
        }
        return false;
    }
    function getTestCourseFromQid($ques_id){
        $result = $this->db
            ->select('qus_testid,test_course,qus_rightoption')
            ->from('e_test_questions as etq')
            ->join('e_tests as et','et.test_id=etq.qus_testid','join')
            ->where('qus_id', $ques_id)
            ->get();
        if($result && $result->num_rows()>0){
            $data = $result->row_array();
            return array($data['qus_testid'],$data['test_course'],$data['qus_rightoption']);
        }
        return false;
    }
    function alreadyAnswered($student_id,$ques_id){
        $where = array('score_studid'=>$student_id ,'score_qid'=>$ques_id);
        $this->db->where($where);
        $result = $this->db->get('e_score');
        if($result && $result->num_rows()>0){
            return  true;
        }
        return false;
    }
    function upDateAnswer($student_id,$ques_id,$answ_id,$ans_identifier){
        $update = array('score_stud_answer'=>$answ_id,'score_result'=>$ans_identifier);
        $where = array('score_qid'=>$ques_id,'score_studid'=>$student_id);
        $this->db
            ->where($where)
            ->update('e_score',$update);
            return true;
    }
    function insertAnswer($student_id,$ques_id,$answ_id,$test_id,$course_id,$ans_identifier){
        $insert_array = array('score_studid'=>$student_id,'score_qid'=>$ques_id,'score_testid'=>$test_id,'score_courseid'=>$course_id,'score_stud_answer'=>$answ_id,'score_result'=>$ans_identifier);
        if($this->db->insert('e_score',$insert_array)){
            return $this->db->insert_id();
        }
        return false;  
    }
    //function updateChapterStat($ques_id,$student_id){
    //    if(list($test_id,$course_id,$right_id) = $this->getTestCourseFromQid($ques_id)){
    //        $this->updateChapterStatus($student_id,$test_id,$course_id);
    //        return true;
    //    }
    //    return false;
    //}
    function updateChapterStatus($student_id,$test_id,$course_id){
        if(!$this->alreadyStarted($student_id,$test_id,$course_id)){
            $insert_array = array('chapt_studid'=>$student_id,'chapt_courseid'=>$course_id,'chapt_lastchapter'=>$test_id);
            if($this->db->insert('e_chapter_status',$insert_array)){
                return $this->db->insert_id();
            }
        }
        return true;
    }
    function alreadyStarted($student_id,$test_id,$course_id){
        $where = array('chapt_studid'=>$student_id ,'chapt_courseid'=>$course_id);
        $this->db->where($where);
        $result = $this->db->get('e_chapter_status');
        if($result && $result->num_rows()>0){
            $update = array('chapt_lastchapter'=>$test_id);
            $where = array('chapt_studid'=>$student_id ,'chapt_courseid'=>$course_id);
            $this->db
                ->where($where)
                ->update('e_chapter_status',$update);
                return true;
        }
        return false;
    }
    function getLifeAvailable($student_id){
        $where = array('stud_id'=>$student_id);
	$result = $this->db
            ->select('stud_life')
            ->from('e_students as es')
            ->where($where)
            ->get();
        if($result && $result->num_rows()>0){
           $data = $result->row_array();
            $reduced = $data['stud_life'];
            return $reduced;
        }
        return 0;
    }
   	function getCoins($student_id){
       $where = array('score_studid'=>$student_id,'score_result'=>"R");
$result = $this->db
           ->select('COUNT(*) as counter')
           ->where($where)
           ->get('e_score');
       if($result && $result->num_rows()>0){
           $counter = $result->row_array();
           $count = $counter['counter'];
           $count = $count*10;
           return $count;
       }
       return 0;
   }
   function wrongCoins($student_id){
       $where = array('score_studid'=>$student_id,'score_result'=>"W");
$result = $this->db
           ->select('COUNT(*) as counter')
           ->where($where)
           ->get('e_score');
       if($result && $result->num_rows()>0){
           $counter = $result->row_array();
           $count = $counter['counter'];
           $count = $count*10;
           return $count;
       }
       return 0;
   }
    function getReducedCoins($student_id){
        $where = array('red_studid'=>$student_id);
	$result = $this->db
            ->select('SUM(red_point) as reduced_sum')
            ->from('e_reduction')
            ->where($where)
            ->get();
        if($result && $result->num_rows()>0){
            $data = $result->row_array();
            $reduced = $data['reduced_sum'];
            return $reduced;
        }
        return 0;
    }
    function getCourseIdFromEnroll($enroll_id){
        $where = array('enroll_id'=>$enroll_id);
	$result = $this->db
            ->select('enroll_courseid')
            ->from('e_enroll')
            ->where($where)
            ->get();
        if($result && $result->num_rows()>0){
            $data = $result->row_array();
            $count = $data['enroll_courseid'];
            return $count;
        }
        return 0;
    }
    function increaseLife($student_id){
        $query = "UPDATE e_students SET stud_life = stud_life + 10 WHERE stud_id = ?";
        $result = $this->db->query($query,array($student_id));
        return true;  
    }
    function reduceCoins($student_id){
         $insert_array = array('red_studid'=>$student_id,'red_point'=>'-100','red_description'=>'To regain 10 life','red_type'=>'test');
        if($this->db->insert('e_reduction',$insert_array)){
            return $this->db->insert_id();
        }
        return false;  
    }
    
}

?>