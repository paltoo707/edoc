<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {

    var $table = 'tb_user';

    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');

        if (!$this->session->userdata('logged_in')) {
            return redirect('auth');
        }

    }

	public function index(){
        $sessUserData = $this->session->userdata('logged_in');
        $userType = $sessUserData['userType'];
        if($userType == 'Admin'){
            $this->load->view('template/header');
            $this->load->view('template/sidebar');
            $this->load->view('user/index');
            $this->load->view('template/footer');
        } else {
            return redirect('err404');
        }
	}

    public function list(){
        $list = $this->user_model->getDataTables();
        $number = $this->uri->segment(3)+1;
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $row) {
			$arr = array();
            $arr[] = $number;
            if($row->user_image == ''){
                $arr[] = '<img src="'.base_url().'assets/img/blank-profile.gif" alt="Profile" class="rounded-circle" width="36" height="36">';
            } else {
                $arr[] = '<img src="'.base_url().'uploads/images/users/'.$row->user_image.'" alt="Profile" class="rounded-circle" width="36" height="36">';
            }
			$arr[] = $row->user_fname.' '.$row->user_lname;
			$arr[] = $row->username;
			$arr[] = $row->user_type;
            $arr[] = $row->user_status;

			$arr[] = '<button type="button" name="editData" id="'.$row->user_id.'" class="btn btn-outline-warning btn-sm editData"><i class="bi bi-pencil-fill"></i> แก้ไข</button> <button type="button" name="deleteData" id="'.$row->user_id.'" class="btn btn-outline-danger btn-sm deleteData"><i class="bi bi-trash-fill"></i> ลบ</button>';
		
			$data[] = $arr;
            $number++; 
		}

		$output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->user_model->countAll(),
                    "recordsFiltered" => $this->user_model->countFiltered(),
                    "data" => $data,
				);
		echo json_encode($output);
    }

	public function insert(){
		$this->validate();
        $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        date_default_timezone_set('Asia/Bangkok');

        $data = array(
            'user_fname'  => $this->input->post('userFname'),
            'user_lname'  => $this->input->post('userLname'),
            'user_type'   => $this->input->post('userType'),
            'user_image'  => $this->upload(),
            'user_status' => $this->input->post('userStatus'),
            'username'    => $this->input->post('username'),
            'password'    => $password,
            'created_at'  => date('Y-m-d H:i:s')
        );
        $this->user_model->insert($data);
        echo json_encode(array("status" => TRUE));
	}

    public function delete($userId){
        $path = 'uploads/images/users/';
        $this->db->select('user_image');
		$this->db->from($this->table);
        $this->db->where('user_id', $userId);
        $queryImage = $this->db->get();
        foreach ($queryImage->result() as $row) {
            $image = $row->user_image;
            if(!empty($image)){
                if(file_exists($path.$image)){
                    @unlink($path.$image);
                } else {
                    $errUnlinkImage = 'File not found P';
                    echo $errUnlinkImage;
                }  
            }
        }

        if(empty($errUnlinkImage)){
            $this->user_model->delete($userId);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function edit(){
        $userId = $this->input->post('userId');

        $this->db->where('user_id', $userId);
        $query = $this->db->get($this->table);

        $output = array();
        foreach($query->result() as $row){
            $output['userId'] = $row->user_id;
            $output['userFname'] = $row->user_fname;
            $output['userLname'] = $row->user_lname;
            $output['username'] = $row->username;
            $output['userType'] = $row->user_type;
            $output['userStatus'] = $row->user_status;
            $output['imageProfile'] = $row->user_image;
            $output['hiddenPassword'] = $row->password;
            if($row->user_image != ''){
                $output['userImage'] = $row->user_image;
            } else {
                $output['userImage'] = '';
            }
        }

        echo json_encode($output);
	}

    public function deleteImageProfile($userId){
        $path = 'uploads/images/users/';
        $this->db->select('user_image');
		$this->db->from($this->table);
        $this->db->where('user_id', $userId);
        $queryImage = $this->db->get();
        foreach ($queryImage->result() as $row) {
            $image = $row->user_image;
            if(!empty($image)){
                if(file_exists($path.$image)){
                    @unlink($path.$image);
                    $userImage = '';
                    if(empty($errUnlinkImage)){
                        $this->db->set('user_image', $userImage);
                        $this->db->where('user_id', $userId);
                        $this->db->update($this->table);
                        echo json_encode(array("status" => TRUE));
                    }
                } else {
                    $errUnlinkImage = 'File not found P';
                    echo $errUnlinkImage;
                }  
            }
        }
    }

    public function update(){
        $this->validateUpdate();
        date_default_timezone_set('Asia/Bangkok');
        $userId = $this->input->post('userId');

        if(!empty($this->input->post('password'))){
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        } else {
            $password = $this->input->post('hiddenPassword');
        }

        if(!empty($_FILES['userImage']['name'])){
            @unlink('./uploads/images/users/'.$this->input->post('hiddenUserImage'));
            $userImage = $this->upload();
        } else {
            $userImage = $this->input->post('hiddenUserImage');
        }
    
        $data = array(
            'user_fname'  => $this->input->post('userFname'),
            'user_lname'  => $this->input->post('userLname'),
            'user_type'   => $this->input->post('userType'),
            'user_image'  => $userImage,
            'user_status' => $this->input->post('userStatus'),
            'username'    => $this->input->post('username'),
            'password'    => $password,
            'updated_at'  => date('Y-m-d H:i:s')
        );
        $this->user_model->update(array('user_id' => $this->input->post('userId')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function upload(){
        if(!empty($_FILES['userImage']['name'])){
            $name = explode(".",$_FILES['userImage']['name']);
            $fileName = "img-".time().rand(00,99).".".end($name);
            $config['file_name'] = $fileName;
            $config['upload_path'] = "./uploads/images/users/";
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->load->library('upload', $config);
            if($this->upload->do_upload('userImage')){
                //Image Resizing
                $config1['source_image'] = $this->upload->upload_path.$this->upload->file_name;
                $config1['new_image'] =  "./uploads/images/users/";
                $config1['create_thumb'] = FALSE;
                $config1['maintain_ratio'] = TRUE;
                $config1['width'] = 255;
                $config1['height'] = 332;
                $this->load->library('image_lib', $config1);
                $this->image_lib->initialize($config1);
                $this->image_lib->resize();
            }
            return $fileName;
        } else {
            return $fileName = '';
        }
    }

    public function checkUsername($username){

        $result = $this->user_model->checkUsername($username);
		if($result == true){
            echo json_encode(array("status" => FALSE));
	    }
	    else{
            echo json_encode(array("status" => TRUE));
	    }

    }

	private function validate(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

		if($this->input->post('userFname') == ''){
            $data['inputerror'][] = 'userFname';
            $data['error_string'][] = 'กรุณาระบุ "ชื่อ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userLname') == ''){
            $data['inputerror'][] = 'userLname';
            $data['error_string'][] = 'กรุณาระบุ "นามสกุล" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('username') == ''){
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'กรุณาระบุ "ชื่อเข้าสู่ระบบ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') == ''){
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'กรุณาระบุ "password" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userType') == ''){
            $data['inputerror'][] = 'userType';
            $data['error_string'][] = 'กรุณาเลือก "ประเภทผู้ใช้งาน" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userStatus') == ''){
            $data['inputerror'][] = 'userStatus';
            $data['error_string'][] = 'กรุณาเลือก "สถานะการเข้าใช้งาน" ด้วยค่ะ!';
            $data['status'] = FALSE;
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

		if($this->input->post('userFname') == ''){
            $data['inputerror'][] = 'userFname';
            $data['error_string'][] = 'กรุณาระบุ "ชื่อ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userLname') == ''){
            $data['inputerror'][] = 'userLname';
            $data['error_string'][] = 'กรุณาระบุ "นามสกุล" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('username') == ''){
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'กรุณาระบุ "ชื่อเข้าสู่ระบบ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userType') == ''){
            $data['inputerror'][] = 'userType';
            $data['error_string'][] = 'กรุณาเลือก "ประเภทผู้ใช้งาน" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userStatus') == ''){
            $data['inputerror'][] = 'userStatus';
            $data['error_string'][] = 'กรุณาเลือก "สถานะการเข้าใช้งาน" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
	}

    private function validateUpdateProfile(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

		if($this->input->post('userFname') == ''){
            $data['inputerror'][] = 'userFname';
            $data['error_string'][] = 'กรุณาระบุ "ชื่อ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('userLname') == ''){
            $data['inputerror'][] = 'userLname';
            $data['error_string'][] = 'กรุณาระบุ "นามสกุล" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($this->input->post('username') == ''){
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'กรุณาระบุ "ชื่อเข้าสู่ระบบ" ด้วยค่ะ!';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE){
            echo json_encode($data);
            exit();
        }
	}

    public function updateProfile(){
        $this->load->view('template/header');
		$this->load->view('template/sidebar');
        $this->load->view('user/update_profile');
		$this->load->view('template/footer');
    }

    public function updateProfileSuccess(){
        $this->validateUpdateProfile();
        date_default_timezone_set('Asia/Bangkok');
        $userId = $this->input->post('userId');

        if(!empty($this->input->post('password'))){
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        } else {
            $password = $this->input->post('hiddenPassword');
        }

        if(!empty($_FILES['userImage']['name'])){
            @unlink('./uploads/images/users/'.$this->input->post('hiddenUserImage'));
            $userImage = $this->upload();
        } else {
            $userImage = $this->input->post('hiddenUserImage');
        }
    
        $data = array(
            'user_fname'  => $this->input->post('userFname'),
            'user_lname'  => $this->input->post('userLname'),
            'user_image'  => $userImage,
            'username'    => $this->input->post('username'),
            'password'    => $password,
            'updated_at'  => date('Y-m-d H:i:s')
        );
        $this->user_model->update(array('user_id' => $this->input->post('userId')), $data);
        echo json_encode(array("status" => TRUE));
    }

}