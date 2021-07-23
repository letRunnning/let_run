<?php
class CheckModel extends CI_Model
{
    public function get_all_member_pay()
    {
        $this->db->select('registration.member_ID as mID, transaction.time, member.name, member.email, registration.running_ID, registration.group_name');
        $this->db->join('transaction', 'transaction.registration_ID = registration.registration_ID', 'left');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $this->db->order_by('registration.registration_ID', 'asc');
        $result = $this->db->get('registration') -> result_array();
        return $result;
    }

    public function get_all_staff_application()
    {
        $this->db->select('staff_participation.running_ID as rID, work_group.name as workgroupName, staff.staff_ID, staff.name');
        $this->db->join('work_group', 'work_group.workgroup_ID = staff_participation.workgroup_ID');
        $this->db->join('staff', 'staff_participation.staff_ID = staff.staff_ID');
        $this->db->order_by('staff_participation.workgroup_ID', 'asc');
        $result = $this->db->get('staff_participation') -> result_array();
        return $result;
    }
}