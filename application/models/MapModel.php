<?php
class MapModel extends CI_Model
{
    public function get_route($running_ID,$group_name)
    {
        $this->db->where('running_ID', $running_ID);
        $this->db->where('group_name', $group_name);
        $result = $this->db->get('route_detail')->result_array();
        return $result;
    }
    public function delete_point($no)
    {
        $this->db->where('no', $no);
        $this->db->delete('route_detail');
        $result = $this->db->get('route_detail');
        return $result;
    }
}