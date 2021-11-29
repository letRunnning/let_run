<?php
class UserModel extends CI_Model
{
    /*
     * Get user by id
     * @Return: user object
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('users', 1);

        return $result;
    }
    public function get_member_by_runNo($rid)
    {
        $this->db->select('registration.*,member.name as mName,`files`.name as fileName,files.path');
        $this->db->join('member', '`registration`.`member_ID`=`member`.`member_ID`', 'left');
        $this->db->join('files', '`files`.`no` = `member`.`file_no`', 'left');
        $this->db->where('running_ID', $rid);
        $result = $this->db->get('registration')->result_array();
        return $result;
    }
    public function get_member_info()
    {
        $result = $this->db->get('member')->result_array();
        return $result;
    }
    public function get_staff_info()
    {
        $result = $this->db->get('staff')->result_array();
        return $result;
    } 
    public function get_member_by_id($mid)
    {
        $this->db->select('member.*,f.name as photo_name,f.no as no');
        $this->db->where('member_ID', $mid);
        $this->db->join('files as f', 'member.file_no = f.no', 'left');
        $result = $this->db->get('member',1);
        return $result->row();
    }
    
    /*
     * get columns from schema
     */
    public function get_edited_columns_metadata()
    {
        $sql = "select column_name, column_comment
      from information_schema.columns
      where table_name = 'users' and table_schema = 'yda'; ";
        return $this->db->query($sql)->result();
    }

    public function get_name_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->where('usable', 1);
        $result = $this->db->get('users', 1)->row();

        return $result;
    }

    public function get_by_id_for_update_usable($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('users', 1)->row();

        return $result;
    }

    public function get_all()
    {
        $this->db->select('users.*,
      county.name as countyName,
      county.phone as countyPhone,
      county.orgnizer as countyOrgnizer,
      organization.name as organizationName,
      organization.phone as organizationPhone,
      counselor.phone as counselorPhone,
      yda.phone as ydaPhone');

        $this->db->from('users');
        $this->db->join('county', 'county.no = users.county', 'left');
        $this->db->join('organization', 'users.organization = organization.no', 'left');
        $this->db->join('counselor', 'users.counselor = counselor.no', 'left');
        $this->db->join('yda', 'users.yda = yda.no', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_by_yda()
    {
        $this->db->where('yda !=', null);
        $this->db->where('manager', 1);
        $result = $this->db->get('users')->result_array();
        return $result;
    }

    public function get_by_county($county)
    {
        if (empty($county)) {
            $this->db->where('county !=', null);
        }
        $this->db->where('county !=', null);
        $result = $this->db->get('users')->result_array();
        return $result;
    }

    public function get_counselor_by_organization($organization, $county)
    {
        $this->db->select('counselor.no, users.name as userName');
        $this->db->join('counselor', 'counselor.no = users.counselor');
        $this->db->where('users.organization', $organization);
        $this->db->where('users.county', $county);
        $this->db->where('users.usable', 1);
        $this->db->where('users.counselor!=', null);
        $result = $this->db->get('users')->result_array();
        return $result;
    }

    public function get_counselor_by_county($county)
    {
        $this->db->select('counselor.no, users.name as userName');
        $this->db->join('counselor', 'counselor.no = users.counselor');
        $this->db->where('users.county', $county);
        $this->db->where('users.counselor!=', null);
        $result = $this->db->get('users')->result_array();
        return $result;
    }

    public function get_counselor_detail_by_county($county, $yearType, $monthType)
    {
        $addMonth = ($monthType + 1 > 12) ? 1 : $monthType+1 ;
        $addYear =  ($monthType + 1 > 12) ? $yearType + 1 : $yearType ;
        $this->db->select('counselor.*, users.name as userName');
        $this->db->join('counselor', 'counselor.no = users.counselor');
        $this->db->where('users.county', $county);
        $this->db->where('users.counselor!=', null);
        $this->db->where('users.usable', 1);
        $this->db->where('counselor.duty_date <', ($addYear + 1911) . '-' . $addMonth .'-1');
        $result = $this->db->get('users')->result_array();
        return $result;
    }

    /*
     * check is id exist
     * @Return: Boolean
     */
    public function is_id_exist($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('users', 1)->num_rows() > 0;
    }

    public function is_county_manager_exist($county)
    {
        $this->db->where('county', $county);
        $this->db->where('manager', 1);
        $this->db->where('organization', null);
        $this->db->where('usable', 1);
        return $this->db->get('users', 1)->num_rows() > 0;
    }

    public function is_county_contractor_exist($county)
    {
        $this->db->where('county', $county);
        $this->db->where('manager', 0);
        $this->db->where('organization', null);
        $this->db->where('usable', 1);
        return $this->db->get('users', 1)->num_rows() > 0;
    }

    public function is_organization_manager_exist($county, $organization)
    {
        $this->db->where('county', $county);
        $this->db->where('organization', $organization);
        $this->db->where('manager', 1);
        $this->db->where('usable', 1);
        return $this->db->get('users', 1)->num_rows() > 0;
    }

    public function is_organization_contractor_exist($county, $organization)
    {
        $this->db->where('county', $county);
        $this->db->where('organization', $organization);
        $this->db->where('manager', 0);
        $this->db->where('counselor', null);
        $this->db->where('usable', 1);
        return $this->db->get('users', 1)->num_rows() > 0;
    }

    public function is_counselor_exist($county, $organization)
    {
        $this->db->where('county', $county);
        $this->db->where('organization', $organization);
        $this->db->where('manager', 0);
        $this->db->where('counselor!=', null);
        $this->db->where('usable', 1);
        return $this->db->get('users')->num_rows();
    }

    public function get_by_yda_row()
    {

        $this->db->where('yda!=', null);
        $this->db->where('manager', 0);
        $this->db->where('usable', 1);
        $this->db->order_by("id", "asc");
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_by_counselor($counselor)
    {

        $this->db->where('counselor', $counselor);
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_by_county_manager($county)
    {

        $this->db->where('county', $county);
        $this->db->where('organization', null);
        $this->db->where('manager', 1);
        $this->db->where('usable', 1);
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_by_county_contractor($county)
    {

        $this->db->where('county', $county);
        $this->db->where('organization', null);
        $this->db->where('manager', 0);
        $this->db->where('usable', 1);
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_by_organization_manager($organization)
    {
        $this->db->where('organization', $organization);
        $this->db->where('manager', 1);
        $this->db->where('usable', 1);
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_by_organization_contractor($organization)
    {
        $this->db->where('organization', $organization);
        $this->db->where('manager', 0);
        $this->db->where('counselor', null);
        $this->db->where('usable', 1);
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_latest_yda_support()
    {

        $this->db->where('yda!=', null);
        $this->db->where('manager', 0);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_latest_county_manager($county)
    {

        $this->db->where('county', $county);
        $this->db->where('organization', null);
        $this->db->where('manager', 1);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_latest_county_contractor($county)
    {

        $this->db->where('county', $county);
        $this->db->where('manager', 0);
        $this->db->where('organization', null);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_latest_organization_manager($county)
    {

        $this->db->where('county', $county);
        $this->db->where('manager', 1);
        $this->db->where('organization!=', null);
        $this->db->where('counselor', null);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    public function get_latest_organization_contractor($county)
    {

        $this->db->where('county', $county);
        $this->db->where('manager', 0);
        $this->db->where('organization!=', null);
        $this->db->where('counselor', null);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get('users')->row();
    }

    /*
     * create account
     */
    public function create_one($data)
    {
      $data['update_password_time'] = date("Y-m-d H:i:s");
      return $this->db->insert('users', $data);
    }

    public function update_by_id($id, $usable)
    {

        $this->usable = $usable;
        $this->db->where('id', $id);
        return $this->db->update('users', $this);
    }

    public function update_login_fail_time_by_id($id)
    {

        $this->login_fail_time = date("Y-m-d H:i:s");
        $this->db->where('id', $id);
        return $this->db->update('users', $this);
    }

    public function update_user($id, $name, $email, $line, $officePhone)
    {

        $this->name = $name;
        $this->email = $email;
        $this->line = $line;
        $this->office_phone = $officePhone;
        $this->db->where('id', $id);
        return $this->db->update('users', $this);
    }

    public function update_password($id, $passwordNew, $last_password_one, $last_password_two, $last_password_three)
    {
        $this->update_password_time = date("Y-m-d H:i:s");
        $this->last_password_one = $last_password_one;
        $this->last_password_two = $last_password_two;
        $this->last_password_three = $last_password_three;
        $this->password = password_hash($passwordNew, PASSWORD_DEFAULT);
        $this->db->where('id', $id);
        return $this->db->update('users', $this);
    }

    function get_yda_user() {
      $this->db->where('yda!=', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }

    function get_county_user() {
      $this->db->where('county!=', null);
      $this->db->where('organization', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }

    function get_organization_user() {
      $this->db->where('organization!=', null);
      $this->db->where('counselor', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }

    function get_counselor_user() {
      $this->db->where('counselor!=', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }

    function get_county_user_by_county($county) {
      $this->db->where('county', $county);
      $this->db->where('organization', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }

    function get_organization_user_by_county($county) {
      $this->db->where('county', $county);
      $this->db->where('organization!=', null);
      $this->db->where('counselor', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }

    function get_counselor_user_by_county($county) {
      $this->db->where('county', $county);
      $this->db->where('counselor!=', null);
      $this->db->where('usable', 1);
      $result = $this->db->get('users')->result_array();
      return $result;
    }



    // /*
    //  * create account
    //  */
    // function create_account($id, $password, $name, $manager=0, $yda=null,
    //   $county=null, $organization=null, $counselor=null, $youth=null) {

    //   $this->id = $id;
    //   $this->password = password_hash($password, PASSWORD_DEFAULT);
    //   $this->name = $name;
    //   $this->manager = $manager;
    //   $this->yda = $yda;
    //   $this->county = $county;
    //   $this->organization = $organization;
    //   $this->counselor = $counselor;
    //   $this->youth = $youth;
    //   return $this->db->insert('users', $this);
    // }

}
