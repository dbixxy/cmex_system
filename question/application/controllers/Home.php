<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
 class Home extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('EvaluatePerson_model','EvaluatePerson');
        $this->load->model('Evaluation_model','Evaluation');
        $this->load->model('Answer_model','Answer');
    }
    
    function index($evaluation_id = NULL){
        if($evaluation_id == NULL){
            $this->forms();
        }
        else{
            $this->form($evaluation_id);
            // redirect('/form/' . $evaluation_id);
        }
       
    }

    function forms(){
        $this->data['evaluates'] = $this->EvaluatePerson->getNotEvaluatesPerson($this->session->username);

        $this->breadcrumb->add('หน้าหลัก', base_url() .'Home');     
        $this->data['breadcrumb'] = $this->breadcrumb->output();

        $this->data['head_title'] = "หน้าหลัก";
        $this->loadData();
        $this->loadViewWithScript(array('home_view'), array());    
    }
    
    function form($evaluation_id){
        if($this->Evaluation->chkEvaluation($evaluation_id)){
            $this->data['evaluation'] = $this->Evaluation->getEvaluation($evaluation_id);
            $this->data['form_details'] = $this->Evaluation->getFormDetails($evaluation_id);

            $this->breadcrumb->add('หน้าหลัก', base_url() .'Home');    
            $this->breadcrumb->add('แบบประเมิน',   base_url().'Home/form/' . $evaluation_id);  
            $this->data['breadcrumb'] = $this->breadcrumb->output();

            $this->data['head_title'] = "หน้าหลัก";
            $this->loadData();
            $this->loadViewWithScript(array('form_view'), array('form_script'));    
        }
        else{
            redirect('/Home');
        }
    }

    function formDo($evaluation_id){
        $result = $this->Answer->addAnswer();
        
        if(!$result){
            $this->form($evaluation_id);
        }else{
            $this->forms(); 
        }
    }
    

    public function do_logout(){
        $this->session->sess_destroy();
        redirect('/Home');
    }
    
 }
 ?>