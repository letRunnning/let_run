<?php
class MemberModel extends CI_Model {
    /*
    * create one member
    * @Return: Boolean
    */
    function create_one($systemNo, $youth, $counselor, $project, $organization, $county) {
        $this->system_no = $systemNo;
        $this->youth = $youth;
        $this->counselor = $counselor;
        $this->project = $project;
        $this->organization = $organization;
        $this->county = $county;
        $this->create_date = date('Y-m-d');
        $this->year = date("Y")-1911;
        return ($this->db->insert('member', $this)) ? $this->db->insert_id() : false;;
    }
}
?>