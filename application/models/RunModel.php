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
    public function get_workcontents_by_id($runNo)
    {
        $this->db->select('work_content.*,`running_activity`.`name`');
        $this->db->where('work_content.running_ID', $runNo);
        $this->db->join('running_activity', '`work_content`.`running_ID` = `running_activity`.`running_ID`');
        $result = $this->db->get('work_content');
        return $result->result_array();
    }
    public function get_all_workgrpup()
    {
        $this->db->select('*,running_activity.name as runName,work_group.name as workName');
        $this->db->join('running_activity', 'running_activity.running_ID = work_group.running_ID');
        $this->db->order_by("running_activity.name", "desc");
        $result = $this->db->get('work_group') -> result_array();
        return $result;
    }
    public function get_workgrpup_byid($workID) //workgroup Info
    {
        $this->db->select('*,running_activity.name as runName,work_group.name as workName');
        $this->db->where('workgroup_ID', $workID);
        $this->db->join('running_activity', 'running_activity.running_ID = work_group.running_ID');
        $result = $this->db->get('work_group');
        return $result->row();
    }
    public function get_workgroup_content_byid($workID) //workgroup work content
    {
        $this->db->select('*');
        $this->db->join('work_group', 'work_group.workgroup_ID = assignment.workgroup_ID');
        $this->db->join('work_content', 'work_content.work_ID = assignment.work_ID');
        $this->db->where('assignment.workgroup_ID', $workID);
        $result = $this->db->get('assignment');
        // $result = $this->db->get('assignment') -> result_array();
        return $result->row();
    }
    public function get_active_work_by_id($runNo,$workID)
    {
        $this->db->select('*');
        $this->db->where('running_ID', $runNo);
        $this->db->where('work_ID', $workID);
        $result = $this->db->get('work_content');
        return $result->row();
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
    function create_workgroup($running_ID, $name,$time,$place,$people) {

        $this->	workgroup_ID  = 4;
        $this->	running_ID = $running_ID;
        $this->	name = $name;
        $this-> assembletime = $time;
        $this->	assembleplace = $place;
        $this->	maximum_number = $people;
      
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
    public function create_work($runActive, $place, $content)
    {
        $this->running_ID = $runActive;
        $this->place = $place;
        $this->content = $content;
        return ($this->db->insert('work_content', $this)) ? $this->db->insert_id() : false;
    }
    public function update_work($work_ID,$runActive, $place, $content)
    {
        $this->running_ID = $runActive;
        $this->place = $place;
        $this->content = $content;

        $this->db->where('work_ID', $work_ID);
        return $this->db->update('work_content', $this);
    }
}