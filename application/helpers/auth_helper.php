<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('valid_roles'))
{
  function valid_roles($accept_roles = array(1, 2))
  {
    $CI = & get_instance();
    $passport = $CI->session->userdata('passport');
    if(empty($passport)) redirect('user/login');
    $current_role = $passport['role'];
    if(!in_array($current_role, $accept_roles)) redirect('user/login');
  }
}

if(!function_exists('check_youth')) {
  function check_youth($youth = null, $county = null) {
    if($youth && $county) {
      $CI = get_instance();
      $CI->load->model('YouthModel');

      $youths = $CI->YouthModel->get_by_no($youth);
      if($county == $youths->county) return true;
      else return redirect('user/login');
    }
  }
}

if(!function_exists('check_member')) {
  function check_member($member = null, $county = null) {
    if($member && $county) {
      $CI = get_instance();
      $CI->load->model('MemberModel');

      $members = $CI->MemberModel->get_by_no($member);
      if($county == $members->county) return true;
      else return redirect('user/login');
    }
  }
}