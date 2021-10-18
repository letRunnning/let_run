<?php
class PassingPointModel extends CI_Model
{
    public function get_all_passing_point()
    {
        $result = $this->db->get('passing_point')->result_array();
        return $result;
    }

    // public function get_ambulance_placement_by_id($liciensePlate)
    // {
    //     $this->db->where('license_plate', $liciensePlate);
    //     $result = $this->db->get('ambulance_placement', 1);
    //     return $result->row();
    // }
}
?>