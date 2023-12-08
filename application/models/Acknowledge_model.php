<?php
class Acknowledge_model extends CI_Model {

    var $table = 'tb_acknowledge';
    public function __construct(){
        parent::__construct();
    }

    public function getNotAcknowledge($appUserAcknowledge){
        $this->db->select('ack_id, ack_user_approve, book_from, book_title, book_receive_date');
        $this->db->from('tb_acknowledge');
        $this->db->join('tb_book', 'tb_book.book_id = tb_acknowledge.ack_book_id', 'left');
        $this->db->join('tb_approve', 'tb_approve.app_id = tb_acknowledge.ack_app_id', 'left');
        $this->db->where('tb_acknowledge.ack_status', 'Not-Acknowledge');
        $this->db->where('tb_acknowledge.ack_user_approve', $appUserAcknowledge);
        $this->db->order_by('ack_id', 'desc');
        $query = $this->db->get()->result();
        return $query;
    }

    public function getDetail($ackId){
        $this->db->select('*');
        $this->db->from('tb_acknowledge');
        $this->db->join('tb_book', 'tb_book.book_id = tb_acknowledge.ack_book_id', 'left');
        $this->db->join('tb_approve', 'tb_approve.app_id = tb_acknowledge.ack_app_id', 'left');
        $this->db->where('ack_id', $ackId);
		$query = $this->db->get()->result();
        return $query;
    }

    public function getFile($ackId){
        $this->db->select('*');
        $this->db->from('tb_acknowledge');
        $this->db->join('tb_book', 'tb_book.book_id = tb_acknowledge.ack_book_id', 'left');
        $this->db->where('ack_id', $ackId);
		$query = $this->db->get()->result_array();
        return $query;
    }

    public function insert($dataApprove){
        $this->db->insert($this->table, $dataApprove);
        $query = $this->db->insert_id();
        return $query;
    }

    public function update($ackId, $data){
		$this->db->update($this->table, $data, $ackId);
        $query = $this->db->affected_rows();
		return $query;
    }
}