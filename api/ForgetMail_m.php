<?php
    require_once("dbconnect.php");
    
    header("Content-Type: application/json; charset=UTF-8");
    // $data = json_decode(file_get_contents("php://input"), true);
    // $email = $data[0]['Email'];
    $email = 'letrun.05@gmail.com';

    if($email != ''){
        $sql_id = "SELECT * FROM `member` 
        WHERE `email` = '$email' limit 1";
        $tmp = mysqli_fetch_assoc(mysqli_query($db,$sql_id));
        $name = $tmp['name'];
        $result = mysqli_query($db, $sql_id);
        if($result){
            $temp = rand(1111111,9999999);
            $sql = "UPDATE `member` SET `captcha`='$temp' WHERE `email`='$email'";
            $result_second = mysqli_query($db, $sql) ;
            if($result_second){
                // $name = 'service';
                // $email = 'letrun05@gmail.com';
                $subject = '【No1路跑服務有限公司】忘記密碼-驗證碼通知信';
                $body = '<h3>'.$name.'您好，</h3><sapn>歡迎您加入No1路跑服務有限公司，您的驗證碼為：<span style="font-weight: bold">'.$temp.'</span></sapn><br>' . date('Y-m-d H:i:s');

                mail($email, $subject, $body,"From:Let's run\nContent-Type:text/html");
                echo json_encode([["ans" => "Success"]]);
            }else{
                echo json_encode([["ans" => "NoSuccess"]]);
            }
        }else{
            echo json_encode([["ans" => "not exist"]]);
        }
    }else{
        echo json_encode([["ans" => "email can't empty"]]);
    }    
?>