<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct(){
        parent::__construct();
        //$GLOBALS['user_link'] = $_SERVER['HTTP_REFERER'];
        //Initialization code that affects all controllers
        $this->load->library('session');
        $this->load->helper('cookie');
        $this->load->helper('url');

        $cookie_name = "user_link";
        $cookie_value = current_url();
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

        // [Back Recruit]
        if($this->check_isvalidated()){
            $this->load->library('user_agent');
            $this->load->library('Breadcrumb');
            $this->load->helper('form');
            $this->load->helper('../../common/helpers/thai_date');
            $this->load->helper('../../common/helpers/remote_file_exists');
            $this->load->helper('../../common/helpers/money_format'); // [ton][22/04/2564][add helper of project recruit]
            $this->data['system']="backend";
        }else if(!$this->check_isvalidated()){ // [ton][24/04/2564][add control Frontend Recruit]
            $this->load->model('Recruit_model','RecruitModel');
            $this->load->library('user_agent');
            $this->load->library('Breadcrumb');
            $this->load->helper('form');
            $this->load->helper('../../common/helpers/thai_date');
            $this->load->helper('../../common/helpers/remote_file_exists');
            $this->load->helper('../../common/helpers/money_format');
            $this->data['system']="frontend";
        }

    }

    protected function loadData(){
        $this->data['session_username'] = $this->session->username;
        $this->data['session_name'] = $this->session->name;
        $this->data['session_position_name'] = $this->session->position_name;
        $this->data['validated'] = $this->session->validated;
        // $this->data['session_numot']=$this->session->NUM_OT;
    }
    
    protected function loadView($body_views){
        $this->load->view('common/header', $this->data);
        $this->load->view('common/navbar', $this->data);
        $this->load->view('common/sidebar', $this->data);
        $this->load->view('common/main_head', $this->data);
        foreach($body_views as $body_view){
            $this->load->view($body_view, $this->data);
        }
        $this->load->view('common/footer',$this->data);
        $this->load->view('common/end',$this->data);
    }

    protected function loadViewWithScript($body_views,$body_scripts){
        $this->load->view('common/header', $this->data);
        $this->load->view('common/navbar', $this->data);
        $this->load->view('common/sidebar', $this->data);
        $this->load->view('common/main_head', $this->data);
        foreach($body_views as $body_view){
            $this->load->view($body_view, $this->data);
        }
        $this->load->view('common/footer',$this->data);
        foreach($body_scripts as $body_script){
            $this->load->view($body_script, $this->data);
        }
        $this->load->view('common/end',$this->data);
    }

    // [ton][24/04/2564][Add function front_loadViewWithScript()][Frontend Recruit]
    protected function front_loadViewWithScript($body_views,$body_scripts){
        $this->load->view('common/header', $this->data);
        $this->load->view('common/main_head', $this->data);
        foreach($body_views as $body_view){
            $this->load->view($body_view, $this->data);
        }

        $this->load->view('common/footer',$this->data);
        foreach($body_scripts as $body_script){
            $this->load->view($body_script, $this->data);
        }

        $this->load->view('common/end',$this->data);
    }

    protected function check_isvalidated(){
        if((!isset($this->session->validated)) || (!$this->session->validated)){    // Login is CI_Controller that can redirect
            // redirect( base_url() . 'Login/');                                    //[ton][24/04/2564][commnet out for add frontend]
            // header("location: " .  base_url() . 'Login/');
            return false;
        }else{                                                                      // Home is MY_Controller will redirect loop back itself don't do it here
            return true;
        }
    }

    protected function check_canAccess($class_name, $method_name){
        // $tmp = $class_name . "/" . $method_name;
        // if(in_array($tmp,$this->session->access, TRUE)){
        //     return true;
        // }
        header("location:javascript://history.go(-1)");
    }

}
