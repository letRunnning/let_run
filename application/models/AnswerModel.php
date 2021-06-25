<?php
class AnswerModel extends CI_Model {
   /*
   * get project by county
   * @Return: array of county object
   */
  function get_by_no($no) {
    $this->db->where('no', $no);
    $this->db->where('year', date("Y")-1911);
    return $this->db->get('questionnaire', 1)->row();
  }

  function get_answer_by_id($name, $id) 
  {
    $this->db->select('problem.*, answer.answer, questionnaire.no as questionnaireNo');
    $this->db->join('problem', 'answer.problem = problem.no');
    $this->db->join('questionnaire', 'answer.questionnaire = questionnaire.no');
    $this->db->where('questionnaire.name', $name);
    $this->db->where('answer.user_id', $id);
    $result = $this->db->get('answer')->result_array();
    return $result;
  }

  function create_one($questionnaire, $problem, $answer, $id) {

    $this->user_id = $id;
    $this->questionnaire = $questionnaire;
    $this->problem = $problem;
    $this->answer = $answer;
    $this->time = date("Y-m-d H:i:s");
   
    return $this->db->insert('answer', $this);
  }

  function update_one($id) {

    $this->user_id = null;

    $this->time = date("Y-m-d H:i:s");
    $this->db->where('user_id', $id);
    return $this->db->update('answer', $this);
  }


}