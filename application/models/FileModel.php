<?php
class FileModel extends CI_Model {
  /*
   * create one file
   * @Return: file auto generated no
   */
  function create_one($name, $originalName,$path) {
    $this->name = $name;
    $this->original_name = $originalName;
    $this->path = $path;
    return ($this->db->insert('files', $this)) ?  $this->db->insert_id() : false;
  }
}