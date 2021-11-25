<?php
class SupplyLocationModel extends CI_Model
{
    public function get_all_supply_location()
    {
        $result = $this->db->get('supply_location')->result_array();
        return $result;
    }
}
?>