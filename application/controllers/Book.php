<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Book extends CI_Controller {

	var $table = 'tb_book';

    public function __construct() {
		parent::__construct();
		$this->load->model('book_model');
        $this->load->model('approve_model');
        $this->load->library('ajax_pagination');
        $this->perPage = 10;

		if (!$this->session->userdata('logged_in')) {
            return redirect('auth');
        }
	}

	public function index() {
        $sessUserData = $this->session->userdata('logged_in');
        $userType = $sessUserData['userType'];
        if($userType == 'Administrative' || $userType == 'Admin'){
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('book/index');
            $this->load->view('template/footer');
        } else {
            return redirect('err404');
        }
        
	}

	public function list(){
		$this->load->view('template/function');
        $list = $this->book_model->getDataTables();
        $number = $this->uri->segment(3)+1;
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$arr = array();
            $arr[] = $number;
			$arr[] = $row->book_receive_no;
			$arr[] = $row->book_sent_no;
			$arr[] = $row->book_from;
            $arr[] = $row->book_title;
			$arr[] = dateThai($row->book_receive_date);
			$arr[] = dateThai($row->book_sent_date);
			$arr[] = $row->user_fname;

			$arr[] = '<button type="button" name="editData" id="'.$row->book_id.'" class="btn btn-outline-warning btn-sm editData"><i class="bi bi-pencil-fill"></i> แก้ไข</button> <button type="button" name="deleteData" id="'.$row->book_id.'" class="btn btn-outline-danger btn-sm deleteData"><i class="bi bi-trash-fill"></i> ลบ</button>';
		
			$data[] = $arr;
            $number++; 
		}

		$output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->book_model->countAll(),
                    "recordsFiltered" => $this->book_model->countFiltered(),
                    "data" => $data,
				);
		echo json_encode($output);
    }

	public function insert(){
		$this->validate();
		date_default_timezone_set('Asia/Bangkok');

        $nPass = $this->input->post('nPass');
        $ackUserApprove = array();
        $ackUserApprove = $this->input->post('ackUserApprove');
        $appUserApprove = $this->input->post('appUserApprove');

		$data = array(
            'book_receive_no'   => $this->input->post('bookReceiveNo'),
            'book_sent_no'      => $this->input->post('bookSentNo'),
            'book_from'         => $this->input->post('bookFrom'),
            'book_title'        => $this->input->post('bookTitle'),
            'book_receive_date' => $this->input->post('bookReceiveDate'),
			'book_sent_date'    => $this->input->post('bookSentDate'),
			'book_files'        => $this->uploads(),
			'book_comment'      => $this->input->post('bookComment'),
			'book_user_update'  => $this->input->post('userId'),
            'created_at'        => date('Y-m-d H:i:s')
        );

        $appBookId = $this->book_model->insert($data);
        if($appBookId){

            if($nPass == 'Pass'){
                $dataApprove = array(
                    'app_status'        => 'Not-Approve',
                    'app_use_paper'     => 'Not-Use',
                    'app_user_approve'  => $appUserApprove,
                    'app_book_id'       => $appBookId,
                );

                $appId = $this->approve_model->insert($dataApprove);
                if($appId){
        
                    $this->db->select('app_user_approve');
                    $this->db->from('tb_approve');
                    $this->db->where('app_id', $appId);
                    $queryApprove = $this->db->get();
                    $rowApprove = $queryApprove->row();
        
                    $this->load->view('template/function');
                    $dateNow = dateThai(date('Y-m-d'));
                    $bookTitle = $this->input->post('bookTitle');
                    $bookComment = $this->input->post('bookComment');
                    $link = site_url('approve/detail/'.$appId.'/'.$rowApprove->app_user_approve);
        
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    date_default_timezone_set("Asia/Bangkok");
        
                    $sToken = "7t35oE8W8tvDHcj2ximS796JiZ0tPbFfshnmlYdiNtm";
                    $sMessage = $dateNow . "\r\n";
                    if($bookComment != ''){
                        $sMessage .= "เรื่อง : " . $bookTitle . "\r\n";
                        $sMessage .= "ลิงค์ : " . $link . "\r\n\r\n";
                        $sMessage .= "เพิ่มเติม : " . $bookComment;
                    } else {
                        $sMessage .= "เรื่อง : " . $bookTitle . "\r\n\r\n";
                        $sMessage .= "ลิงค์ : " . $link;
                    }
        
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

            } else {
                $sessUserData = $this->session->userdata('logged_in');
                $sessUserId = $sessUserData['userId'];

                $dataApprove = array(
                    'app_status'        => 'Approve',
                    'app_use_paper'     => 'Not-Use',
                    'app_user_approve'  => $sessUserId,
                    'app_book_id'       => $appBookId,
                );

                $appId = $this->approve_model->insert($dataApprove);
                $result;
                foreach($ackUserApprove as $userId){
                    $data = array(
                        'ack_status'       => 'Not-Acknowledge',
                        'ack_user_approve' => $userId,
                        'ack_app_id'       => $appId,
                        'ack_book_id'      => $appBookId,
                    );
                    $result = $this->db->insert('tb_acknowledge', $data);
                }

                if($result){

                    $this->load->view('template/function');
                    $dateNow = dateThai(date('Y-m-d'));
                    $bookTitle = $this->input->post('bookTitle');
                    $bookComment = $this->input->post('bookComment');
                    $comment;
                    $link = site_url('acknowledge');

                    if ($bookComment != '') {
                        $comment = $bookComment;
                    } else {
                        $comment = "-";
                    }

                    $this->db->select('ack_id, ack_user_approve, user_fname, user_lname');
                    $this->db->from('tb_acknowledge');
                    $this->db->join('tb_approve', 'tb_acknowledge.ack_app_id = tb_approve.app_id', 'left');
                    $this->db->join('tb_book', 'tb_acknowledge.ack_book_id = tb_book.book_id', 'left');
                    $this->db->join('tb_user', 'tb_acknowledge.ack_user_approve = tb_user.user_id', 'left');
                    $this->db->where('book_id', $appBookId);
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
                    }
                    $sMessage .= "ลิงค์ : " . $link ."\r\n\r\n";
                    $sMessage .= "เพิ่มเติม : " . $comment . "\r\n";

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
            }
        }
        echo json_encode(array("status" => TRUE));
	}

	public function delete($bookId){
        $path = 'uploads/files/';
        $this->db->select('book_files');
		$this->db->from($this->table);
        $this->db->where('book_id', $bookId);
        $queryFiles = $this->db->get()->result_array();
        foreach ($queryFiles as $row) {
            $files = json_decode($row['book_files']);
            if(!empty($files)){
				foreach ($files as $file) {
					if(file_exists($path.$file)){
						@unlink($path.$file);
					} else {
						$errUnlinkFiles = 'File not found P';
						echo $errUnlinkFiles;
					}
				}  
            }
        }
        $result = $this->book_model->delete($bookId);
        if($result){
            $this->db->where('app_book_id', $bookId);
            $query = $this->db->delete('tb_approve');

            $this->db->where('ack_book_id', $bookId);
            $query = $this->db->delete('tb_acknowledge');
        }
		echo json_encode(array("status" => TRUE));
    }

    public function edit(){
        $bookId = $this->input->post('bookId');

        $this->db->where('book_id', $bookId);
        $query = $this->db->get($this->table);

        $this->db->where('book_id', $bookId);
        $queryArr = $this->db->get($this->table)->result_array();

        $output = array();
        foreach($query->result() as $row){
            $output['bookId'] = $row->book_id;
            $output['bookReceiveNo'] = $row->book_receive_no;
            $output['bookSentNo'] = $row->book_sent_no;
            $output['bookFrom'] = $row->book_from;
            $output['bookTitle'] = $row->book_title;
            $output['bookReceiveDate'] = $row->book_receive_date;
            $output['bookSentDate'] = $row->book_sent_date;
            $output['bookComment'] = $row->book_comment;
        }
        $arr = array();
        foreach($queryArr as $row){
            $array = json_decode($row['book_files']);
            foreach ($array as $key => $value) {
                $arr[] = '
                    <div id="fileLocation'.$key.'">
                        <div>
                            <a href="'.base_url().'uploads/files/'.$value.'" target="_blank">
                                <img src="'.base_url().'assets/img/pdf.png" class="rounded" width="40" height="40">
                            </a>
                            <button type="button" id="'.$row['book_id'].'" class="btn btn-outline-danger btn-sm btnRemove" relDiv="'.$key.'" relName="'.$value.'"><i class="bi bi-trash-fill"></i> ลบ</button>
                        </div>
                    </div>  
                ';
            }
        }
        $output['bookFiles'] = $arr;
        echo json_encode($output);
	}

    public function deleteFile(){
        $bookId = $this->input->post('bookId');
        $relName = $this->input->post('relName');

        $this->db->select('*');
		$this->db->from($this->table);
        $this->db->where('book_id', $bookId);
        $query = $this->db->get()->result_array();

        foreach ($query as $row){
            $bookFiles = json_decode($row['book_files']);
        }

        if(count($bookFiles) != 0){
            // Search
            $point = array_search($relName, $bookFiles);
            // Remove from array
            unset($bookFiles[$point]);
            $reIndex = array_values($bookFiles);
            $array = json_encode($reIndex);
            if(!empty($relName)){
                @unlink('uploads/files/'.$relName);
                $this->db->set('book_files', $array);
                $this->db->where('book_id', $bookId);
                $this->db->update($this->table);
                echo json_encode(array("status" => TRUE));
            } else {
                $errUnlink = 'File not found Files';
                echo $errUnlink;
            }
        }
    }

    public function update(){
        $this->validateUpdate();
        date_default_timezone_set('Asia/Bangkok');

        $bookId = $this->input->post('bookId');

        $array = array();
        $files = '';
        $bookFiles = '';

        $this->db->where('book_id', $bookId);
        $query = $this->db->get($this->table)->result_array();
        foreach($query as $row){
            $files = json_decode($row['book_files']);
            if (count($files) != 0) {
                foreach ($files as $key => $value) {
                    if ($value != '') {
                        $array[] = $value;
                    }
                }
            }
        }

        if(!empty($_FILES['bookFiles']['name'])){
            $resultName = $this->uploads();
            $name = json_decode($resultName);
            
            foreach ($name as $key => $value) {
                if ($value != '') {
                    $array[] = $value;
                }
            }
            $bookFiles = json_encode($array);
        } else {
            $bookFiles = json_encode($files);
        }
            
        $data = array(
            'book_receive_no'   => $this->input->post('bookReceiveNo'),
            'book_sent_no'      => $this->input->post('bookSentNo'),
            'book_from'         => $this->input->post('bookFrom'),
            'book_title'        => $this->input->post('bookTitle'),
            'book_receive_date' => $this->input->post('bookReceiveDate'),
			'book_sent_date'    => $this->input->post('bookSentDate'),
			'book_files'        => $bookFiles,
			'book_comment'      => $this->input->post('bookComment'),
			'book_user_update'  => $this->input->post('userId'),
        );

        $this->book_model->update(array('book_id' => $this->input->post('bookId')), $data);
        echo json_encode(array("status" => TRUE));
    }

	public function uploads(){
        $files = $_FILES;
            $count = count($_FILES['bookFiles']['name']);
            for($i=0; $i<$count; $i++):
                $_FILES['bookFiles']['name']= $files['bookFiles']['name'][$i];
                $_FILES['bookFiles']['type']= $files['bookFiles']['type'][$i];
                $_FILES['bookFiles']['tmp_name']= $files['bookFiles']['tmp_name'][$i];
                $_FILES['bookFiles']['error']= $files['bookFiles']['error'][$i];
                $_FILES['bookFiles']['size']= $files['bookFiles']['size'][$i];

                $newName = explode(".",$_FILES['bookFiles']['name']);
                $fileName = $i."-file-".time().rand(00,99).".".end($newName);
                $config['file_name'] = $fileName;
                $config['upload_path'] = './uploads/files/';
                $config['allowed_types'] = 'pdf';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('bookFiles')){
                    $this->upload->data();
                }
                $arrName[] = $fileName;
            endfor;
        $jsonName = json_encode($arrName);
        return $jsonName;
    }

	private function validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

		if($this->input->post('bookReceiveNo') == ''){
            $data['inputerror'][] = 'bookReceiveNo';
            $data['error_string'][] = 'กรุณาระบุ "เลขรับ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookSentNo') == ''){
            $data['inputerror'][] = 'bookSentNo';
            $data['error_string'][] = 'กรุณาระบุ "เลขที่" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookFrom') == ''){
            $data['inputerror'][] = 'bookFrom';
            $data['error_string'][] = 'กรุณาระบุ "รับจาก หน่วยงานใด" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookTitle') == ''){
            $data['inputerror'][] = 'bookTitle';
            $data['error_string'][] = 'กรุณาระบุ "เรื่อง" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookSentDate') == ''){
            $data['inputerror'][] = 'bookSentDate';
            $data['error_string'][] = 'กรุณาเลือก "วันที่ส่ง" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

		if($this->input->post('bookReceiveDate') == ''){
            $data['inputerror'][] = 'bookReceiveDate';
            $data['error_string'][] = 'กรุณาเลือก "วันที่รับ  " ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if(empty($_FILES['bookFiles']['name'])){
            $data['inputerror'][] = 'bookFiles[]';
            $data['error_string'][] = 'กรุณาอัพโหลด "ไฟล์เอกสาร" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

		if(isset($_FILES['bookFiles'])){
            foreach($_FILES['bookFiles']['tmp_name'] as $key => $value){
                $fileExtension = $_FILES['bookFiles']['name'];
                $extension = strtolower(pathinfo($fileExtension[$key], PATHINFO_EXTENSION));
                $allowedImageExtension = array('pdf');
                if(!in_array($extension, $allowedImageExtension)){
                    $data['inputerror'][] = 'bookFiles[]';
                    $data['error_string'][] = 'อัพโหลดได้เฉพาะไฟล์ PDF เท่านั้นค่ะ!';
                    $data['status'] = FALSE;
                }
            }
        }

        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
	}

    private function validateUpdate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

		if($this->input->post('bookReceiveNo') == ''){
            $data['inputerror'][] = 'bookReceiveNo';
            $data['error_string'][] = 'กรุณาระบุ "เลขรับ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookSentNo') == ''){
            $data['inputerror'][] = 'bookSentNo';
            $data['error_string'][] = 'กรุณาระบุ "เลขที่" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookFrom') == ''){
            $data['inputerror'][] = 'bookFrom';
            $data['error_string'][] = 'กรุณาระบุ "รับจาก หน่วยงานใด" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookTitle') == ''){
            $data['inputerror'][] = 'bookTitle';
            $data['error_string'][] = 'กรุณาระบุ "เรื่อง" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('bookSentDate') == ''){
            $data['inputerror'][] = 'bookSentDate';
            $data['error_string'][] = 'กรุณาเลือก "วันที่ส่ง" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

		if($this->input->post('bookReceiveDate') == ''){
            $data['inputerror'][] = 'bookReceiveDate';
            $data['error_string'][] = 'กรุณาเลือก "วันที่รับ  " ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
	}

    public function all(){
        $data = array(); 
         
        $conditions['returnType'] = 'count'; 
        $totalRec = $this->book_model->getRows($conditions); 
         
        $config['target']      = '#dataList'; 
        $config['base_url']    = base_url('book/ajaxPagination'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $this->perPage; 
        $config['link_func']   = 'searchFilter'; 
         
        $this->ajax_pagination->initialize($config); 
         
        $conditions = array( 
            'limit' => $this->perPage 
        ); 
        $data['allBook'] = $this->book_model->getRows($conditions); 
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('book/all', $data);
        $this->load->view('template/footer');
    }

    function ajaxPagination(){ 

        $page = $this->input->post('page'); 
        if(!$page){ 
            $offset = 0; 
        }else{ 
            $offset = $page; 
        } 
         
        $keywords = $this->input->post('keywords'); 
        //$sortBy = $this->input->post('sortBy'); 
        if(!empty($keywords)){ 
            $conditions['search']['keywords'] = $keywords; 
        } 
        // if(!empty($sortBy)){ 
        //     $conditions['search']['sortBy'] = $sortBy; 
        // } 
         
        $conditions['returnType'] = 'count'; 
        $totalRec = $this->book_model->getRows($conditions); 
         
        $config['target']      = '#dataList'; 
        $config['base_url']    = base_url('book/ajaxPagination'); 
        $config['total_rows']  = $totalRec; 
        $config['per_page']    = $this->perPage; 
        $config['link_func']   = 'searchFilter'; 
         
        $this->ajax_pagination->initialize($config); 
         
        $conditions['start'] = $offset; 
        $conditions['limit'] = $this->perPage; 
        unset($conditions['returnType']); 
        $data['allBook'] = $this->book_model->getRows($conditions); 
         
        $this->load->view('book/ajax-data', $data, false); 
    }

    public function detail($bookId){
        $data['query'] = $this->book_model->getDetail($bookId);
        $data['queryX'] = $this->book_model->getFile($bookId);
        $this->load->view('template/header');
        $this->load->view('template/sidebar');
        $this->load->view('book/detail', $data);
        $this->load->view('template/footer'); 
    }

    public function dateSearch(){
        $this->load->view('template/function');

        $fromDate = $this->input->post('fromDate');
        $toDate = $this->input->post('toDate');

        $query = $this->book_model->getDateSearch($fromDate, $toDate);
        $data = array();
        $output = array();
        if(!empty($query)){
            foreach ($query as $row) {
                $data[] = '
                            <a href="'.site_url('book/detail/'.$row['book_id']).'" target="_blank">
                                <div class="card mb-4">
                                <div class="row g-0">
                                    <div class="col-md-2">
                                        <div class="d-flex justify-content-center">
                                            <i class="bi bi-envelope-open" style="font-size: 3.5rem; color: #012970;"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title" style="padding: 20px 0 1px 0;">'.$row['book_title'].'</h5>
                                            <p class="card-text"><small class="text-muted">
                                                <strong>เลขที่ : </strong>'.$row['book_sent_no'].' &nbsp;
                                                <strong>เลขรับ : </strong>'.$row['book_receive_no'].' &nbsp;
                                                <strong>จาก : </strong>'.$row['book_from'].' &nbsp;
                                                <strong>วันที่รับ : </strong>'.dateThai($row["book_receive_date"]).'
                                            </small> <i class="bi bi-check-lg" style="color: #0f5132;"></i></p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </a>
                            ';
            }
        } else {
            $data[] = '<p style="line-height: 35px; margin-left: 20px;">- ไม่พบข้อมูลที่ค้นหา -</p>';
        }
        $output['result'] = $data;
        echo json_encode($output);
        
    }

    

}