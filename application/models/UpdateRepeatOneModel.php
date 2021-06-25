<?php
class UpdateRepeatOneModel extends CI_Model
{
  public function update_by_youth($county, $no) {

    $this->county = 23;
  
    $this->db->where('no', $no);
    return $this->db->update('youth', $this);
  }
}