<?php
class IntakeModel extends CI_Model
{
    /*
     * create one intake
     * @Return: Boolean
     */

    public function create_one($referralInstitution, $referralName, $referralPhone, $youthNo, $project, $referralTarget, $referralAttitude,
        $referralAttitudeOther, $majorDemand, $majorDemandOther, $isWant, $openCase) {

        $this->project = $project;
        $this->referral_institution = $referralInstitution;
        $this->referral_name = $referralName;
        $this->referral_phone = $referralPhone;
        $this->youth = $youthNo;
        $this->referral_target = $referralTarget;
        $this->referral_attitude = $referralAttitude;
        $this->referral_attitude_other = $referralAttitudeOther;
        $this->major_demand = $majorDemand;
        $this->major_demand_other = $majorDemandOther;
        $this->is_want = $isWant;
        $this->open_case = $openCase;
        return $this->db->insert('intake', $this);
    }

    /*
     * update intake by youth
     * @Return: Boolean
     */

    public function update_by_youth($referralInstitution, $referralName, $referralPhone, $youthNo, $project, $referralTarget, $referralAttitude,
        $referralAttitudeOther, $majorDemand, $majorDemandOther, $isWant, $openCase) {

        $this->project = $project;
        $this->referral_institution = $referralInstitution;
        $this->referral_name = $referralName;
        $this->referral_phone = $referralPhone;
        $this->youth = $youthNo;
        $this->referral_target = $referralTarget;
        $this->referral_attitude = $referralAttitude;
        $this->referral_attitude_other = $referralAttitudeOther;
        $this->major_demand = $majorDemand;
        $this->major_demand_other = $majorDemandOther;
        $this->is_want = $isWant;
        $this->open_case = $openCase;

        $this->db->where('youth', $youthNo);
        return $this->db->update('intake', $this);
    }

    /*
     * Get intake by youth
     * @Return: intake object
     */
    public function get_by_youth($youth)
    {
        $this->db->select('intake.*');
        
        $this->db->where('intake.youth', $youth);
        $result = $this->db->get('intake', 1)->row();
        return $result;
    }

    public function get_youth_counselor($youth)
    {
        $this->db->select('case_assessment.counselor');
        $this->db->join('member', 'member.youth = intake.youth');
        $this->db->join('case_assessment', 'case_assessment.member = member.no');
        $this->db->where('intake.youth', $youth);
        $result = $this->db->get('intake', 1)->row();
        return $result;
    }
}
