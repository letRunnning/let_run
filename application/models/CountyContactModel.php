<?php
class CountyContactModel extends CI_Model {
  /*
   * create county
   */
  function create_one($county, $name, $phone, $orgnizer, $email, $title) {
    $this->county = $county;
    $this->name = $name;
    $this->phone = $phone;
    $this->orgnizer = $orgnizer;
    $this->email = $email;
    $this->title = $title;
    return ($this->db->insert('county_contact', $this)) ? $this->db->insert_id() : false;
  }

  function update_one($county, $name, $phone, $orgnizer, $email, $title, $no) {
    $this->county = $county;
    $this->name = $name;
    $this->phone = $phone;
    $this->orgnizer = $orgnizer;
    $this->email = $email;
    $this->title = $title;
    $this->db->where('no', $no);
    return $this->db->update('county_contact', $this);
  }

  /*
   * get all county
   * @Return: array of county object
   */
  function get_all() {
    $this->db->order_by("county", "asc");
    return $this->db->get('county_contact')->result_array();
  }

  /*
   * get one county by id
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    return $this->db->get('county_contact')->row();
  }

  function get_by_county($county) {
    $this->db->where('county', $county);
    return $this->db->get('county_contact')->result_array();
  }
}