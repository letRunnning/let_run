<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $m_ID = $data[0]['staff_ID'];
    // $m_ID = 'S000007';
    $sql_id = "SELECT `staff`.* ,`files`.name as fileName 
    FROM `staff` LEFT JOIN `files` ON `files`.`no` = `staff`.`file_no` WHERE `staff_ID` =  '$m_ID'";
    $result_staff = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
    $data = array();
    foreach ($result_staff as $i){
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
            'Photo' =>$tmpName,
            'Line_ID' => $i['lineid']
        );
        array_push($data, $array);
    }
    echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
    
    // echo json_encode($data);
?>