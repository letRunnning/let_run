<?php
class FileModel extends CI_Model {
  /*
   * create one file
   * @Return: file auto generated no
   */
  function create_one($name, $originalName) {
    $this->name = $name;
    $this->original_name = $originalName;
    return ($this->db->insert('files', $this)) ?  $this->db->insert_id() : false;
  }
}