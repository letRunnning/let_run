<?php
class BeaconPlacementModel extends CI_Model
{
    public function get_all_beacon_placement()
    {
        $result = $this->db->get('beacon_placement')->result_array();
        return $result;
    }

    public function get_beacon_placement_by_id($beaconID)
    {
        $this->db->where('beacon_ID', $beaconID);
        $result = $this->db->get('beacon_placement', 1);
        return $result->row();
    }

    public function create_one($id, $active, $supplyID) {
        $this->beacon_ID = $id;
        $this->running_ID = $active;
        $this->supply_ID = $supplyID;

        return ($this->db->insert('beacon_placement', $this)) ? $this->db->insert_id() : '';
    }
    
    public function update_by_id($id, $active, $supplyID) {
        // $this->beacon_ID = $id;
        $this->running_ID = $active;
        $this->supply_ID = $supplyID;
        
        $this->db->where('beacon_ID', $id);
        return $this->db->update('beacon_placement', $this);
    }

    public function get_by_id($id) {
        $this->db->where('beacon_ID', $id);
        $result = $this->db->get('beacon_placement', 1)->row();
        return $result;
    }

    public function get_beacon_placement_by_runningID($rid) {
        $this->db->select('*, running_activity.name');
        $this->db->where('beacon_placement.running_ID', $rid);
        $this->db->join('running_activity', 'running_activity.running_ID = beacon_placement.running_ID');
        $result = $this->db->get('beacon_placement');
        return $result->result_array();
    }
}
?>