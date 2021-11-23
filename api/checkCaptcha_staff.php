<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data[0]['Email'];
    $sent_captcha = $data[0]['Captcha'];
    // $email = 'letrun.05@gmail.com';
    // $sent_captcha ='8185405';

    if($email != '' && $sent_captcha != ''){
        $sql_id = "SELECT staff.captcha FROM `staff` 
        WHERE `email` = '$email' limit 1";
        $tmp = mysqli_fetch_assoc(mysqli_query($db,$sql_id));
        $vertify_captcha = $tmp['captcha'];
        if ($vertify_captcha){
            if($vertify_captcha == $sent_captcha){
                echo json_encode([["ans" => "yes"]]);
            }else{
                echo json_encode([["ans" => "no"]]);
            }
        }else{
            echo json_encode([["ans" => "empty"]]);
        }
    }else{
        echo json_encode([["ans" => "Email and Captcha can't empty"]]);
    }    
?>