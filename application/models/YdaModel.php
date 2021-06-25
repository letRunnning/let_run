<?php
class YdaModel extends CI_Model
{

    /*
     * get columns from schema
     */
    public function get_edited_columns_metadata()
    {
        $sql = "select column_name, column_comment
      from information_schema.columns
      where table_name = 'yda' and table_schema = 'yda'
      and column_name not in ('no'); ";
        return $this->db->query($sql)->result();
    }

    /*
     * create yda
     */
    public function create_one($data)
    {
        return ($this->db->insert('yda', $data)) ? $this->db->insert_id() : false;
    }

    public function update_one($phone, $no)
    {
      $this->phone = $phone;
      $this->db->where('yda.no', $no);
      return $this->db->update('yda', $this);
    }

    public function get_by_no($no)
    {
        $this->db->select('yda.*');
        $this->db->where('no', $no);
        $result = $this->db->get('yda', 1)->row();
        return $result;
    }

    // /*
    //  * create one yda contractor
    //  * @Return: yda auto generated no
    //  */
    // function create_one($phone) {
    //   $this->phone = $phone;
    //   return ($this->db->insert('yda', $this)) ?  $this->db->insert_id() : false;
    // }
}
