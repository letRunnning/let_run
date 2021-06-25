<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

if (!function_exists('send_email')) {
    function send_email($recipient, $title, $content)
    {
        $CI = &get_instance();
        $CI->load->library('email');
        $CI->email->from('a2976928@gmail.com', '教育部青年發展署');
        $CI->email->to($recipient);
        $CI->email->subject($title);
        $CI->email->message($content);
        $CI->email->send();
    }
}

if (!function_exists('api_send_email')) {
  function api_send_email($data)
  {
    $url = 'https://yda.unlla.org/api/tt';
    /* Init cURL resource */
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
  }
}

function api_send_email_temp($email, $title, $content)
  {
    $data = array(
      'title'      => $title,
      'email' =>  $email,
      'content'    => $content
    );
    $url = 'https://yda.unlla.org/api/tt';
    /* Init cURL resource */
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
  }

function email_title_messager() {
  $title = '【教育部青年發展署雙青計畫行政系統】最新消息通知';
  return $title;
}

function email_content_messager($name, $type, $content) {
  $mailContent = '<p>' . $name . ' 君 您好:</p>'
    . '<p>類別 : ' . $type . '</p>'
    . '<p>內容 :' . $content . '</p>'
    . '<p>祝 平安快樂</p><p></p>'
    . '<p>教育部青年發展署雙青計畫行政系統</p>'
    . '<p>' . date('Y-m-d') . '</p>'
    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

  return $mailContent;
}

function email_title_reset_password() {
  $title = '【教育部青年發展署雙青計畫行政系統】重設密碼通知';
  return $title;
}

function email_content_reset_password($name, $id) {
  $mailContent = '<p>' . $name . ' 君 您好:</p>'
    . '<p>請點擊下方連結重設密碼</p>'
    . '<p><a href="https://icarey.yda.gov.tw/user/forget_password_mail/' . $id . '" target="重設密碼" title="重設密碼">點我重設密碼</a></p>'
    . '<p>點擊完連結後您的密碼將被設置為 : 000000</p><p></p>'
    . '<p>登入後請先更改密碼，並留意須遵守設定限制</p>'
    . '<p>祝 平安快樂</p><p></p>'
    . '<p>教育部青年發展署雙青計畫行政系統</p>'
    . '<p>' . date('Y-m-d') . '</p>'
      . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

  return $mailContent;
}

function email_title_oldcase_alert($countyName) {
  $title = '【教育部青年發展署雙青計畫行政系統】' . $countyName . '前一年開案人數占比高於兩成通知';
  return $title;
}

function email_content_oldcase_alert($name, $countyName, $oldCaseMember, $newCaseMember, $monthType) {
  $mailContent = '<p>' . $name . ' 君 您好:</p>'
    . '<p>' . $countyName . '於' . (date('Y')-1911) . '年' . $monthType . '月中前一年開案人數占比高於兩成，</p>'
    . '<p>前一年度持續輔導人數 :' . $oldCaseMember . '</p>'
    . '<p>本年度新開案個案人數 :' . $newCaseMember . '</p>'
    . '<p>前一年度持續輔導人數占比 :' . $oldCaseMember / ($oldCaseMember + $newCaseMember)  . '</p>'
    . '<p>祝 平安快樂</p><p></p>'
    . '<p>教育部青年發展署雙青計畫行政系統</p>'
    . '<p>' . date('Y-m-d') . '</p>'
    . '<p><b>(本信為系統自動寄發，回信請mail至a2976928@gmail。)</b></p>';

  return $mailContent;
}
