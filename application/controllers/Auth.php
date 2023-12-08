<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
		parent::__construct();
        $this->load->library('form_validation');
	}

    public function index() {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if($this->form_validation->run() == FALSE) {
            $this->load->view('auth/index');
        } else {
            $username = $this->input->post('username');
			$password = $this->input->post('password');
            $data = $this->db->get_where('tb_user',['username' => $username])->row();
            print_r($data);
            if($data) {
                $pwd = $data->password;
                $vertifyPassword = password_verify($password, $pwd);
                if($vertifyPassword) {
                    $sessData = [
                        'userId' => $data->user_id,
                        'userFname' => $data->user_fname,
                        'userLname' => $data->user_lname,
                        'userType' => $data->user_type,
                        'userStatus' => $data->user_status,
                        'userImage' => $data->user_image,
                        'logged_id' => TRUE
                    ];
                    $this->session->set_userdata('logged_in', $sessData);
                    $sess = $this->session->userdata('logged_in');
                        if($sess['userType'] == 'Boss'){
                            return redirect('approve');
                        } else {
                            return redirect('acknowledge');
                        }
                        
                } else {
                    $this->session->set_flashdata('login_error', 'ตรวจสอบ username | password อีกครั้งค่ะ!');
                    return redirect('auth');
                }
            } else {
                $this->session->set_flashdata('login_error', 'ตรวจสอบ username | password อีกครั้งค่ะ!');
                return redirect('auth');
            }
        }
    }

    public function logout() {
		$this->session->sess_destroy();
		return redirect('auth');
	}

}