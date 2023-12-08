<?php
class Book_model extends CI_Model {

    var $table = 'tb_book';
    var $tableUser = 'tb_user';
    var $columnOrder = array('book_receive_no', 'book_sent_no', 'book_from', 'book_title', 'book_receive_date', 'book_sent_date', null);
    var $columnSearch = array('book_receive_no', 'book_sent_no', 'book_from', 'book_title', 'book_receive_date', 'book_sent_date', 'user_fname');
    var $order = array('book_id' => 'desc');

    public function __construct(){
        parent::__construct();
    }

    private function getDatatablesQuery(){
        $this->db->select('*');
		$this->db->from('tb_book');
        $this->db->join('tb_user', 'tb_user.user_id = tb_book.book_user_update', 'left');
		$i = 0;
		foreach ($this->columnSearch as $item){
			if($_POST['search']['value']){
				if($i===0){
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($this->columnSearch) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if(isset($_POST['order'])){
			$this->db->order_by($this->columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

    public function getDatatables(){
		$this->getDatatablesQuery();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

    public function countFiltered(){
		$this->getDatatablesQuery();
		$query = $this->db->get();
		return $query->num_rows();
	}

    public function countAll(){
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

    public function insert($data){
        $this->db->insert($this->table, $data);
		$query = $this->db->insert_id();
        return $query;
    }

    public function delete($bookId){
		$this->db->where('book_id', $bookId);
        $query = $this->db->delete($this->table);
        return $query;
	}

	public function update($bookId, $data){
		$this->db->update($this->table, $data, $bookId);
        $query = $this->db->affected_rows();
		return $query;
    }

	function getRows($params = array()){ 
        $this->db->select('book_id, book_title, book_sent_no, book_receive_no, book_from, book_receive_date'); 
        $this->db->from($this->table); 
         
        if(array_key_exists("where", $params)){ 
            foreach($params['where'] as $key => $val){ 
                $this->db->where($key, $val); 
            } 
        } 
         
        if(array_key_exists("search", $params)){ 
            // Filter data by searched keywords 
            if(!empty($params['search']['keywords'])){ 
                $this->db->or_like('book_title', $params['search']['keywords']);
				$this->db->or_like('book_receive_no', $params['search']['keywords']);
				$this->db->or_like('book_sent_no', $params['search']['keywords']);
				$this->db->or_like('book_from', $params['search']['keywords']); 
            } 
        } 
         
        // Sort data by ascending or desceding order 
        // if(!empty($params['search']['sortBy'])){ 
        //     $this->db->order_by('act_name', $params['search']['sortBy']); 
        // }else{ 
        //     $this->db->order_by('act_id', 'desc'); 
        // } 
         
        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){ 
            $result = $this->db->count_all_results(); 
        }else{ 
            if(array_key_exists("book_id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
                if(!empty($params['book_id'])){ 
                    $this->db->where('book_id', $params['book_id']); 
                } 
                $query = $this->db->get(); 
                $result = $query->row_array(); 
            }else{ 
                $this->db->order_by('book_id', 'desc'); 
                if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit'],$params['start']); 
                }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
                    $this->db->limit($params['limit']); 
                } 
                 
                $query = $this->db->get(); 
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
            } 
        } 
         
        // Return fetched data 
        return $result; 
    }
	
	public function getDetail($bookId){
        $this->db->select('*');
        $this->db->from('tb_book');
        $this->db->join('tb_approve', 'tb_approve.app_book_id = tb_book.book_id', 'left');
        $this->db->where('book_id', $bookId);
		$query = $this->db->get()->result();
        return $query;
    }

	public function getFile($bookId){
        $this->db->select('book_files');
		$this->db->from('tb_book');
        $this->db->where('book_id', $bookId);
		$query = $this->db->get()->result_array();
        return $query;
    }

    public function getDateSearch($fromDate, $toDate){
        $this->db->select('book_id, book_title, book_sent_no, book_receive_no, book_from, book_receive_date'); 
        $this->db->from($this->table);
        $this->db->where('book_receive_date >=', $fromDate);
        $this->db->where('book_receive_date <=', $toDate);
        $this->db->order_by('book_id', 'DESC');
        $query = $this->db->get()->result_array();
        return $query;
    }

}