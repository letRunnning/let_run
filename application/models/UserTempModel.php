<?php
class UserTempModel extends CI_Model
{

    /*
     * get columns from schema
     */
    public function get_edited_columns_metadata()
    {
        $sql = "select column_name, column_comment
      from information_schema.columns
      where table_name = 'users_temp' and table_schema = 'yda'; ";
        return $this->db->query($sql)->result();
    }

    /*
     * Get user by id
     * @Return: user object
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->where('usable', 1);
        $result = $this->db->get('users_temp', 1);

        return $result;
    }

    public function get_all()
    {
        $this->db->select('users_temp.*,
      county.name as countyName,
      county.phone as countyPhone,
      county.orgnizer as countyOrgnizer,
      organization.name as organizationName,
      organization.phone as organizationPhone,
      counselor.phone as counselorPhone,
      yda.phone as ydaPhone');

        $this->db->from('users_temp');
        $this->db->join('county', 'county.no = users_temp.county', 'left');
        $this->db->join('organization', 'users_temp.organization = organization.no', 'left');
        $this->db->join('counselor', 'users_temp.counselor = counselor.no', 'left');
        $this->db->join('yda', 'users_temp.yda = yda.no', 'left');

        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_by_yda()
    {
        $this->db->where('yda !=', null);
        $result = $this->db->get('users_temp')->result_array();
        return $result;
    }

    public function get_by_county($county)
    {
        if (empty($county)) {
            $this->db->where('county !=', null);
        }
        $this->db->where('county !=', null);
        $result = $this->db->get('users_temp')->result_array();
        return $result;
    }

    public function get_counselor_by_organization($organization, $county)
    {
        $this->db->select('counselor.no, users_temp.name as userName');
        $this->db->join('counselor', 'counselor.no = users_temp.counselor');
        $this->db->where('users_temp.organization', $organization);
        $this->db->where('users_temp.county', $county);
        $this->db->where('users_temp.counselor!=', null);
        $result = $this->db->get('users_temp')->result_array();
        return $result;
    }

    public function get_counselor_by_county($county)
    {
        $this->db->select('counselor.no, users_temp.name as userName');
        $this->db->join('counselor', 'counselor.no = users_temp.counselor');
        $this->db->where('users_temp.county', $county);
        $this->db->where('users_temp.counselor!=', null);
        $result = $this->db->get('users_temp')->result_array();
        return $result;
    }

    /*
     * check is id exist
     * @Return: Boolean
     */
    public function is_id_exist($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('users_temp', 1)->num_rows() > 0;
    }

    public function is_county_manager_exist($county)
    {
        $this->db->where('county', $county);
        $this->db->where('manager', 1);
        $this->db->where('organization', null);
        $this->db->where('usable', 1);
        return $this->db->get('users_temp', 1)->num_rows() > 0;
    }

    public function is_county_contractor_exist($county)
    {
        $this->db->where('county', $county);
        $this->db->where('manager', 0);
        $this->db->where('organization', null);
        $this->db->where('usable', 1);
        return $this->db->get('users_temp', 1)->num_rows() > 0;
    }

    public function is_organization_manager_exist($county, $organization)
    {
        $this->db->where('county', $county);
        $this->db->where('organization', $organization);
        $this->db->where('manager', 1);
        $this->db->where('usable', 1);
        return $this->db->get('users_temp', 1)->num_rows() > 0;
    }

    public function is_organization_contractor_exist($county, $organization)
    {
        $this->db->where('county', $county);
        $this->db->where('organization', $organization);
        $this->db->where('manager', 0);
        $this->db->where('counselor', null);
        $this->db->where('usable', 1);
        return $this->db->get('users_temp', 1)->num_rows() > 0;
    }

    public function is_counselor_exist($county, $organization)
    {
        $this->db->where('county', $county);
        $this->db->where('organization', $organization);
        $this->db->where('manager', 0);
        $this->db->where('counselor!=', null);
        $this->db->where('usable', 1);
        return $this->db->get('users_temp')->num_rows();
    }

    public function get_by_county_manager($county)
    {

        $this->db->where('county', $county);
        $this->db->where('organization', null);
        $this->db->where('manager', 1);
        $this->db->where('usable', 1);
        $this->db->limit(1);
        return $this->db->get('users_temp')->row();
    }

    function get_latest_county_manager($county) {
      
      $this->db->where('county', $county);
      $this->db->where('organization', null);
      $this->db->where('manager', 1);
      $this->db->order_by('id', 'desc');
      $this->db->limit(1);
      return $this->db->get('users_temp')->row();
    }

    function get_latest_county_contractor($county) {
      
      $this->db->where('county', $county);
      $this->db->where('manager', 0);
      $this->db->where('organization', null);
      $this->db->order_by('id', 'desc');
      $this->db->limit(1);
      return $this->db->get('users_temp')->row();
    }

    function get_latest_organization_manager($county) {
      
      $this->db->where('county', $county);
      $this->db->where('manager', 1);
      $this->db->where('organization!=', null);
      $this->db->order_by('id', 'desc');
      $this->db->limit(1);
      return $this->db->get('users_temp')->row();
    }

    /*
     * create account
     */
    public function create_one($data)
    {
        $data['update_password_time'] = date("Y-m-d H:i:s");
        return ($this->db->insert('users_temp', $data)) ? $this->db->insert_id() : false;
    }

    public function update_by_id($id, $usable)
    {

        $this->usable = $usable;
        $this->db->where('id', $id);
        return $this->db->update('users_temp', $this);
    }

    public function update_user($id, $name, $email, $line)
    {

        $this->name = $name;
        $this->email = $email;
        $this->line = $line;
        $this->db->where('id', $id);
        return $this->db->update('users_temp', $this);
    }

    public function update_password($id, $passwordNew)
    {

        $this->password = password_hash($passwordNew, PASSWORD_DEFAULT);
        $this->db->where('id', $id);
        return $this->db->update('users_temp', $this);
    }

    function get_by_no($no) {
      
      $this->db->where('no', $no);
      return $this->db->get('users_temp')->row();
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
