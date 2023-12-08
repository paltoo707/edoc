<?php
class Err404 extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->output->set_status_header('404');
        $this->load->view('err404');    
    }

    public function redirect(){
        $sess = $this->session->userdata('logged_in');
        if($sess['userType'] == 'Boss'){
            return redirect('approve');
        } else {
            return redirect('acknowledge');
        }
    }

}