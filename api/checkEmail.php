<?php
    require_once("dbconnect.php");
    
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data[0]['Email'];
    // $email = 'letrun.05@gmail.com';

    if($email != ''){
        $temp = rand(1111111,9999999);
        $sql_id = "INSERT INTO `temp_email`(`email`, `captcha`, `time`) VALUES($email,'$temp',now())";
        $result = mysqli_query($db, $sql_id);
        if($result){
            $subject = "【Let's run路跑服務有限公司】驗證信箱通知信";
            $body = '<h3>'.$name."您好，</h3><sapn>歡迎您加入Let's run路跑服務有限公司，您的驗證碼為：<span style='font-weight: bold'>".$temp.'</span></sapn><br>' . date('Y-m-d H:i:s');
            // mail('letrun.05@gmail.com', $subject, $body,"From:Let's run\nContent-Type:text/html");
            mail($email, $subject, $body,"From:Let's run\nContent-Type:text/html");
            echo json_encode([["ans" => "yes"]]);
        }else{
            echo json_encode([["ans" => "no"]]);
        }
    }else{
        echo json_encode([["ans" => "email can't empty"]]);
    }    
?>