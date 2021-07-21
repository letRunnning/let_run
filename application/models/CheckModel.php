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
}