<?php
class PrintsModel extends CI_Model
{
    public function get_beacons_by_id($runNo)
    {
        $this->db->select('beacon_placement.*');
        $this->db->where('running_ID', $runNo);
        $result = $this->db->get('beacon_placement');
        return $result->result_array();
    }
    // public function get_supply_by_id($runNo)
    public function get_supplys_by_id($runNo)
    {
        $this->db->select('supply_location.*');
        $this->db->where('running_ID', $runNo);
        $result = $this->db->get('supply_location');
        return $result->result_array();
    }
}