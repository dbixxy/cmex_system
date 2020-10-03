<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
 class Meeting extends MY_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Meeting_model','Meeting');
        $this->load->model('Board_model','Board');
        $this->load->model('File_model','File');

        $config['upload_path']   = './uploads/'; 
        $config['allowed_types'] = 'gif|jpg|png|doc|docx|xls|xlsx|pdf'; 
        $config['max_size']      = 256000; 
        $this->load->library('upload', $config);

    }
    
    function index($meeting_id = NULL){
        if($meeting_id == NULL){
            $this->meetings();
        }
        else{
            $this->meeting($meeting_id);
            // redirect('/meeting/' . $evaluation_id);
        }
       
    }

    function meetings(){
        $this->data['meetings'] = $this->Meeting->getMeetings();

        $this->breadcrumb->add('หน้าหลัก', base_url() .'Home');     
        $this->breadcrumb->add('การประชุม',   base_url().'Meeting/meetings/');  
        $this->data['breadcrumb'] = $this->breadcrumb->output();

        $this->data['head_title'] = "การประชุม";
        $this->loadData();
        $this->loadViewWithScript(array('meeting/meetings_view'), array());    
    }
    
    function meeting($meeting_id){
        $this->data['meeting'] = $this->Meeting->getMeeting($meeting_id);

        $this->breadcrumb->add('หน้าหลัก', base_url() .'Home');    
        $this->breadcrumb->add('การประชุม',   base_url().'Meeting/meetings/');  
        $this->breadcrumb->add('รายละเอียดการประชุม',   base_url().'Meeting/meeting/' . $meeting_id);  
        $this->data['breadcrumb'] = $this->breadcrumb->output();

        $this->data['head_title'] = "รายละเอียดการประชุม";
        $this->loadData();
        $this->loadViewWithScript(array('meeting/meeting_view'), array());    
    }
    

    function addMeeting(){   
        $this->data['error'] = $this->db->error(); 
        $this->data['method'] = "add";
        $this->data['boards'] = $this->Board->getBoards();

        $this->breadcrumb->add('หน้าหลัก', base_url() .'Home');      
        $this->breadcrumb->add('การประชุม',   base_url().'Meeting/meetings');    
        $this->breadcrumb->add('เพิ่ม การประชุม',   base_url().'Meeting/addMeeting');      
        $this->data['breadcrumb'] = $this->breadcrumb->output();

        $this->data['head_title'] = "เพิ่ม การประชุม";
        $this->loadData();
        $this->loadViewWithScript(array('meeting/meeting_form_view'), array('meeting/meeting_form_script'));      
    }

    function addMeetingDo(){
        
        // $number_of_files_uploaded = count($_FILES['upl_files']['name']);
        $final_files_data = array();
        // Faking upload calls to $_FILE
        // for ($i = 0; $i < $number_of_files_uploaded; $i++){
        if(!empty($_FILES['upl_files']['name']) && count(array_filter($_FILES['upl_files']['name'])) > 0){ 
        // foreach($_FILES['upl_files']['name'] as $index => $file_name){
            $filesCount = count($_FILES['upl_files']['name']); 
            for($i = 0; $i < $filesCount; $i++){ 
                $user_file = array();
                
                $user_file['name']     = $_FILES['upl_files']['name'][$i];
                $user_file['type']     = $_FILES['upl_files']['type'][$i];
                $user_file['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
                $user_file['error']    = $_FILES['upl_files']['error'][$i];
                $user_file['size']     = $_FILES['upl_files']['size'][$i];
                
                $config['file_name'] = $user_file['name'];
                $config['upload_path']   = './uploads/'; 
                $config['allowed_types'] = 'gif|jpg|png|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|csv'; 
                $config['max_size']      = 256000; 
                $config['upload_path'] = './uploads/';
                $config['max_width'] = '4096';
                $config['max_height'] = '4096';
                
                
                $this->upload->initialize($config);
                // if (!$this->upload->do_upload()){
                if (!$this->upload->do_upload($user_file['name'])){
                    $error = array('error' => $this->upload->display_errors());
                    //$this->load->view('upload_form', $error);
                }else{
                    $final_files_data[] = $this->upload->data();
                    // Continue processing the uploaded data
                    
                }
            }
        }
        $result = $this->Meeting->addMeeting($final_files_data);
        
        if(!$result){
            $this->addMeeting();
        }else{
            $this->meetings();
            
        }
        
    }

    function updateMeeting($meeting_id){   
        $this->data['error'] = $this->db->error(); 
        $this->data['method'] = "update";

        $this->data['meeting'] = $this->Meeting->getMeeting($meeting_id);
        $this->data['boards'] = $this->Board->getBoards();

        $this->breadcrumb->add('หน้าหลัก', base_url() .'Home');      
        $this->breadcrumb->add('การประชุม',   base_url().'Meeting/meetings');    
        $this->breadcrumb->add('แก้ไข การประชุม',   base_url().'Meeting/updateMeeting/' . $meeting_id);      
        $this->data['breadcrumb'] = $this->breadcrumb->output();

        $this->data['head_title'] = "แก้ไข การประชุม";
        $this->data['meeting'] = $this->Meeting->getMeeting($meeting_id);
        $this->loadData();
        $this->loadViewWithScript(array('meeting/meeting_form_view'), array('meeting/meeting_form_script'));      
    }
    
    function updateMeetingDo(){
        
        $result = $this->Meeting->updateMeeting();
        //echo $result;
        if(!$result){
            //$this->addMeeting();
            $this->meetings(); 
        }else{
            $this->meetings(); 
        }
    }

    function deleteMeetingDo($meeting_id){
        
        $result = $this->Meeting->deleteMeeting($meeting_id);
        
        if(!$result){
            //$this->addMeeting();
            $this->meetings(); 
        }else{
            $this->meetings(); 
        }
    }

    function getBoardPersonsService($board_id){
        echo json_encode($this->Meeting->getBoardPersons($board_id));
    }
 }
 ?>