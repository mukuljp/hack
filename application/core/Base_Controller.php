<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base_controller
 *
 * @author user
 */
class Base_Controller extends CI_Controller{
    //put your code here
   function __cunstruct(){
       parent::cunstruct();
       
       
   }
   
   function view($viewname,$data){
       $this->load->view("header");
       $this->load->view($viewname,$data);
       $this->load->view("header");
   }
}

?>
