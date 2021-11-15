<?php
class GiftModel extends CI_Model {
  /*
   * create one file
   * @Return: file auto generated no
   */
  function create_gift($GID,$gift_name,$groupName,$runNo,$file_no)
    {
        $this->	gift_ID = $GID;
        $this->	group_name = $groupName;
        $this->	gift_name = $gift_name;
        $this->	running_ID = $runNo;
        $this->	file_no = $file_no;

        return ($this->db->insert('gift', $this)) ? $this->db->insert_id() : '';
    }
}