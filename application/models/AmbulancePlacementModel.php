<?php
class AmbulancePlacementModel extends CI_Model
{
    public function get_all_ambulance_placement()
    {
        $this->db->order_by('supply_ID', 'running_ID', 'asc');
        $result = $this->db->get('ambulance_placement')->result_array();
        
        return $result;
    }

    public function get_ambulance_placement_by_id($runningID, $liciensePlate)
    {
        $this->db->where('running_ID', $runningID);
        $this->db->where('liciense_plate', $liciensePlate);
        $result = $this->db->get('ambulance_placement', 1);
        return $result->row();
    }

    public function create_one($running, $supply, $licienseNum, $time) {
        $this->running_ID = $running;
        $this->supply_ID = $supply;
        $this->liciense_plate = $licienseNum;
        $this->time = $time;

        return ($this->db->insert('ambulance_placement', $this)) ? $this->db->insert_id() : '';
    }
    
    public function update_by_id($running, $supply, $licienseNum, $time) {
        // $this->running_ID = $running;
        $this->supply_ID = $supply;
        $this->liciense_plate = $licienseNum;
        $this->time = $time;
        
        $this->db->where('liciense_plate', $licienseNum);
        $this->db->where('running_ID', $running);
        return $this->db->update('ambulance_placement', $this);
    }

    public function get_by_id($runningID, $id) {
        $this->db->where('liciense_plate', $id);
        $this->db->where('running_ID', $runningID);
        $result = $this->db->get('ambulance_placement', 1)->row();
        return $result;
    }
}
?>