<?php
class Approve_model extends CI_Model {

    var $table = 'tb_approve';
    public function __construct(){
        parent::__construct();
    }

    public function getNotApprove($appUserApprove){
        $this->db->select('app_id, app_user_approve, book_from, book_title, book_receive_date');
        $this->db->from('tb_approve');
        $this->db->join('tb_book', 'tb_book.book_id = tb_approve.app_book_id', 'left');
        $this->db->where('tb_approve.app_status', 'Not-Approve');
        $this->db->where('tb_approve.app_user_approve', $appUserApprove);
        $this->db->order_by('app_id', 'desc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDetail($appId){
        $this->db->select('*');
        $this->db->from('tb_approve');
        $this->db->join('tb_book', 'tb_book.book_id = tb_approve.app_book_id', 'left');
        $this->db->where('app_id', $appId);
		$query = $this->db->get()->result();
        return $query;
    }

    public function getFile($appId){
        $this->db->select('*');
        $this->db->from('tb_approve');
        $this->db->join('tb_book', 'tb_book.book_id = tb_approve.app_book_id', 'left');
        $this->db->where('app_id', $appId);
		$query = $this->db->get()->result_array();
        return $query;
    }

    public function insert($dataApprove){
        $this->db->insert($this->table, $dataApprove);
        $query = $this->db->insert_id();
        return $query;
    }

    public function update($appId, $data){
		$this->db->update($this->table, $data, $appId);
        $query = $this->db->affected_rows();
		return $query;
    }

}