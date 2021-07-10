<?php
class RunModel extends CI_Model
{
    public function get_all_active()
    {
        $result = $this->db->get('running_activity')->result_array();
        return $result;
    }
    public function get_active_by_id($runNo)
    {
        $this->db->select('running_activity.*,f.name as photo_name,f.no as no');
        $this->db->where('running_ID', $runNo);
        $this->db->join('files as f', 'running_activity.file_no = f.no', 'left');
        $result = $this->db->get('running_activity',1);
        return $result->row();
    }
    public function get_all_workgrpup()
    {
        $this->db->select('*,running_activity.name as runName,work_group.name as workName');
        $this->db->join('running_activity', 'running_activity.running_ID = work_group.running_ID');
        $this->db->order_by("running_activity.name", "desc");
        $result = $this->db->get('work_group') -> result_array();
        return $result;
    }
    public function get_workgrpup_by_id($workID)
    {
        $this->db->select('*,running_activity.name as runName');
        $this->db->where('workgroup_ID', $workID);
        $this->db->join('running_activity', 'running_activity.running_ID = work_group.running_ID');
        $result = $this->db->get('work_group') -> result_array();
        return $result;
    }
    function create_one($id,$name, $date,$place,$start_time,$end_time,$bankCode,$bankAccount,$file_no) {

        $this->running_ID  = $id;
        $this->name = $name;
        $this->date = $date;
        $this->place = $place;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->bank_account = $bankAccount;
        $this->bank_code = $bankCode;
        $this->file_no = $file_no;
      
        return ($this->db->insert('running_activity', $this)) ? $this->db->insert_id() : '';
    }
    function update_by_id($id,$name, $date,$place,$start_time,$end_time,$bankCode,$bankAccount,$file_no) {

        $this->name = $name;
        $this->date = $date;
        $this->place = $place;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->bank_account = $bankAccount;
        $this->bank_code = $bankCode;
        $this->file_no = $file_no;
        
        $this->db->where('running_ID', $id);
        return $this->db->update('running_activity', $this);
    }
}