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

    public function create_one($id, $active, $longitude, $latitude, $type, $available) {
        $this->beacon_ID = $id;
        $this->running_ID = $active;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->type = $type;
        $this->is_available = $available;

        return ($this->db->insert('beacon_placement', $this)) ? $this->db->insert_id() : '';
    }
    
    public function update_by_id($id, $active, $longitude, $latitude, $type, $available) {
        // $this->beacon_ID = $id;
        $this->running_ID = $active;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->type = $type;
        $this->is_available = $available;
        
        $this->db->where('beacon_ID', $id);
        return $this->db->update('beacon_placement', $this);
    }

    public function get_by_id($id) {
        $this->db->where('beacon_ID', $id);
        $result = $this->db->get('beacon_placement', 1)->row();
        return $result;
    }
}
?>