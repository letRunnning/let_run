<?php
class SupplyLocationModel extends CI_Model
{
    public function get_all_supply_location()
    {
        $result = $this->db->get('passing_point')->result_array();
        return $result;
    }
}
?>