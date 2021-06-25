<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class QueryLogger
{
  private $ci;
  private $types;

  public function __construct()
  {
    $this->ci =& get_instance();
    // $this->types = array([
    //   'insert',
    //   'update',
    //   'delete'
    // ]);
  }

  public function save()
  {
    $user = $this->ci->session->userdata('passport') ? $this->ci->session->userdata('passport')['id'] : 'unknown';
  
    foreach ($this->ci->db->queries as $query) {
      $this->ci->db->insert('db_log', [
        'user' => $user,
        'time' => date('Y-m-d H:i:s'),
        'function' => $this->ci->router->fetch_class().'/'.$this->ci->router->fetch_method(),
        'command' => $query
      ]);
    }
  }
}