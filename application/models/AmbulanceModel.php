<?php
class AmbulanceModel extends CI_Model
{
    public function get_all_ambulance()
    {
        $this->db->order_by('hospital_name');
        $result = $this->db->get('ambulance_details')->result_array();
        
        return $result;
    }

    public function get_ambulance_by_id($liciense)
    {
        $this->db->where('liciense_plate', $liciense);
        $result = $this->db->get('ambulance_details', 1);
        return $result->row();
    }

    function create_one($hospital, $hospitalPhone, $licensePlate) {
        $this->hospital_name = $hospital;
        $this->hospital_phone = $hospitalPhone;
        $this->liciense_plate = $licensePlate;
      
        return ($this->db->insert('ambulance_details', $this)) ? $this->db->insert_id() : '';
    }
    
    function update_by_id($hospital, $hospitalPhone, $licensePlate) {
        $this->hospital_name = $hospital;
        $this->hospital_phone = $hospitalPhone;
        // $this->liciense_plate = $licensePlate;
        
        $this->db->where('liciense_plate', $licensePlate);
        return $this->db->update('ambulance_details', $this);
    }

    function get_by_id($id) {
        $this->db->where('liciense_plate', $id);
        $result = $this->db->get('ambulance_details', 1)->row();
        return $result;
    }
}