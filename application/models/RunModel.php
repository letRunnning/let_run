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
        $this->db->where('running_ID', $runNo);
        $result = $this->db->get('running_activity',1)->result_array();
        return $result;
    }
}