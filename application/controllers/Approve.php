<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approve extends CI_Controller {

    public function __construct() {
		parent::__construct();
        $this->load->model('approve_model');

		if (!$this->session->userdata('logged_in')) {
            return redirect('auth');
        }
	}

    public function index() {
        $sessUserData = $this->session->userdata('logged_in');
        $appUserApprove = $sessUserData['userId'];
        $userType = $sessUserData['userType'];
        $data['query'] = $this->approve_model->getNotApprove($appUserApprove);
        if($userType == 'Boss'){
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('approve/index',$data);
            $this->load->view('template/footer');
        } else {
            return redirect('err404');
        }
	}

    public function detail($appId, $appUserApprove){
        $sessUserData = $this->session->userdata('logged_in');
        $userId = $sessUserData['userId'];
        $data['query'] = $this->approve_model->getDetail($appId);
        $data['queryX'] = $this->approve_model->getFile($appId);
        if($appUserApprove == $userId){
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('approve/detail',$data);
            $this->load->view('template/footer');
        } else {
            return redirect('err404');
        }
        
    }

    public function userApprove(){
        $this->db->select('user_id, user_fname, user_lname');
        $this->db->from('tb_user');
        $this->db->where('user_type', 'Boss');
        $query = $this->db->get()->result();
        $arr = array();
        if(count($query) > 1) {
            $arr[] = '<option selected>เลือก</option>';
            foreach ($query as $row){
                $arr[] = '<option value="'.$row->user_id.'">'.$row->user_fname.' '.$row->user_lname.'</option>';
            }
        } else {
            foreach ($query as $row) {
                $arr[] = '<option value="'.$row->user_id.'">'.$row->user_fname.' '.$row->user_lname.'</option>';
                
            }
        }
        $output['appUserApprove'] = $arr;
        echo json_encode($output);
    }

    public function userApproveEdit(){
        $bookId = $this->input->post('bookId');
        $this->db->select('user_id, user_fname, user_lname');
        $this->db->from('tb_approve');
        $this->db->join('tb_user', 'tb_user.user_id = tb_approve.app_user_approve', 'left');
        //$this->db->where('user_type', 'Boss');
        $this->db->where('app_book_id', $bookId);
        $query = $this->db->get()->result();
        $arr = array();
        foreach ($query as $row) {
            $arr[] = '<input type="text" class="form-control" value="'.$row->user_fname.' '.$row->user_lname.'" id="appUserApprove" name="appUserApprove" disabled>';
            //$arr[] = '<option value="'.$row->user_id.'">'.$row->user_fname.' '.$row->user_lname.'</option>';
        }
        $output['appUserApprove'] = $arr;
        echo json_encode($output);
    }

    public function updateApprove(){


        $appUsePaper = $this->input->post('appUsePaper');
        $appComment = $this->input->post('appComment');


        $data = array(
            'app_use_paper'   => $appUsePaper,
            'app_comment'     => $appComment,
        );
        $this->approve_model->update(array('app_id' => $this->input->post('appId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function update(){

        $data = array(
            'app_status'   => 'Approve'
        );
        $this->approve_model->update(array('app_id' => $this->input->post('appId')), $data);
        echo json_encode(array("status" => TRUE));
    }

}