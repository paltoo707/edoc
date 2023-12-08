<?php
class User_model extends CI_Model {
    
    var $table = 'tb_user';
    var $columnOrder = array('user_fname', 'user_lname', 'user_type', 'user_status', 'username', null);
    var $columnSearch = array('user_fname', 'user_lname', 'user_type', 'user_status', 'username');
    var $order = array('user_id' => 'desc');

    public function __construct(){
        parent::__construct();
    }

    private function getDatatablesQuery(){
		$this->db->from($this->table);
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
        $query = $this->db->insert($this->table, $data);
        return $query;
    }

    public function delete($userId){
		$this->db->where('user_id', $userId);
        $query = $this->db->delete($this->table);
        return $query;
	}

	public function update($userID, $data){
		$this->db->update($this->table, $data, $userID);
        $query = $this->db->affected_rows();
		return $query;
    }

    public function checkUsername($username){

        $this->db->where('username', $username);
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }

}