<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $run_ID = $data[0]['Running_ID'];
    $regis_ID = $data[0]['Registration_ID'];
    // $run_ID = 'A1';
    // $regis_ID = 'A1M000004';
    
    if($run_ID != ''&& $regis_ID !=''){
        $sql_id="SELECT `running_activity`.`name`as runName,registration.group_name as groupName
        ,`running_group`.`place` as groupPlace,running_group.time as groupTime FROM `registration` 
        JOIN `running_group`ON `running_group`.`running_ID`=`registration`.`running_ID` 
        AND `running_group`.`group_name`=`registration`.`group_name` 
        JOIN `running_activity` ON `registration`.`running_ID`= `running_activity`.`running_ID` 
        WHERE `registration_ID` = '$regis_ID' and `registration`.`running_ID`='$run_ID'";
        $result_qrcode = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
        if($result_qrcode->num_rows!=0){
            $data = array();
            foreach ($result_qrcode as $i){
                $array = array( 
                    'Name' => urlencode($i['runName']),
                    'Group_name' => urlencode($i['groupName']),
                    'Place' => urlencode($i['groupPlace']),
                    'Time' => $i['groupTime']
                );
                array_push($data, $array);
            }
            echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        }else{
            echo json_encode(["ans" => "this registration_ID hasn't regist."]);
        }
    }else{
        echo json_encode(["ans" => "regis_ID and run_ID can't empty"]);
    }        
        // echo json_encode($data);
?>