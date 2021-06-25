<?php
class ProblemModel extends CI_Model {
   /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_question($question) {
    $this->db->where('questionnaire', $question);
 
    return $this->db->get('problem')->result_array();
  }
}