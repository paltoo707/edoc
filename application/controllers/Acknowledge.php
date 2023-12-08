<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Acknowledge extends CI_Controller {

    var $table = 'tb_acknowledge';

    public function __construct() {
		parent::__construct();
        $this->load->model('acknowledge_model');

		if (!$this->session->userdata('logged_in')) {
            return redirect('auth');
        }
	}

    public function index(){
        $sessUserData = $this->session->userdata('logged_in');
        $appUserAcknowledge = $sessUserData['userId'];
        $userType = $sessUserData['userType'];
        $data['query'] = $this->acknowledge_model->getNotAcknowledge($appUserAcknowledge);
        if($userType != 'Boss'){
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('acknowledge/index',$data);
            $this->load->view('template/footer');
        } else {
            return redirect('err404');
        }
    }

    public function detail($ackId, $ackUserApprove){
        $sessUserData = $this->session->userdata('logged_in');
        $userId = $sessUserData['userId'];
        $data['query'] = $this->acknowledge_model->getDetail($ackId);
        $data['queryX'] = $this->acknowledge_model->getFile($ackId);
        $data['ackId'] = $ackId;
        if($ackUserApprove == $userId){
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('acknowledge/detail',$data);
            $this->load->view('template/footer');
        } else {
            return redirect('err404');
        }
        
    }

    public function insert(){
        $this->validate();
        $ackUserApprove = array();
        $ackUserApprove = $this->input->post('ackUserApprove');
        $appId = $this->input->post('appId');
        $bookId = $this->input->post('bookId');
        $result;

        foreach($ackUserApprove as $userId){
            $data = array(
                'ack_status'       => 'Not-Acknowledge',
                'ack_user_approve' => $userId,
                'ack_app_id'       => $appId,
                'ack_book_id'      => $bookId,
            );
            $result = $this->db->insert($this->table, $data);
        }

        if($result){
            $bookTitle ='';
            $appUsePaper ='';
            $appComment ='';
            $this->load->view('template/function');
            $dateNow = dateThai(date('Y-m-d'));
            $link = site_url('acknowledge');

            $this->db->select('book_title, app_use_paper, app_comment');
            $this->db->from('tb_book');
            $this->db->join('tb_approve', 'tb_book.book_id = tb_approve.app_book_id', 'left');
            $this->db->where('book_id', $bookId);
            $query = $this->db->get();
            $row = $query->row();
            $bookTitle = $row->book_title;
            $appUsePaper = $row->app_use_paper;
            $appComment = $row->app_comment;

            if ($row->app_use_paper == 'Not-Use') {
                $appUsePaper = "ไม่ปริ้นเอกสาร";
            } else {
                $appUsePaper = "ปริ้นเอกสาร";
            }
            if ($row->app_comment != '') {
                $appComment = $row->app_comment;
            } else {
                $appComment = "-";
            }

            $this->db->select('ack_id, ack_user_approve, user_fname, user_lname');
            $this->db->from('tb_acknowledge');
            $this->db->join('tb_approve', 'tb_acknowledge.ack_app_id = tb_approve.app_id', 'left');
            $this->db->join('tb_book', 'tb_acknowledge.ack_book_id = tb_book.book_id', 'left');
            $this->db->join('tb_user', 'tb_acknowledge.ack_user_approve = tb_user.user_id', 'left');
            $this->db->where('book_id', $bookId);
            $this->db->where('app_id', $appId);
            $queryx = $this->db->get()->result();

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            date_default_timezone_set("Asia/Bangkok");

            $sToken = "vqbMdySyC381jHnsMVQNLLiF58z6pw1MwRFC7vvQUJq";
            $sMessage = $dateNow . "\r\n";
            $sMessage .= "เรื่อง : " . $bookTitle . "\r\n";
            $sMessage .= "มอบหมาย : \r\n";
            foreach ($queryx as $rowx) {
                $sMessage .= " - " . $rowx->user_fname . " ". $rowx->user_lname . "\r\n";
                //$sMessage .= "ลิงค์ : " . site_url('acknowledge/detail/'.$rowx->ack_id.'/'.$rowx->ack_user_approve).  "\r\n\r\n";
            }
            $sMessage .= "ลิงค์ : " . $link ."\r\n\r\n";
            $sMessage .= "เอกสาร : " . $appUsePaper . "\r\n";
            $sMessage .= "เพิ่มเติม : " . $appComment . "\r\n";

            $chOne = curl_init(); 
            curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
            curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
            curl_setopt( $chOne, CURLOPT_POST, 1); 
            curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
            $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
            curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
            curl_exec( $chOne );
            curl_close( $chOne );
        }
        echo json_encode(array("status" => TRUE));
        
    }

    public function update(){

        $data = array(
            'ack_status'   => 'Acknowledge'
        );
        $this->acknowledge_model->update(array('ack_id' => $this->input->post('ackId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

		if($this->input->post('ackUserApprove') == ''){
            $data['inputerror'][] = 'ackUserApprove';
            $data['error_string'][] = 'กรุณาเลือก "ผู้รับมอบหมายด้วยค่ะ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
	}

}