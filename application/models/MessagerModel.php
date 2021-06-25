<?php
class MessagerModel extends CI_Model {

  function create_one($type, $content, $announcer, $receiveGroup, $isView, $isEmail) {
    $this->type = $type;
    $this->content = $content;
    $this->announcer = $announcer;
    $this->receive_group = $receiveGroup;
		$this->create_date = date("Y-m-d");
		$this->is_view = $isView;
    $this->is_email = $isEmail;
  
    return ($this->db->insert('messager', $this)) ? $this->db->insert_id() : false;
	}
	
	function update_by_no($type, $content, $announcer, $receiveGroup, $isView, $isEmail, $no) {

		$this->type = $type;
    $this->content = $content;
    $this->announcer = $announcer;
    $this->receive_group = $receiveGroup;
		$this->is_view = $isView;
    $this->is_email = $isEmail;
    
    $this->db->where('no', $no);
    return $this->db->update('messager', $this);
	}

	function delete_by_no($no) {

		$this->is_view = 0;
    
    $this->db->where('no', $no);
    return $this->db->update('messager', $this);
	}

	function get_show() {
		$this->db->where('is_view', 1);
    $this->db->order_by("create_date", "desc");

    $result = $this->db->get('messager')->result_array();
    return $result;
	}

	function get_all() {
    $this->db->order_by("create_date", "desc");
    $result = $this->db->get('messager')->result_array();
   
    return $result;
	}
	
	function get_by_no($no) {
    // $this->db->select('course_reference.*, expert_list.name as expert_name');
    // $this->db->join('expert_list', 'course_reference.expert = expert_list.no');
    $this->db->where('no', $no);
    $result = $this->db->get('messager', 1)->row();
    return $result;
  }
	
	

}

?>