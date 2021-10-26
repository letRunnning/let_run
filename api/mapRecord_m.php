<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $m_ID = $data[0]['Member_ID'];
    // $m_ID = 'M000001';

    if($m_ID != ''){
        $sql_id = "SELECT *,`running_activity`.`running_ID`as RunID FROM `registration` 
        JOIN `running_activity` ON `registration`.`running_ID` = `running_activity`.`running_ID` 
        WHERE `member_ID` =  '$m_ID'";
        $result_member = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
        $data = array();
        foreach ($result_member as $i){
            $array = array( 
                'Name' => urlencode($i['name']),
                'Running_ID' => $i['RunID']
            );
            array_push($data, $array);
        }
        echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
    }else{
        echo json_encode(["ans" => "Member_ID can't empty"]);
    }    
?>