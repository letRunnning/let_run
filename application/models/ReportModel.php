<?php
class ReportModel extends CI_Model
{
    /*
     * Get report by counselor
     * @Return: report object
     */
    public function get_report_by_conselor($counselor, $educationSourceNumber, $laborSourceNumber, $socialSourceNumber, $healthSourceNumber, $officeSourceNumber, $judicialSourceNumber, $otherSourceNumber)
    {

        $this->db->select('member.*, youth.name, youth.identification,
      (select sum(duration_hour) from individual_counseling where member = member.no) as individualCounselingHour,
      (select sum(duration) from course_attendance where member = member.no) as courseAttendanceHour,
      (select sum(duration) from work_attendance where member = member.no) as workAttendanceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $educationSourceNumber . ') as educationSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $laborSourceNumber . ') as laborSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $socialSourceNumber . ') as socialSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $healthSourceNumber . ') as healthSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $officeSourceNumber . ') as officeSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $judicialSourceNumber . ') as judicialSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $otherSourceNumber . ') as otherSourceHour,
      sum(group_counseling.duration_hour) as groupCounselingHour');
        $this->db->from('member');
        $this->db->join('youth', 'member.youth = youth.no');
        $this->db->join('group_counseling_participants', 'member.no = group_counseling_participants.member');
        $this->db->join('group_counseling', 'group_counseling.no = group_counseling_participants.group_counseling');
        $this->db->where('member.counselor', $counselor);
        $this->db->group_by('member.no');

        $result = $this->db->get()->result_array();
        return $result;
    }

    /*
     * Get report by organization
     * @Return: report object
     */
    public function get_report_by_organization($organization, $educationSourceNumber, $laborSourceNumber, $socialSourceNumber, $healthSourceNumber, $officeSourceNumber, $judicialSourceNumber, $otherSourceNumber)
    {

        $this->db->select('member.*, youth.name, youth.identification,
      (select sum(duration_hour) from individual_counseling where member = member.no) as individualCounselingHour,
      (select sum(duration) from course_attendance where member = member.no) as courseAttendanceHour,
      (select sum(duration) from work_attendance where member = member.no) as workAttendanceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $educationSourceNumber . ') as educationSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $laborSourceNumber . ') as laborSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $socialSourceNumber . ') as socialSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $healthSourceNumber . ') as healthSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $officeSourceNumber . ') as officeSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $judicialSourceNumber . ') as judicialSourceHour,
      (select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $otherSourceNumber . ') as otherSourceHour,
      sum(group_counseling.duration_hour) as groupCounselingHour');
        $this->db->from('member');
        $this->db->join('youth', 'member.youth = youth.no');
        $this->db->join('group_counseling_participants', 'member.no = group_counseling_participants.member');
        $this->db->join('group_counseling', 'group_counseling.no = group_counseling_participants.group_counseling');
        $this->db->where('member.organization', $organization);
        $this->db->group_by('member.no');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_survey_type_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberOne'] . ') as surveyTypeNumberOne,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberTwo'] . ') as surveyTypeNumberTwo,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberThree'] . ') as surveyTypeNumberThree,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberFour'] . ') as surveyTypeNumberFour,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberFive'] . ') as surveyTypeNumberFive,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberSix'] . ') as surveyTypeNumberSix,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberSeven'] . ') as surveyTypeNumberSeven,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberEight'] . ') as surveyTypeNumberEight,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberNine'] . ') as surveyTypeNumberNine,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberTen'] . ') as surveyTypeNumberTen,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberEleven'] . ') as surveyTypeNumberEleven,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberTwelve'] . ') as surveyTypeNumberTwelve,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberTwelveOne'] . ') as surveyTypeNumberTwelveOne,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberTwelveTwo'] . ') as surveyTypeNumberTwelveTwo,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberTwelveThree'] . ') as surveyTypeNumberTwelveThree,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberThirteen'] . ') as surveyTypeNumberThirteen,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberThirteenOne'] . ') as surveyTypeNumberThirteenOne,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberThirteenTwo'] . ') as surveyTypeNumberThirteenTwo,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and survey_type = ' . $surveyTypeData['surveyTypeNumberThirteenThree'] . ') as surveyTypeNumberThirteenThree,');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_seasonal_review_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyAttendingSchool'] . ') as already_attending_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyWorking'] . ') as already_working,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToSchool'] . ') as prepare_to_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToWork'] . ') as prepare_to_work,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferLabor'] . ') as transfer_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherOne'] . ') as transfer_other_one,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherTwo'] . ') as transfer_other_two,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherThree'] . ') as transfer_other_three,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFour'] . ') as transfer_other_four,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFive'] . ') as transfer_other_five,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['noPlan'] . ') as no_plan,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['lostContact'] . ') as lost_contact,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['military'] . ') as military,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['pregnancy'] . ') as pregnancy,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['immigration'] . ') as immigration,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['health'] . ') as health,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['other'] . ') as other,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['specialEducationStudent'] . ') as special_education_student,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['training'] . ') as training,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['familyLabor'] . ') as family_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['death'] . ') as death,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['adult'] . ') as adult,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['selfStudy'] . ') as self_study,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225) as youthCount');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_seasonal_review_month_report_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['alreadyAttendingSchool'] . ') as already_attending_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['alreadyWorking'] . ') as already_working,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['prepareToSchool'] . ') as prepare_to_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['prepareToWork'] . ') as prepare_to_work,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['transferLabor'] . ') as transfer_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['transferOtherOne'] . ') as transfer_other_one,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['transferOtherTwo'] . ') as transfer_other_two,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['transferOtherThree'] . ') as transfer_other_three,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['transferOtherFour'] . ') as transfer_other_four,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['transferOtherFive'] . ') as transfer_other_five,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['noPlan'] . ') as no_plan,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['lostContact'] . ') as lost_contact,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['military'] . ') as military,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['pregnancy'] . ') as pregnancy,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['immigration'] . ') as immigration,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['health'] . ') as health,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['other'] . ') as other,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['specialEducationStudent'] . ') as special_education_student,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['training'] . ') as training,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['familyLabor'] . ') as family_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['death'] . ') as death,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['adult'] . ') as adult,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225 and seasonal_review.trend = ' . $surveyTypeData['selfStudy'] . ') as self_study,
      (select count(*) from youth where youth.source_school_year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and youth.survey_type >= 216 and youth.survey_type<= 232 and youth.survey_type != 225) as youthCount');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_seasonal_review_note_by_county($surveyTypeData)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $surveyTypeData['county']);
      $this->db->where('youth.source_school_year', $surveyTypeData['yearType']);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function get_seasonal_review_note_month_report_by_county($surveyTypeData)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $surveyTypeData['county']);
      $this->db->where('youth.source_school_year', $surveyTypeData['yearType']);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }


    public function get_seasonal_review_report_by_county($county, $year, $month)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $county);
      $sourceSchoolYearArray = array(date("Y")-1911-4,date("Y")-1911-3, date("Y")-1911-2, date("Y")-1911-1,0);
      $this->db->where_in('source_school_year', $sourceSchoolYearArray);
      $this->db->where('youth.source!=', 195);

      $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
      $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;
      $this->db->where('seasonal_review.date <', ($addYear + 1911) . '-' . $addMonth .'-1');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function new_get_seasonal_review_report_by_county($county, $year, $month)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $county);
      $sourceSchoolYearArray = array(date("Y")-1911-2,0);
      $this->db->where_in('source_school_year', $sourceSchoolYearArray);
      $this->db->where('youth.source!=', 195);

      $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
      $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;
      $this->db->where('seasonal_review.date <', ($addYear + 1911) . '-' . $addMonth .'-1');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function get_high_school_seasonal_review_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyAttendingSchool'] . ') as already_attending_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyWorking'] . ') as already_working,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToSchool'] . ') as prepare_to_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToWork'] . ') as prepare_to_work,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferLabor'] . ') as transfer_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherOne'] . ') as transfer_other_one,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherTwo'] . ') as transfer_other_two,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherThree'] . ') as transfer_other_three,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFour'] . ') as transfer_other_four,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFive'] . ') as transfer_other_five,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['noPlan'] . ') as no_plan,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['lostContact'] . ') as lost_contact,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['military'] . ') as military,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['pregnancy'] . ') as pregnancy,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['immigration'] . ') as immigration,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['health'] . ') as health,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['other'] . ') as other,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['specialEducationStudent'] . ') as special_education_student,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['training'] . ') as training,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['familyLabor'] . ') as family_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['death'] . ') as death,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['adult'] . ') as adult,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['selfStudy'] . ') as self_study,
      (select count(*) from youth where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no) as youthCount');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_high_school_seasonal_review_month_report_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyAttendingSchool'] . ') as already_attending_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyWorking'] . ') as already_working,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToSchool'] . ') as prepare_to_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToWork'] . ') as prepare_to_work,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferLabor'] . ') as transfer_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherOne'] . ') as transfer_other_one,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherTwo'] . ') as transfer_other_two,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherThree'] . ') as transfer_other_three,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFour'] . ') as transfer_other_four,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFive'] . ') as transfer_other_five,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['noPlan'] . ') as no_plan,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['lostContact'] . ') as lost_contact,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['military'] . ') as military,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['pregnancy'] . ') as pregnancy,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['immigration'] . ') as immigration,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['health'] . ') as health,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['other'] . ') as other,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['specialEducationStudent'] . ') as special_education_student,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['training'] . ') as training,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['familyLabor'] . ') as family_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['death'] . ') as death,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['adult'] . ') as adult,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['selfStudy'] . ') as self_study,
      (select count(*) from youth where youth.source LIKE "%' . $surveyTypeData['source'] . '%" and youth.county = county.no) as youthCount');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_high_school_seasonal_review_note_by_county($surveyTypeData)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $surveyTypeData['county']);
      //$this->db->where('youth.source', $surveyTypeData['source']);
      $this->db->like('youth.source', $surveyTypeData['source'], 'both');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function get_high_school_seasonal_review_note_month_report_by_county($surveyTypeData)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $surveyTypeData['county']);
      //$this->db->where('youth.source', $surveyTypeData['source']);
      $this->db->like('youth.source', $surveyTypeData['source'], 'both');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function get_old_case_seasonal_review_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyAttendingSchool'] . ') as already_attending_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyWorking'] . ') as already_working,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToSchool'] . ') as prepare_to_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToWork'] . ') as prepare_to_work,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferLabor'] . ') as transfer_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherOne'] . ') as transfer_other_one,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherTwo'] . ') as transfer_other_two,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherThree'] . ') as transfer_other_three,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFour'] . ') as transfer_other_four,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFive'] . ') as transfer_other_five,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['noPlan'] . ') as no_plan,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['lostContact'] . ') as lost_contact,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['military'] . ') as military,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['pregnancy'] . ') as pregnancy,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['immigration'] . ') as immigration,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['health'] . ') as health,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['other'] . ') as other,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['specialEducationStudent'] . ') as special_education_student,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['training'] . ') as training,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['familyLabor'] . ') as family_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['death'] . ') as death,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['adult'] . ') as adult,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['selfStudy'] . ') as self_study,
      (select count(*) from (SELECT * from member where member.year in (' . (date('Y')-1911-1) . ',' . (date('Y')-1911) . ') group by youth having count(*) = 1)a where a.end_date is not null and a.county = county.no) as youthCount');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no!=' , 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_old_case_seasonal_review_month_report_by_county($surveyTypeData)
    {
        $this->db->select('county.name,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyAttendingSchool'] . ') as already_attending_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['alreadyWorking'] . ') as already_working,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToSchool'] . ') as prepare_to_school,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['prepareToWork'] . ') as prepare_to_work,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferLabor'] . ') as transfer_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherOne'] . ') as transfer_other_one,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherTwo'] . ') as transfer_other_two,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherThree'] . ') as transfer_other_three,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFour'] . ') as transfer_other_four,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['transferOtherFive'] . ') as transfer_other_five,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['noPlan'] . ') as no_plan,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['lostContact'] . ') as lost_contact,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['military'] . ') as military,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['pregnancy'] . ') as pregnancy,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['immigration'] . ') as immigration,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['health'] . ') as health,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['other'] . ') as other,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['specialEducationStudent'] . ') as special_education_student,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['training'] . ') as training,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['familyLabor'] . ') as family_labor,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['death'] . ') as death,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['adult'] . ') as adult,
      (select count(*) from (SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review left join youth on seasonal_review.youth = youth.no left join member on youth.no = member.youth where member.year = ' . $surveyTypeData['yearType'] . ' and youth.county = county.no and seasonal_review.trend = ' . $surveyTypeData['selfStudy'] . ') as self_study,
      (select count(*) from (SELECT * from member where member.year = ' . $surveyTypeData['yearType'] . ')a where a.county = county.no) as youthCount');

        $this->db->from('county');

        if ($surveyTypeData['county'] != 'all' && !empty($surveyTypeData['county'])) {
            $this->db->where('county.no', $surveyTypeData['county']);
        }
        $this->db->where('county.no!=' , 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_old_case_seasonal_review_note_by_county($surveyTypeData)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->join('member', 'youth.no = member.youth');
      $this->db->where('youth.county', $surveyTypeData['county']);
      $this->db->where('member.year', $surveyTypeData['yearType']);
      //$this->db->where('youth.source', $surveyTypeData['source']);
      //$this->db->like('youth.source', $surveyTypeData['source'], 'both');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function get_old_case_seasonal_review_note_month_report_by_county($surveyTypeData)
    {
      $this->db->select('county.name, youth.name as youthName, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->join('member', 'youth.no = member.youth');
      $this->db->where('youth.county', $surveyTypeData['county']);
      $this->db->where('member.year', $surveyTypeData['yearType']);
      //$this->db->where('youth.source', $surveyTypeData['source']);
      //$this->db->like('youth.source', $surveyTypeData['source'], 'both');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review where date >="' . $surveyTypeData['startDate'] . '" and date <= "' . $surveyTypeData['endDate'] . '" ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function get_counsel_effection_by_county($county, $year, $surveyTypeData)
    {
        $this->db->select('county.name, county.no,
      (select count(*) from youth where youth.source_school_year = ' . ($year-2) . ' and youth.source LIKE "%' . $surveyTypeData['schoolSource'] . '%" and youth.survey_type >= 216 and youth.survey_type <= 224 and youth.survey_type != 225 and youth.survey_type != 233 and youth.survey_type != 234 and youth.survey_type != 235 and youth.county = county.no ) as schoolSourceCount,
      (select count(*) from youth where youth.source = "' . $surveyTypeData['highSource'] . '" and youth.county = county.no ) as highSourceCount,
      (select count(*) from member where member.year = ' . $year . ' and member.county = county.no) as memberCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $year . ' and member.county = county.no group by member.county ), 0) as individualCounselingCount,
      IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where member.year = ' . $year . ' and member.county = county.no), 0) as groupCounselingCount,
      IFNULL((select SUM(t.duration) from (select distinct start_time, duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no where member.year = ' . $year . ') as t where t.county = county.no), 0) as courseAttendanceCount,
      IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no where member.year = ' . $year . ' and member.county = county.no ), 0) as workAttendanceCount,
      (select count(*) from end_case left join member on end_case.member = member.no where member.year = ' . $year . ' and member.county = county.no ) as endCaseCount,
      (select count(*) from seasonal_review left join youth on seasonal_review.youth = youth.no where youth.year = ' . $year . ' and youth.county = county.no ) as seasonalReviewCount,
      (select count(*) from month_review left join member on month_review.member = member.no where member.year = ' . $year . ' and member.county = county.no ) as monthReviewCount');

        $this->db->from('county');

        if ($county != 'all' && !empty($county)) {
            $this->db->where('county.no', $county);
        }
        $this->db->where('county.no!=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;

    }

    public function get_individual_counseling_report_by_county($data)
    {
        $this->db->select('county.name,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and member.county = county.no group by member.county ), 0) as individualCounselingCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.service_way = ' . $data['phoneService'] . ' and member.county = county.no group by member.county ), 0) as phoneServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.service_way = ' . $data['personallyService'] . ' and member.county = county.no group by member.county ), 0) as personallyServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.service_way = ' . $data['internetService'] . ' and member.county = county.no group by member.county ), 0) as internetServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['educationService'] . ' and member.county = county.no group by member.county ), 0) as educationServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['laborService'] . ' and member.county = county.no group by member.county ), 0) as laborServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['healthService'] . ' and member.county = county.no group by member.county ), 0) as healthServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['officeService'] . ' and member.county = county.no group by member.county ), 0) as officeServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['judicialService'] . ' and member.county = county.no group by member.county ), 0) as judicialServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['otherService'] . ' and member.county = county.no group by member.county ), 0) as otherServiceCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $data['yearType'] . ' and individual_counseling.referral_resource = ' . $data['socialService'] . ' and member.county = county.no group by member.county ), 0) as socialServiceCount');

        $this->db->from('county');

        if ($data['county'] != 'all' && !empty($data['county'])) {
            $this->db->where('county.no', $data['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        
        $this->db->order_by("county.priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_group_counseling_report_by_county($data)
    {
        $this->db->select('county.name,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['exploreService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as exploreServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['interactiveService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as interactiveServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['experienceService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as experienceServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['environmentService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as environmentServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['judicialService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as judicialServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['genderService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as genderServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['professionService'] . ' and member.year = ' .$data['yearType'] . ' and member.county = county.no), 0) as professionServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['volunteerService'] . ' and member.year = ' .$data['yearType'] . ' and member.county = county.no), 0) as volunteerServiceCount,
          IFNULL((select SUM(group_counseling.duration_hour) from group_counseling left join group_counseling_participants on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.service_target = ' .$data['otherService'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no), 0) as otherServiceCount');

        $this->db->from('county');

        if ($data['county'] != 'all' && !empty($data['county'])) {
            $this->db->where('county.no', $data['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("county.priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_course_report_by_county($data)
    {
        $this->db->select('county.name,
          IFNULL((select SUM(t.duration) from (select distinct course_attendance.start_time, course_attendance.duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no left join course on course_attendance.course = course.no left join course_reference on course.course_reference = course_reference.no where course_attendance.start_time is not null and course_reference.category = ' . $data['exploreCourse'] .' and member.year = ' . $data['yearType'] . ') as t where t.county = county.no), 0) as exploreCourseCount,
          IFNULL((select SUM(t.duration) from (select distinct course_attendance.start_time, course_attendance.duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no left join course on course_attendance.course = course.no left join course_reference on course.course_reference = course_reference.no where course_attendance.start_time is not null and course_reference.category = ' . $data['experienceCourse'] .' and member.year = ' . $data['yearType'] . ') as t where t.county = county.no), 0) as experienceCourseCount,
          IFNULL((select SUM(t.duration) from (select distinct course_attendance.start_time, course_attendance.duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no left join course on course_attendance.course = course.no left join course_reference on course.course_reference = course_reference.no where course_attendance.start_time is not null and course_reference.category = ' . $data['officeCourse'] .' and member.year = ' . $data['yearType'] . ') as t where t.county = county.no), 0) as officeCourseCount,
          IFNULL((select SUM(t.duration) from (select distinct course_attendance.start_time, course_attendance.duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no left join course on course_attendance.course = course.no left join course_reference on course.course_reference = course_reference.no where course_attendance.start_time is not null and course_reference.category = ' . $data['otherCourse'] .' and member.year = ' . $data['yearType'] . ') as t where t.county = county.no), 0) as otherCourseCount');

        $this->db->from('county');

        if ($data['county'] != 'all' && !empty($data['county'])) {
            $this->db->where('county.no', $data['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("county.priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_work_report_by_county($data)
    {
        $this->db->select('county.name,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['farmWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as farmWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['miningWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as miningWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['manufacturingWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as manufacturingWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['electricityWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as electricityWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['waterWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as waterWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['buildWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as buildWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['wholesaleWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as wholesaleWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['transportWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as transportWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['hotelWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as hotelWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['publishWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as publishWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['financialWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as financialWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['immovablesWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as immovablesWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['scienceWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as scienceWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['supportWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as supportWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['militaryWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as militaryWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['educationWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as educationWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['hospitalWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as hospitalWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['artWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as artWorkCount,
          IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no left join work_experience on work_attendance.work_experience = work_experience.no left join company on work_experience.company = company.no where company.category = ' . $data['otherWork'] . ' and member.year = ' . $data['yearType'] . ' and member.county = county.no ), 0) as otherWorkCount');

        $this->db->from('county');

        if ($data['county'] != 'all' && !empty($data['county'])) {
            $this->db->where('county.no', $data['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("county.priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_meeting_report_by_county($data)
    {
        $this->db->select('county.name,
          (select count(*) from meeting left join organization on meeting.organization = organization.no where meeting.meeting_type = ' . $data['meetingType'] . ' and meeting.year = ' . $data['yearType'] . ' and organization.county = county.no ) as meetingCount,
          (select count(*) from meeting left join organization on meeting.organization = organization.no where meeting.meeting_type = ' . $data['activityType'] . ' and meeting.year = ' . $data['yearType'] . ' and organization.county = county.no ) as activityCount');

        $this->db->from('county');

        if ($data['county'] != 'all' && !empty($data['county'])) {
            $this->db->where('county.no', $data['county']);
        }
        $this->db->where('county.no !=', 23);
        $this->db->group_by('county.no');
        $this->db->order_by("county.priority", "asc");
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_county_delegate_organization($county, $year)
    {
        $this->db->select('county.name as countyName,
      project.name as projectName,
      organization.name as organizationName,
      organization.phone as organizationPhone,
      organization.address as organizationAddress,
      project.execute_mode as executeMode,
      project.execute_way as executeWay,
      project.counseling_member as counselingMember,
      project.counseling_hour as counselingHour,
      project.course_hour as courseHour,
      project.working_member as workingMember,
      project.counselor_count as counselorCount,
      project.meeting_count as meetingCount,
      project.working_hour as workingHour,
      project.funding as funding,
      project.counseling_youth as counselingYouth,
      project.group_counseling_hour as groupCounselingHour,
      county.update_project,
      county.no');

        $this->db->from('county_delegate_organization');
        $this->db->join('county', 'county_delegate_organization.county = county.no');
        $this->db->join('project', 'county_delegate_organization.project = project.no');
        $this->db->join('organization', 'county_delegate_organization.organization = organization.no');

        if ($county != 'all' && !empty($county)) {
            $this->db->where('county_delegate_organization.county', $county);
        }
        $this->db->where('county.no !=', 23);
        $this->db->where('project.year', $year);
        $this->db->order_by("county.priority", "asc");
        $this->db->group_by('county.no');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_member_counseling($memberCounselingData)
    {

        // $this->db->select('member.*,
        //   (select youth.name from youth left join member on youth.no = member.youth where member.year = ' . $memberCounselingData['yearType'] .' and member.organization =' . $memberCounselingData['organization'] . ') as name,
        //   (select youth.identification from youth left join member on youth.no = member.youth where member.year = ' . $memberCounselingData['yearType'] .' and member.organization =' . $memberCounselingData['organization'] . ') as identification,
        //   (select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ') as individualCounselingHour,
        //   (select sum(duration) from course_attendance left join member on course_attendance.member = member.no where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ') as courseAttendanceHour,
        //   (select sum(duration) from work_attendance left join member on work_attendance.member = member.no where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ') as workAttendanceHour,
        //   (select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['educationSourceNumber'] . ') as educationSourceHour,
        //   (select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['laborSourceNumber'] . ') as laborSourceHour,
        //   (select sum(duration_hour) from individual_counseling where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['socialSourceNumber'] . ') as socialSourceHour,
        //   (select sum(duration_hour) from individual_counseling where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['healthSourceNumber'] . ') as healthSourceHour,
        //   (select sum(duration_hour) from individual_counseling where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['officeSourceNumber'] . ') as officeSourceHour,
        //   (select sum(duration_hour) from individual_counseling where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['judicialSourceNumber'] . ') as judicialSourceHour,
        //   (select sum(duration_hour) from individual_counseling where member.year = ' . $memberCounselingData['yearType'] .' and member = member.no and member.organization =' . $memberCounselingData['organization'] . ' and referral_resource = ' . $memberCounselingData['otherSourceNumber'] . ') as otherSourceHour,
        //   IFNULL((select SUM(group_counseling.duration_hour) from group_counseling_participants left join group_counseling on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where member.year = ' . $memberCounselingData['yearType'] .' and member.organization = ' . $memberCounselingData['organization'] . '), 0) as groupCounselingHour');
        // $this->db->from('member');
        // $this->db->where('member.organization', $memberCounselingData['organization']);
        // $this->db->group_by('member.system_no');

        // $result = $this->db->get()->result_array();

        $this->db->select('member.*, youth.name, youth.identification,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no), 0) as individualCounselingHour,
      IFNULL((select sum(duration) from course_attendance where member = member.no), 0) as courseAttendanceHour,
      IFNULL((select sum(duration) from work_attendance where member = member.no), 0) as workAttendanceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['educationSourceNumber'] . '), 0) as educationSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['laborSourceNumber'] . '), 0) as laborSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['socialSourceNumber'] . '), 0) as socialSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['healthSourceNumber'] . '), 0) as healthSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['officeSourceNumber'] . '), 0) as officeSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['judicialSourceNumber'] . '), 0) as judicialSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['otherSourceNumber'] . '), 0) as otherSourceHour,
      IFNULL((select sum(group_counseling.duration_hour) from group_counseling_participants left join group_counseling on group_counseling_participants.group_counseling = group_counseling.no where member = member.no), 0) as groupCounselingHour');
        $this->db->from('member');
        $this->db->join('youth', 'member.youth = youth.no');
        $this->db->where('member.organization', $memberCounselingData['organization']);
        $this->db->where('member.year', $memberCounselingData['yearType']);
        $this->db->group_by('member.no');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_member_counseling_by_counseler($memberCounselingData)
    {
        $this->db->select('member.*, youth.name, aes_decrypt(`youth`.`identification`, "' . $this->config->item('db_token') . '") as identifications,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no), 0) as individualCounselingHour,
      IFNULL((select sum(duration) from course_attendance where member = member.no), 0) as courseAttendanceHour,
      IFNULL((select sum(duration) from work_attendance where member = member.no), 0) as workAttendanceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['educationSourceNumber'] . '), 0) as educationSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['laborSourceNumber'] . '), 0) as laborSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['socialSourceNumber'] . '), 0) as socialSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['healthSourceNumber'] . '), 0) as healthSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['officeSourceNumber'] . '), 0) as officeSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['judicialSourceNumber'] . '), 0) as judicialSourceHour,
      IFNULL((select sum(duration_hour) from individual_counseling where member = member.no and referral_resource = ' . $memberCounselingData['otherSourceNumber'] . '), 0) as otherSourceHour,
      IFNULL((select sum(group_counseling.duration_hour) from group_counseling_participants left join group_counseling on group_counseling_participants.group_counseling = group_counseling.no where member = member.no), 0) as groupCounselingHour');
        $this->db->from('member');
        $this->db->join('youth', 'member.youth = youth.no');
        $this->db->where('member.counselor', $memberCounselingData['counselor']);
        $this->db->where('member.year', $memberCounselingData['yearType']);
        $this->db->group_by('member.no');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_statistics_card_county($year, $county)
    {
        $this->db->select('county.name as countyCount,
      (select count(*) from counselor left join organization on counselor.organization = organization.no left join users on counselor.no = users.counselor where organization.county = county.no and users.usable = 1) as counselorCount,
      (select COUNT(*) from member left join youth on member.youth = youth.no where youth.county = county.no and member.year = ' . $year . ') as memberCount,
      IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where member.year = ' . $year . ' and member.county = county.no group by member.county ), 0) as individualCounselingHour,
      IFNULL((select SUM(group_counseling.duration_hour) from group_counseling_participants left join group_counseling on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where member.year = ' . $year . ' and member.county = county.no ), 0) as groupCounselingHour,
      IFNULL((select SUM(t.duration) from (select distinct start_time, duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no where course_attendance.start_time is not null and member.year = ' . $year . ') as t where t.county = county.no), 0) as courseAttendanceHour,
      IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no where member.year = ' . $year . ' and member.county = county.no ), 0) as workAttendanceHour');
        $this->db->where('county.no', $county);
        $result = $this->db->get('county', 1)->row();
        return $result;
    }

    public function get_statistics_card()
    {
        $this->db->select('COUNT(*) as countyCount,
      (select count(*) from counselor) as counselorCount,
      (select COUNT(*) from member) as memberCount,
      IFNULL((select SUM(duration_hour) from individual_counseling), 0) as individualCounselingHour,
      IFNULL((select SUM(duration_hour) from group_counseling), 0) as groupCounselingHour,
      IFNULL((select SUM(duration) from course_attendance), 0) as courseAttendanceHour,
      IFNULL((select SUM(duration) from work_attendance), 0) as workAttendanceHour');
      
        $this->db->where('county.no!=', 23);

        $result = $this->db->get('county', 1)->row();

        return $result;
    }

    public function get_member_counseling_by_county($county, $monthType, $yearType)
    {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    
        $this->db->select('IFNULL((select sum(duration_hour) from individual_counseling left join member on individual_counseling.member = member.no where individual_counseling.start_time < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.year = ' . $yearType . ' and member.create_date < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.county = county.no group by member.county ), 0) as individualCounselingCount,
    IFNULL((select SUM(group_counseling.duration_hour) from group_counseling_participants left join group_counseling on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no where group_counseling.start_time < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.year = ' . $yearType . ' and member.create_date < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.county = county.no ), 0) as groupCounselingCount,
    IFNULL((select SUM(t.duration) from (select distinct start_time, duration ,member.county as county from course_attendance left join member on course_attendance.member = member.no where course_attendance.start_time < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and course_attendance.start_time is not null and member.year = ' . $yearType . ' and member.create_date <"'. ($addYear + 1911) . '-' . $addMonth .'-1") as t where t.county = county.no), 0) as courseAttendanceCount,
    IFNULL((select SUM(duration) from work_attendance left join member on work_attendance.member = member.no where work_attendance.start_time < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.year = ' . $yearType . ' and member.create_date < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.county = county.no ), 0) as workAttendanceCount');
        $this->db->from('county');

        $this->db->where('county.no', $county);
        $this->db->group_by('county.no');
        $result = $this->db->get()->row();
        return $result;
    }

    /*
      青少年來源 : 109高中已錄取未註冊、108動向調查(4-12)
    */
    public function report_one_get_seasonal_review_report_by_county($county, $year, $month)
    {
      $this->db->select('county.name, youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $county);
      $sourceSchoolYearArray = array(date("Y")-1911-2,0);
      $this->db->where_in('source_school_year', $sourceSchoolYearArray);
      $this->db->where('youth.source!=', 195);

      $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
      $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;
      $this->db->where('seasonal_review.date <', ($addYear + 1911) . '-' . $addMonth .'-1');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    public function report_one_get_member_temp_report_by_county($county, $year, $month)
    {
      $this->db->select('youth.name as youthName, member.*, month_member_temp_counseling.*');
      $this->db->join('member', 'member.no = month_member_temp_counseling.member');
      $this->db->join('youth', 'member.youth = youth.no');
     
      $this->db->where('month_member_temp_counseling.month', $month);
      $this->db->where('month_member_temp_counseling.year', $year);
      $this->db->where('month_member_temp_counseling.county', $county);

      $result = $this->db->get('month_member_temp_counseling')->result_array();
      return $result;
    }

    public function report_one_get_individual_counseling_by_county($county, $yearType, $monthType)
    {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    
      $this->db->select('individual_counseling.*, member.system_no, youth.name, sum(duration_hour) as sum from individual_counseling left join member on individual_counseling.member = member.no left join youth on member.youth = youth.no where individual_counseling.start_time < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.year = ' . $yearType . ' and member.create_date < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.county =' . $county . ' group by member.no');
      
      $result = $this->db->get()->result_array();
      return $result;
    }

    public function report_one_get_group_counseling_by_county($county, $yearType, $monthType)
    {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
    
      $this->db->select('group_counseling.*, group_counseling_participants.*, member.system_no, youth.name, sum(duration_hour) as sum from group_counseling_participants left join group_counseling on group_counseling_participants.group_counseling = group_counseling.no left join member on group_counseling_participants.member = member.no left join youth on member.youth = youth.no where group_counseling.start_time < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.year = ' . $yearType . ' and member.create_date < "'. ($addYear + 1911) . '-' . $addMonth .'-1" and member.county = ' . $county .' group by group_counseling.no');
     
      $result = $this->db->get()->result_array();
      return $result;
    }

    function report_one_get_course_by_county($county, $yearType, $monthType) {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;

      $this->db->select('course_attendance.*, course_reference.name');
      $this->db->join('course', 'course_attendance.course = course.no');
      $this->db->join('course_reference', 'course_reference.no = course.course_reference');
      $this->db->join('organization', 'course.organization = organization.no');
      $this->db->where('organization.county', $county);
      $this->db->where('course.year', $yearType);
      $this->db->where('course_attendance.start_time !=', null);
      $this->db->where('course_attendance.start_time <', ($addYear + 1911) . '-' . $addMonth .'-1');
      $this->db->group_by("course_attendance.start_time"); 
      $result = $this->db->get('course_attendance')->result_array();
      return $result;
    }
  
    function report_one_get_course_member_name_by_county($county, $yearType, $monthType) {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;

      $this->db->select('course_attendance.*, course_reference.name, youth.name as youthName');
      $this->db->join('course', 'course_attendance.course = course.no');
      $this->db->join('course_reference', 'course_reference.no = course.course_reference');
      $this->db->join('member', 'course_attendance.member = member.no');
      $this->db->join('youth', 'member.youth = youth.no');
      $this->db->join('organization', 'course.organization = organization.no');
      $this->db->where('organization.county', $county);
      $this->db->where('course.year', $yearType);
      $this->db->where('course_attendance.start_time <', ($addYear + 1911) . '-' . $addMonth .'-1');
      $result = $this->db->get('course_attendance')->result_array();
      return $result;
    }

    function report_one_get_work_by_county($county, $yearType, $monthType) {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;

      $this->db->select('work_attendance.*, company.name, work_experience.no as workExperienceNo, youth.name as youthName, member.no as memberNo, sum(work_attendance.duration) as sum');
      $this->db->join('work_experience', 'work_experience.no = work_attendance.work_experience');
      $this->db->join('company', 'company.no = work_experience.company');
      $this->db->join('member', 'work_attendance.member = member.no');
      $this->db->join('youth', 'member.youth = youth.no');
      $this->db->join('organization', 'work_experience.organization = organization.no');
      $this->db->where('organization.county', $county);
      $this->db->where('work_experience.year', $yearType);
      $this->db->where('work_attendance.start_time <', ($addYear + 1911) . '-' . $addMonth .'-1');
      $this->db->group_by('work_attendance.member');
      $result = $this->db->get('work_attendance')->result_array();
      return $result;
    }

    public function report_survey_type_seasonal_review_by_county($county, $year, $month, $schoolYear)
    {
      $this->db->select('county.name, youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $county);
      $this->db->where('youth.source_school_year', $schoolYear);

      $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
      $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;
      $this->db->where('seasonal_review.date <', ($addYear + 1911) . '-' . $addMonth .'-1');
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    
    public function report_survey_type_youth_by_county($county, $schoolYear)
    {
      $this->db->select('youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->from('youth');

      $this->db->join('seasonal_review', 'seasonal_review.youth = youth.no', 'left');

      $this->db->where('youth.county', $county);
      $this->db->where('youth.source_school_year', $schoolYear);
      $this->db->where('youth.survey_type >=', 216);
      $this->db->where('youth.survey_type <=', 232);
      $this->db->where('youth.survey_type !=', 225);
      $this->db->group_by('youth.no');

      $result = $this->db->get()->result_array();
      return $result;
    }

    public function report_high_school_seasonal_review_by_county($county, $year, $month)
    {
      $this->db->select('county.name, youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->where('youth.county', $county);
      $this->db->like('youth.source', '229', 'both');

      $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
      $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;
      $this->db->where('seasonal_review.date <', ($addYear + 1911) . '-' . $addMonth .'-1');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    
    public function report_high_school_youth_by_county($county)
    {
      $this->db->select('youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->from('youth');

      $this->db->join('seasonal_review', 'seasonal_review.youth = youth.no', 'left');

      $this->db->where('youth.county', $county);
      $this->db->like('youth.source', '229', 'both');
      $this->db->group_by('youth.no');

      $result = $this->db->get()->result_array();
      return $result;
    }

    public function report_old_case_seasonal_review_by_county($county, $year, $month)
    {
      $this->db->select('county.name, youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->join('youth', 'seasonal_review.youth = youth.no');
      $this->db->join('county', 'youth.county = county.no');
      $this->db->join('member', 'member.youth = youth.no');
      $this->db->where('youth.county', $county);
      $this->db->where('member.year', $year-1);

      $addMonth = ($month + 1 > 12) ? 1 : $month+1 ;
      $addYear =  ($month + 1 > 12) ? $year + 1 : $year ;
      $this->db->where('seasonal_review.date <', ($addYear + 1911) . '-' . $addMonth .'-1');

      $result = $this->db->get('(SELECT * from (SELECT * FROM seasonal_review ORDER BY no DESC LIMIT 9999)a GROUP BY youth)seasonal_review')->result_array();
      return $result;
    }

    
    public function report_old_case_youth_by_county($county, $year)
    {
      $this->db->select('youth.name as youthName, youth.survey_type, seasonal_review.*');
      $this->db->from('youth');

      $this->db->join('seasonal_review', 'seasonal_review.youth = youth.no', 'left');
      $this->db->join('member', 'member.youth = youth.no');
      $this->db->where('youth.county', $county);
      $this->db->where('member.year', $year-1);
      $this->db->group_by('youth.no');

      $result = $this->db->get()->result_array();
      return $result;
    }


}
