<?php
    require_once("dbconnect.php");

    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $running_ID = $data[0]['Running_ID'];
    $m_ID = $data[0]['Member_ID'];
    // $running_ID = 'A1';
    // $m_ID = 'M000004';

    if($running_ID != '' && $m_ID != ''){
        $sql_group = "SELECT * FROM `registration` 
        WHERE `member_ID`= '$m_ID' and `running_ID` = '$running_ID' limit 1";
        $tmp = mysqli_fetch_assoc(mysqli_query($db,$sql_group));
        $group_name = $tmp['group_name'];
        $sql_id = "SELECT * FROM `route_detail` WHERE `running_ID` = '$running_ID' and `group_name` = '$group_name'";
        $result_routes = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
        $data = array();
        foreach ($result_routes as $i){
            $array = array( 
                'Longitude' => $i['longitude'],
                'Latitude' => $i['latitude'],
                'Detail' => urlencode($i['detail'])
            );
            array_push($data, $array);
        }
        echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
    
    }else{
        echo json_encode(["ans" => "Running_ID can't empty"]);
    }  
?>