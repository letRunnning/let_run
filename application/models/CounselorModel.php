<?php
class CounselorModel extends CI_Model
{
    /*
     * get columns from schema
     */
    public function get_edited_columns_metadata()
    {
        $sql = "select column_name, column_comment
      from information_schema.columns
      where table_name = 'counselor' and table_schema = 'yda'
      and column_name not in ('no'); ";
        return $this->db->query($sql)->result();
    }

    /*
     * create counselor
     */
    public function create_one($data)
    {
        return ($this->db->insert('counselor', $data)) ? $this->db->insert_id() : false;
    }

    /*
     * get one county by id
     * @Return: array of county object
     */

    public function get_by_no($no)
    {
        $this->db->select('counselor.*, users.name as userName');
        $this->db->join('users', 'counselor.no = users.counselor');
        $this->db->where('counselor.no', $no);
        return $this->db->get('counselor')->row();
    }

    public function get_by_organization($yearType, $monthType, $organization) {
      $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
      $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
  
     
      $this->db->select('counselor.*, users.name as userName');
      $this->db->from('counselor');
      $this->db->join('users', 'counselor.no = users.counselor');
      $this->db->where('counselor.duty_date <', ($addYear + 1911) . '-' . $addMonth .'-1');
      $this->db->where('counselor.organization', $organization);
      $this->db->where('users.usable', 1);
  
      $result = $this->db->get()->result_array();
      return $result;
    }

    public function update_one($identification, $gender, $birth, $department, $fax, $phone, $email,
        $householdAddress, $resideAddress, $educationStartDate, $educationCompleteDate,
        $educationSchool, $educationDepartment, $workStartDate, $workCompleteDate,
        $workDepartment, $workPosition, $dutyDate, $qualification, $highestEducation, $affiliatedDepartment, $no) {

        $this->identification = $identification;
        $this->gender = $gender;
        $this->birth = $birth;
        $this->department = $department;
        $this->fax = $fax;
        $this->phone = $phone;
        $this->email = $email;
        $this->household_address = $householdAddress;
        $this->reside_address = $resideAddress;
        $this->education_start_date = $educationStartDate;
        $this->education_complete_date = $educationCompleteDate;
        $this->education_school = $educationSchool;
        $this->education_department = $educationDepartment;
        $this->work_start_date = $workStartDate;
        $this->work_complete_date = $workCompleteDate;
        $this->work_department = $workDepartment;
        $this->work_position = $workPosition;
        $this->duty_date = $dutyDate;
        $this->qualification = $qualification;
        $this->highest_education = $highestEducation;
        $this->affiliated_department = $affiliatedDepartment;
        $this->db->where('counselor.no', $no);
        return $this->db->update('counselor', $this);
    }

    // /*
    //  * create counselor
    //  */
    // function create_one($identification, $gender, $birth, $department, $fax, $phone, $email,
    //   $householdAddress, $resideAddress, $educationStartDate, $educationCompleteDate,
    //   $educationSchool, $educationDepartment, $workStartDate, $workCompleteDate,
    //   $workDepartment, $workPosition, $dutyDate, $qualification) {

    //   $this->identification = $identification;
    //   $this->gender = $gender;
    //   $this->birth = $birth;
    //   $this->department = $department;
    //   $this->fax = $fax;
    //   $this->phone = $phone;
    //   $this->email = $email;
    //   $this->household_address = $householdAddress;
    //   $this->reside_address = $resideAddress;
    //   $this->education_start_date = $educationStartDate;
    //   $this->education_complete_date = $educationCompleteDate;
    //   $this->education_school = $educationSchool;
    //   $this->education_department = $educationDepartment;
    //   $this->work_start_date = $workStartDate;
    //   $this->work_complete_date = $workCompleteDate;
    //   $this->work_department = $workDepartment;
    //   $this->work_position = $workPosition;
    //   $this->duty_date = $dutyDate;
    //   $this->qualification = $qualification;
    //   return ($this->db->insert('counselor', $this)) ?  $this->db->insert_id() : false;
    // }
}
