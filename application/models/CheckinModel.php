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

    public function get_staff_checkin_by_runningID($rid) {
        $this->db->select('*, staff.name AS sName, work_group.name AS wName');
        $this->db->where('staff_participation.running_ID', $rid);
        $this->db->join('running_activity', 'running_activity.running_ID = staff_participation.running_ID');
        $this->db->join('work_group', 'staff_participation.workgroup_ID = work_group.workgroup_ID');
        $this->db->join('staff', 'staff_participation.staff_ID = staff.staff_ID');
        $result = $this->db->get('staff_participation');
        return $result->result_array();
    }

    public function get_member_checkin_by_runningID($rid) {
        $this->db->select('*, running_activity.name AS rName, member.name AS mName');
        $this->db->where('registration.running_ID', $rid);
        $this->db->join('running_activity', 'running_activity.running_ID = registration.running_ID');
        $this->db->join('checkin', 'registration.registration_ID = checkin.registration_ID', 'left');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $this->db->order_by('member.member_ID', 'asc');
        $result = $this->db->get('registration');
        return $result->result_array();
    }
}