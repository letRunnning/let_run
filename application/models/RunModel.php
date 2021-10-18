<?php
class RunModel extends CI_Model
{
    public function get_all_active()
    {
        $result = $this->db->get('running_activity')->result_array();
        return $result;
    }
    public function get_all_activeGroup()
    {
        $this->db->join('running_activity', 'running_activity.running_ID = running_group.running_ID', 'left');
        $result = $this->db->get('running_group')->result_array();
        return $result;
    }
    public function getActiveNumber()
    {
        $this->db->select('running_ID');
        $this->db->order_by('running_ID', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('running_activity',1);
        return $result->row();
    }
    // public function getPassNumber()
    // {
    //     $this->db->select('pass_ID');
    //     $this->db->order_by('pass_ID', 'DESC');
    //     $this->db->limit(1);
    //     $result = $this->db->get('passing_point',1);
    //     return $result->row();
    // }
    public function getPassNumber()
    {
        $this->db->select('supply_ID');
        $this->db->order_by('supply_ID', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('supply_location',1);
        return $result->row();
    }    
    public function get_activeGroup_by_no($no)
    {
        $this->db->where('running_ID', $no);
        $result = $this->db->get('running_group')->result_array();
        return $result;
    }
    public function get_routes_by_no($no)//for route_detail form select
    {
        $this->db->where('route_detail.running_ID', $no);
        $this->db->join('running_activity', 'running_activity.running_ID = route_detail.running_ID', 'left');
        $result = $this->db->get('route_detail')->result_array();
        return $result;
    }
    public function get_passPoint_by_no($no) //for passing_point
    {
        $this->db->where('pass_ID', $no);
        $result = $this->db->get('passing_point',1);
        return $result->row();
    }
    public function get_supply_location_by_no($no) //for supply_location
    {
        $this->db->select('supply_location.*,running_activity.name');
        $this->db->join('running_activity', 'running_activity.running_ID = supply_location.running_ID');
        $this->db->where('supply_ID', $no);
        $result = $this->db->get('supply_location',1);
        return $result->row();
    }
    public function get_supply_location_by_run($no)
    {
        $this->db->select('supply_location.*,running_activity.name');
        $this->db->join('running_activity', 'running_activity.running_ID = supply_location.running_ID');
        $this->db->where('supply_location.running_ID', $no);
        $result = $this->db->get('supply_location')->result_array();
        return $result;
    }
    public function get_passing_point()//for passing_point table
    {
        $result = $this->db->get('passing_point')->result_array();
        return $result;
    }
    public function get_supply_location()//for supply_location table
    {
        $result = $this->db->get('supply_location')->result_array();
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
        $this->db->select('*,running_activity.running_ID as runID,running_activity.name as runName,work_group.name as workName');
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
    // public function get_workgroup_content_byid($workID) //workgroup work content
    // {
    //     $this->db->select('*');
    //     $this->db->join('work_group', 'work_group.workgroup_ID = assignment.workgroup_ID');
    //     $this->db->join('work_content', 'work_content.work_ID = assignment.work_ID');
    //     $this->db->where('assignment.workgroup_ID', $workID);
    //     $result = $this->db->get('assignment');
    //     // $result = $this->db->get('assignment') -> result_array();
    //     return $result->row();
    // }
    public function get_assignment_content($workgroupID)
    {
        $this->db->select('assignment.no,assignment.work_ID as A_ID,work_content.*');
        $this->db->join('work_content', 'work_content.work_ID = assignment.work_ID');
        $this->db->where('assignment.workgroup_ID', $workgroupID);
        $result = $this->db->get('assignment');
        return $result->result_array();
    }
    public function deleteAssignment($id)
    {
        $this->db->where("no", $id);
        $this->db->delete("assignment");
        return true;
    }
    public function get_active_work_by_id($runNo,$workID)
    {
        $this->db->select('*');
        $this->db->where('running_ID', $runNo);
        $this->db->where('work_ID', $workID);
        $result = $this->db->get('work_content');
        return $result->row();
    }
    function create_one($id,$name, $date,$place,$start_time,$end_time,$bankCode,$bankAccount,$file_no) 
    {
        $this->running_ID  = $id;
        $this->name = $name;
        $this->date = $date;
        $this->place = $place;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->payment_account = $bankAccount;
        $this->payment_bank_code = $bankCode;
        $this->file_no = $file_no;
      
        return ($this->db->insert('running_activity', $this)) ? $this->db->insert_id() : '';
    }
    function create_workgroup($running_ID, $name,$leader,$line,$time,$place,$people) 
    { 
        $this->	running_ID = $running_ID;
        $this->	name = $name;
        $this->	leader = $leader;
        $this->	line = $line;
        $this-> assembletime = $time;
        $this->	assembleplace = $place;
        $this->	maximum_number = $people;
        
        return ($this->db->insert('work_group', $this)) ? $this->db->insert_id() : '';
    }
    function update_workgroup($running_ID, $name,$leader,$line,$time,$place,$people,$workgroupID) 
    {
        $this->	running_ID = $running_ID;
        $this->	name = $name;
        $this->	leader = $leader;
        $this->	line = $line;
        $this-> assembletime = $time;
        $this->	assembleplace = $place;
        $this->	maximum_number = $people;
      
        $this->db->where('workgroup_ID', $workgroupID);
        return ($this->db->update('work_group', $this));
    }
    function create_assignment($workID, $time,$workgroupID) 
    {
        $this-> work_ID = $workID;
        $this-> time = $time;
        $this-> workgroup_ID = $workgroupID;

        $this->db->insert('assignment', $this);
    }
    function update_by_id($id,$name, $date,$place,$start_time,$end_time,$bankCode,$bankAccount,$file_no) 
    {
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
    public function create_route_detail($no,$name,$detail, $lon, $lat)
    {
        $this->running_ID = $no;
        $this->group_name = $name;
        $this->detail = $detail;
        $this->longitude = $lon;
        $this->latitude = $lat;
        return $this->db->insert('route_detail', $this);
    }
    // public function create_pass_point($no,$name, $lon, $lat)
    // {
    //     $this->pass_ID = $no;
    //     $this->pass_name = $name;
    //     $this->longitude = $lon;
    //     $this->latitude = $lat;
    //     return $this->db->insert('passing_point', $this);
    // }
    public function create_supply_location($no,$name, $lon, $lat,$runID,$supplies)
    {
        $this->supply_ID = $no;
        $this->supply_name = $name;
        $this->longitude = $lon;
        $this->latitude = $lat;
        $this->running_ID = $runID;
        $this->supplies = $supplies;
        return $this->db->insert('supply_location', $this);
    }
    // public function update_pass_point($no,$name, $lon, $lat)
    // {
    //     $this->pass_name = $name;
    //     $this->longitude = $lon;
    //     $this->latitude = $lat;

    //     $this->db->where('pass_ID', $no);
    //     return $this->db->update('passing_point', $this);
    // }
    public function update_supply_location($no,$name, $lon, $lat, $running_ID,$supplies)
    {
        $this->supply_name = $name;
        $this->longitude = $lon;
        $this->latitude = $lat;
        $this->running_ID = $running_ID;
        $this->supplies = $supplies;
        $this->db->where('supply_ID', $no);
        return $this->db->update('supply_location', $this);
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