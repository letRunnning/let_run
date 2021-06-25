<?php
class QuestionnaireModel extends CI_Model {
   /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    $this->db->where('year', date("Y")-1911);
    return $this->db->get('questionnaire', 1)->row();
  }

  function get_all_question($name) 
  {
    $this->db->select('problem.*, questionnaire.no as questionnaireNo');
    $this->db->join('problem', 'questionnaire.no = problem.questionnaire');
    $this->db->where('questionnaire.name', $name);
    $result = $this->db->get('questionnaire')->result_array();
    return $result;
  }
}