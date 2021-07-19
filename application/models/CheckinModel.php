<?php
class CheckinModel extends CI_Model
{
    public function get_all_checkin()
    {
        $this->db->select('checkin.checkin_time as time, member.member_ID, member.name, member.phone, registration.running_ID, registration.group_name, running_group.start_time');
        $this->db->join('registration', 'checkin.registration_ID = registration.registration_ID');
        $this->db->join('member', 'registration.member_ID = member.member_ID');
        $this->db->join('running_group', 'registration.group_name = running_group.group_name');
        $this->db->order_by('checkin.registration_ID', 'asc');
        $result = $this->db->get('checkin') -> result_array();
        return $result;
    }
}