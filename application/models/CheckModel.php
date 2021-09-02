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

    public function get_all_gift_status()
    {
        $this->db->select('registration.member_ID as mID, registration.running_ID, registration.group_name, member.name, member.phone, redeem.redeem_time');
        $this->db->join('redeem', 'redeem.registration_ID = registration.registration_ID', 'left');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $this->db->order_by('registration.registration_ID', 'asc');
        $result = $this->db->get('registration') -> result_array();
        return $result;
    }

    public function get_staff_apply_by_runningID($rid) {
        $this->db->select('*, running_activity.name AS rName, staff.name AS sName, work_group.name as workgroupName');
        $this->db->where('staff_participation.running_ID', $rid);
        $this->db->join('running_activity', 'running_activity.running_ID = staff_participation.running_ID');
        $this->db->join('work_group', 'staff_participation.workgroup_ID = work_group.workgroup_ID');
        $this->db->join('staff', 'staff_participation.staff_ID = staff.staff_ID');
        $result = $this->db->get('staff_participation');
        return $result->result_array();
    }

    public function get_pay_status_by_runningID($rid) {
        $this->db->select('*, running_activity.name AS rName');
        $this->db->where('registration.running_ID', $rid);
        $this->db->join('running_activity', 'running_activity.running_ID = registration.running_ID');
        $this->db->join('transaction', 'transaction.registration_ID = registration.registration_ID', 'left');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $result = $this->db->get('registration');
        return $result->result_array();
    }

    public function get_gift_status_by_runningID($rid) {
        $this->db->select('*, running_activity.name AS rName');
        $this->db->where('registration.running_ID', $rid);
        $this->db->join('running_activity', 'running_activity.running_ID = registration.running_ID');
        $this->db->join('redeem', 'redeem.registration_ID = registration.registration_ID', 'left');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $result = $this->db->get('registration');
        return $result->result_array();
    }

    public function get_member_payment() {
        $this->db->select('*, running_activity.name AS rName, member.name, member.email');
        $this->db->join('running_activity', 'running_activity.running_ID = registration.running_ID');
        $this->db->join('transaction', 'transaction.registration_ID = registration.registration_ID', 'left');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $result = $this->db->get('registration');
        return $result->result_array();
    }
}