<?php
class CheckinModel extends CI_Model
{
    public function get_all_registration()
    {
        $this->db->select('*, member.name, member.phone, running_group.start_time');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $this->db->join('running_group', 'registration.group_name = running_group.group_name');
        $this->db->join('checkin', 'checkin.registration_ID = registration.registration_ID', 'left');
        $this->db->order_by('registration.registration_ID', 'asc');
        $result = $this->db->get('registration') -> result_array();
        return $result;
    }

    public function get_all_staff_checkin()
    {
        $this->db->select('*, staff.name as sName, staff.phone, work_group.name');
        $this->db->join('staff', 'staff_participation.staff_ID = staff.staff_ID');
        $this->db->join('work_group', 'staff_participation.workgroup_ID = work_group.workgroup_ID');
        $this->db->order_by('staff_participation.workgroup_ID', 'asc');
        $result = $this->db->get('staff_participation') -> result_array();
        return $result;
    }
}