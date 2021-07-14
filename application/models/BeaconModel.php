<?php
class BeaconModel extends CI_Model
{
    public function get_all_beacon()
    {
        $result = $this->db->get('beacon')->result_array();
        return $result;
    }

    public function get_beacon_by_id($beaconID)
    {
        $this->db->where('beacon_ID', $beaconID);
        $result = $this->db->get('beacon',1);
        return $result->row();
    }

    function create_one($id, $type, $available) {

        $this->beacon_ID = $id;
        $this->type = $type;
        $this->is_available = $available;
      
        return ($this->db->insert('beacon', $this)) ? $this->db->insert_id() : '';
    }
    
    function update_by_id($id, $type, $isAvailable) {

        $this->type = $type;
        $this->is_available = $isAvailable;
        
        $this->db->where('beacon_ID', $id);
        return $this->db->update('beacon', $this);
    }

    function get_by_id($id) {
        $this->db->where('beacon_ID', $id);
        $result = $this->db->get('beacon', 1)->row();
        return $result;
    }
}