<?php
    require_once("dbconnect.php");
    
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data[0]['Email'];
    $captcha = $data[0]['Captcha'];
    // $email = 'letrun05@gmail.com';
    // $captcha = '111111';

    if($email != ''){
        $sql_id = "SELECT `no`, `email`, `captcha`, `time` FROM `temp_email` WHERE `email`='$email';";
        $tmp = mysqli_fetch_assoc(mysqli_query($db,$sql_id));
        if($tmp){
            if($captcha == $tmp['captcha']){
                echo json_encode([["ans" => "yes"]]);
            }else{
                echo json_encode([["ans" => "no"]]);
            }
        }else{
            echo urldecode(json_encode([["ans" => urlencode("信箱輸入錯誤")]]));
        }
    }else{
        echo json_encode([["ans" => "email can't empty"]]);
    }    
?>