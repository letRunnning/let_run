<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $m_ID = $data[0]['member_ID'];
    // $m_ID = 'M000004';
    $sql_id = "SELECT `member`.* ,`files`.name as fileName 
    FROM `member` LEFT JOIN `files` ON `files`.`no` = `member`.`file_no` WHERE `member_ID` =  '$m_ID'";
    $result_member = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
    $data = array();
    foreach ($result_member as $i){
        $tmpName = $i['fileName'];
        $array = array( 
            'Name' => urlencode($i['name']),
            'Id_card' => $i['id_card'],
            'Email' => $i['email'],
            'Phone' => $i['phone'],
            'Birthday' => $i['birthday'],
            'Address' => urlencode($i['address']),
            'Contact_name' => urlencode($i['contact_name']),
            'Contact_phone' => $i['contact_phone'],
            'Relation' => urlencode($i['relation']),
            'Photo' =>$tmpName
        );
        array_push($data, $array);
    }
    echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
    
    // echo json_encode($data);
?>