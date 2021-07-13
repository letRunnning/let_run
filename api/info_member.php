<?php
    $con = mysqli_connect("localhost", "id17225959_user", 'zS/-\q?JOg+Yvn1$', "id17225959_running");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        $m_ID = $data[0]['member_ID'];
        $sql_id = "SELECT * FROM `member` WHERE `member_ID` = '$m_ID'";
        $result_member = mysqli_query($con, $sql_id) or die("DB Error: Cannot retrieve message.");
        $data = array();
        foreach ($result_member as $i){
            $array = array( 
                'Name' => urlencode($i['name']),
                'Id_card' => $i['id_card'],
                'password' => $i['password'],
                'Email' => $i['email'],
                'Phone' => $i['phone'],
                'Birthday' => $i['birthday'],
                'Address' => urlencode($i['address']),
                'Contact_name' => urlencode($i['contact_name']),
                'Contact_phone' => $i['contact_phone'],
                'Relation' => urlencode($i['relation']),
                'File_no' => $i['file_no']
            );
            array_push($data, $array);
        }
        echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        
        // echo json_encode($data);
    } else {
        echo json_encode(["result" => "DataBase connection failed"]);
    }
?>