<?php
class CaseAssessmentModel extends CI_Model {
  /*
   * create one case_assessment
   * @Return: Boolean
   */

  function create_one($member, $counselor, $source, $surveyYear) {

    $this->member = $member;
    $this->interview_date = date("Y-m-d");
    $this->counselor = $counselor;
    $this->source = $source;
    $this->survey_year = $surveyYear;

    return ($this->db->insert('case_assessment', $this)) ? $this->db->insert_id() : false;
  }

   /*
   * create one case_assessment_temp
   * @Return: Boolean
   */

  function create_one_temp($member, $counselor, $source, $surveyYear) {

    $this->member = $member;
    $this->interview_date = date("Y-m-d");
    $this->counselor = $counselor;
    $this->source = $source;
    $this->survey_year = $surveyYear;

    return ($this->db->insert('case_assessment_temp', $this)) ? $this->db->insert_id() : false;
  }

  /*
   * update case_assessment by youth
   * @Return: Boolean
   */

  function update_family_diagram_by_member($familyDiagram, $member) { 
    // file
    $this->family_diagram = $familyDiagram;

    $this->db->where('member', $member);
    return $this->db->update('case_assessment', $this);
  }

   /*
   * update case_assessment_temp by youth
   * @Return: Boolean
   */

  function update_family_diagram_by_member_temp($familyDiagram, $member) { 
    // file
    $this->family_diagram = $familyDiagram;

    $this->db->where('member', $member);
    return $this->db->update('case_assessment_temp', $this);
  }

  /*
   * update case_assessment by youth
   * @Return: Boolean
   */

  function update_by_youth($member, $interviewDate, $interviewWay, $interviewPlace, $education, $source, $sourceOther, $surveyYear, $background,
    $backgroundOther, $appearanceHabits, $majorSetback, $interestPlan, $interactiveExperience, 
    $transportation, $transportationOther, $medicalSupport, $medicalReason, $familyMember, 
    $familyInteractivePattern, $communityInteractivePattern, $familyMajorSetback, $familyOtherSetback, 
    $schoolHistory, $teacherInteractivePattern, $teacherBadReason, $peerInteractivePattern, $peerBadReason, 
    $academicPerformance, $interestSubject, $violation, $violationDescription, $welfareSupport, 
    $welfareAmount, $welfareSource, $eventSource, $eventDescription, $servingSource, $servingInstitution, 
    $servingProfessional, $servingPhone, $issue, $issueOther, $counselWay, $counselWayOther, $counselTarget, $familyDiagram, $representativeAgreement, $counselor) {

    // youth basic information
    $this->interview_date = $interviewDate;
    $this->interview_way = $interviewWay;
    $this->interview_place = $interviewPlace;
    $this->education = $education;
    $this->source = $source;
    $this->source_other = $sourceOther;
    $this->survey_year = $surveyYear;
    $this->background = $background;
    $this->background_other = $backgroundOther;
    // youth description
    $this->appearance_habits = $appearanceHabits;
    $this->major_setback = $majorSetback;
    $this->interest_plan = $interestPlan;
    $this->interactive_experience = $interactiveExperience;
    $this->transportation = $transportation;
    $this->transportation_other = $transportationOther;
    $this->medical_support = $medicalSupport;
    $this->medical_reason = $medicalReason;
    // family description
    $this->family_member = $familyMember;
    $this->family_interactive_pattern = $familyInteractivePattern;
    $this->community_interactive_pattern = $communityInteractivePattern;
    $this->family_major_setback = $familyMajorSetback;
    $this->family_other_setback = $familyOtherSetback;
    // school description
    $this->school_history = $schoolHistory;
    $this->teacher_interactive_pattern = $teacherInteractivePattern;
    $this->teacher_bad_reason = $teacherBadReason;
    $this->peer_interactive_pattern = $peerInteractivePattern;
    $this->peer_bad_reason = $peerBadReason;
    $this->academic_performance = $academicPerformance;
    $this->interest_subject = $interestSubject;
    $this->violation = $violation;
    $this->violation_description = $violationDescription;
    // other intervention description
    $this->welfare_support = $welfareSupport;
    $this->welfare_amount = $welfareAmount;
    $this->welfare_source = $welfareSource;
    $this->event_source = $eventSource;
    $this->event_description = $eventDescription;
    $this->serving_source = $servingSource;
    $this->serving_institution = $servingInstitution;
    $this->serving_professional = $servingProfessional;
    $this->serving_phone = $servingPhone;
    // youth issue
    $this->issue = $issue;
    $this->issue_other = $issueOther;
    
    // case handling decision
    $this->counsel_way = $counselWay;
    $this->counsel_way_other = $counselWayOther;
    $this->counsel_target = $counselTarget;
    
    // file
    $this->family_diagram = $familyDiagram;
    $this->representative_agreement = $representativeAgreement;

    $this->counselor = $counselor;

    $this->db->where('member', $member);
    return $this->db->update('case_assessment', $this);
  }

  /*
   * update case_assessment_temp by youth
   * @Return: Boolean
   */

  function update_by_youth_temp($member, $interviewDate, $interviewWay, $interviewPlace, $education, $source, $sourceOther, $surveyYear, $background,
    $backgroundOther, $appearanceHabits, $majorSetback, $interestPlan, $interactiveExperience, 
    $transportation, $transportationOther, $medicalSupport, $medicalReason, $familyMember, 
    $familyInteractivePattern, $communityInteractivePattern, $familyMajorSetback, $familyOtherSetback, 
    $schoolHistory, $teacherInteractivePattern, $teacherBadReason, $peerInteractivePattern, $peerBadReason, 
    $academicPerformance, $interestSubject, $violation, $violationDescription, $welfareSupport, 
    $welfareAmount, $welfareSource, $eventSource, $eventDescription, $servingSource, $servingInstitution, 
    $servingProfessional, $servingPhone, $issue, $issueOther, $counselWay, $counselWayOther, $counselTarget, $familyDiagram, $representativeAgreement, $counselor) {

    // youth basic information
    $this->interview_date = $interviewDate;
    $this->interview_way = $interviewWay;
    $this->interview_place = $interviewPlace;
    $this->education = $education;
    $this->source = $source;
    $this->source_other = $sourceOther;
    $this->survey_year = $surveyYear;
    $this->background = $background;
    $this->background_other = $backgroundOther;
    // youth description
    $this->appearance_habits = $appearanceHabits;
    $this->major_setback = $majorSetback;
    $this->interest_plan = $interestPlan;
    $this->interactive_experience = $interactiveExperience;
    $this->transportation = $transportation;
    $this->transportation_other = $transportationOther;
    $this->medical_support = $medicalSupport;
    $this->medical_reason = $medicalReason;
    // family description
    $this->family_member = $familyMember;
    $this->family_interactive_pattern = $familyInteractivePattern;
    $this->community_interactive_pattern = $communityInteractivePattern;
    $this->family_major_setback = $familyMajorSetback;
    $this->family_other_setback = $familyOtherSetback;
    // school description
    $this->school_history = $schoolHistory;
    $this->teacher_interactive_pattern = $teacherInteractivePattern;
    $this->teacher_bad_reason = $teacherBadReason;
    $this->peer_interactive_pattern = $peerInteractivePattern;
    $this->peer_bad_reason = $peerBadReason;
    $this->academic_performance = $academicPerformance;
    $this->interest_subject = $interestSubject;
    $this->violation = $violation;
    $this->violation_description = $violationDescription;
    // other intervention description
    $this->welfare_support = $welfareSupport;
    $this->welfare_amount = $welfareAmount;
    $this->welfare_source = $welfareSource;
    $this->event_source = $eventSource;
    $this->event_description = $eventDescription;
    $this->serving_source = $servingSource;
    $this->serving_institution = $servingInstitution;
    $this->serving_professional = $servingProfessional;
    $this->serving_phone = $servingPhone; 
    
    // youth issue
    $this->issue = $issue;
    $this->issue_other = $issueOther;
    
    // case handling decision
    $this->counsel_way = $counselWay;
    $this->counsel_way_other = $counselWayOther;
    $this->counsel_target = $counselTarget;
    
    // file
    $this->family_diagram = $familyDiagram;
    $this->representative_agreement = $representativeAgreement;

    $this->counselor = $counselor;

    $this->db->where('member', $member);
    return $this->db->update('case_assessment_temp', $this);
  }

  function update_temp_counselor_by_no($counselor, $no) {

    $this->counselor = $counselor;

    $this->db->where('member', $no);
    return $this->db->update('case_assessment_temp', $this);
  }

  function update_counselor_by_no($counselor, $no) {

    $this->counselor = $counselor;

    $this->db->where('member', $no);
    return $this->db->update('case_assessment', $this);
  }

  /*
   * Get case_assessment by member
   * @Return: case_assessment object
   */
  function get_by_member($member) {
    $this->db->select('case_assessment.*, f.name as family_diagram_name, 
      r.name as representative_agreement_name, member.system_no, youth.name');
    $this->db->join('member', 'case_assessment.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->join('files as f', 'case_assessment.family_diagram = f.no', 'left');
    $this->db->join('files as r', 'case_assessment.representative_agreement = r.no', 'left');
    $this->db->where('case_assessment.member', $member);
    $result = $this->db->get('case_assessment', 1)->row();
    return $result;
  }

  /*
   * Get case_assessment_temp by member
   * @Return: case_assessment_temp object
   */
  function get_by_member_temp($member) {
    $this->db->select('case_assessment_temp.*, f.name as family_diagram_name, 
      r.name as representative_agreement_name, member.system_no, youth.name');
    $this->db->join('member', 'case_assessment_temp.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->join('files as f', 'case_assessment_temp.family_diagram = f.no', 'left');
    $this->db->join('files as r', 'case_assessment_temp.representative_agreement = r.no', 'left');
    $this->db->where('case_assessment_temp.member', $member);
    $result = $this->db->get('case_assessment_temp', 1)->row();
    return $result;
  }

  function get_by_no_temp($no) {
    $this->db->select('case_assessment_temp.*, f.name as family_diagram_name, 
      r.name as representative_agreement_name, member.system_no, youth.name');
    $this->db->join('member', 'case_assessment_temp.member = member.no');
    $this->db->join('youth', 'member.youth = youth.no');
    $this->db->join('files as f', 'case_assessment_temp.family_diagram = f.no', 'left');
    $this->db->join('files as r', 'case_assessment_temp.representative_agreement = r.no', 'left');
    $this->db->where('case_assessment_temp.no', $no);
    $result = $this->db->get('case_assessment_temp', 1)->row();
    return $result;
  }

  /*
   * check is case_assessment exist
   * @Return: Boolean
   */
  function is_case_assessment_exist($member) {
    $this->db->where('member', $member);
    return $this->db->get('case_assessment', 1)->num_rows() > 0;
  }

  /*
   * check is case_assessment_temp exist
   * @Return: Boolean
   */
  function is_case_assessment_exist_temp($member) {
    $this->db->where('member', $member);
    return $this->db->get('case_assessment_temp', 1)->num_rows() > 0;
  }
}