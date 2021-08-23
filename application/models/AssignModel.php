<?php
class AssignModel extends CI_Model
{
    function create_assignment($workID, $time,$workgroupID) 
    {
        $this-> work_ID = $workID;
        $this-> time = $time;
        $this-> workgroup_ID = $workgroupID;

        return $this->db->insert('assignment', $this);
    }
}