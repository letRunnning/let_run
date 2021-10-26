<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $m_ID = $data[0]['Email'];
    $password = $data[0]['Password'];

    if($m_ID != '' && $password !=''){
        if (preg_match("/[0-9]+/", $password) && preg_match("/[a-z]+/", $password) && preg_match("/[A-Z]+/", $password) && strlen($password) >= 8) {
            $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE `member` SET `password`='$pwd_hash' WHERE `email`='$m_ID'";
            $result = mysqli_query($db, $sql) ;
            if($result){
                echo json_encode([["ans" => "yes"]]);
            }else{
                echo json_encode([["ans" => "no"]]);
            }
        }else{
            echo urldecode(json_encode([["ans" => urlencode("密碼需包含英文字母大寫、英文字母小寫與數字並長度大於8")]]));
        }
    }else{
        echo json_encode([["ans" => "Email and pwd can't empty"]]);
    }    
?>