<?php
class MeetingModel extends CI_Model
{
    /*
     * create group_counseling
     */
    public function create_one($title, $meetingType, $participants, $startTime, $chairman, $chairmanBackground, $note, $organization)
    {
        $this->title = $title;
        $this->meeting_type = $meetingType;
        $this->participants = $participants;
        $this->start_time = $startTime;
        $this->chairman = $chairman;
        $this->chairman_background = $chairmanBackground;
        $this->note = $note;
        $this->organization = $organization;
  
        $this->year = date("Y") - 1911;

        return ($this->db->insert('meeting', $this)) ? $this->db->insert_id() : '';
    }

    /*
     * update group_counseling by no
     */
    public function update_by_no($title, $meetingType, $participants, $startTime, $chairman, $chairmanBackground, $note, $organization, $no)
    {
        $this->title = $title;
        $this->meeting_type = $meetingType;
        $this->participants = $participants;
        $this->start_time = $startTime;
        $this->chairman = $chairman;
        $this->chairman_background = $chairmanBackground;
        $this->note = $note;


        $this->db->where('no', $no);
        return $this->db->update('meeting', $this);
    }

    /*
     * Get group_counseling by organization
     * @Return: group_counseling object
     */
    public function get_by_organization($organization, $yearType)
    {
        $this->db->select('meeting.*');
        $this->db->where('organization', $organization);
        $this->db->where('year', $yearType);
        $result = $this->db->get('meeting')->result_array();
        return $result;
    }

    public function get_by_no($no)
    {
        // $this->db->select('course_reference.*, expert_list.name as expert_name');
        // $this->db->join('expert_list', 'course_reference.expert = expert_list.no');
        $this->db->where('no', $no);
        $result = $this->db->get('meeting', 1)->row();
        return $result;
    }
}
