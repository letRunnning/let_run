<?php
class CheckModel extends CI_Model
{
    public function get_all_member_pay()
    {
        $this->db->select('transaction.member_ID as mID, transaction.time, member.name, member.email, registration.running_ID, registration.group_name');
        $this->db->join('registration', 'transaction.registration_ID = registration.registration_ID');
        $this->db->join('member', 'transaction.member_ID = member.member_ID');
        $this->db->order_by('transaction.registration_ID', 'asc');
        $result = $this->db->get('transaction') -> result_array();
        return $result;
    }
}