<?php
    require_once("dbconnect.php");
    
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data[0]['Email'];
    // $email = 'letrun.05@gmail.com';

    if($email != ''){
        $sql_id = "SELECT member.*,files.name as fileName,files.path FROM `member` join files on `member`.`file_no` = `files`.`no` WHERE `email` = '$email' limit 1";
        $tmp = mysqli_fetch_assoc(mysqli_query($db,$sql_id));
        
        $data = array();
        if($tmp){
            $array = array(
                'Email' => $tmp['email'],
                'Name' => urlencode($tmp['name']),
                'Id_card' => $tmp['id_card'],
                'Member_ID' => $tmp['member_ID'],
                'Photo_code' => urlencode($tmp['fileName']),
                'Photo' => urlencode($tmp['path']),
                'ans' => 'yes'
            );
            array_push($data, $array);
            echo urldecode(json_encode($array, JSON_PRETTY_PRINT));
        }else{
            echo json_encode(["ans" => "no"]);
        }
    }else{
        echo json_encode(["ans" => "email can't empty"]);
    }    
?>