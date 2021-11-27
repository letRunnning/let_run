<?php
class GiftDetailModel extends CI_Model {
    /*
    * create one file
    * @Return: file auto generated no
    */
    function create_gift_detail($GID,$gdetail_size,$gdetail_amount)
    {
        $this->	gift_ID = $GID;
        $this->	gdetail_size = $gdetail_size;
        $this->	gdetail_amount = $gdetail_amount;
        // return ($this->db->insert('gift_detail', $this)) ? $this->db->insert_id() : '';
        return $this->db->insert('gift_detail', $this) ;
    }
    function delete_gift_detail($gift_ID)
    {
        $this->db->where("gift_ID", $gift_ID);
        $this->db->delete("gift_detail");
        return true;
    }
}