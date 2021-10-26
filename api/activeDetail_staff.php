<?php
    require_once("dbconnect.php");
    header('Content-Type: application/json; charset=UTF-8');
    $data = json_decode(file_get_contents("php://input"), true);
    $r_ID = $data[0]['running_ID'];

    if ($r_ID!='') {
        $sql_id = "SELECT * from work_group WHERE `running_ID` =  '$r_ID'";
        $group = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
        $data = array();
        foreach ($group as $i){
            $array = array( 
                'running_ID' => $i['running_ID'],
                'workgroup_ID' => $i['workgroup_ID'],
                'name' => urlencode($i['name']),
                'assemble_time' => $i['assembletime'],
                'end_time' => $i['endtime'],
                'assemble_place' => urlencode($i['assembleplace']),
                'maximum_number' => $i['maximum_number']
            );
            array_push($data, $array);
        }
        echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
    }else {
        echo json_encode(["ans" => "running_ID can't empty"]);
    } 
?>