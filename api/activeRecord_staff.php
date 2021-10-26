<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $s_ID = $data[0]['Staff_ID'];
    // $s_ID = 'S000001';
    
    if($s_ID != ''){
        $sql_id = "SELECT *,`running_activity`.`name`as runName FROM `staff_participation`
        JOIN `work_group` ON `work_group`.`workgroup_ID` = `staff_participation`.`workgroup_ID`
        JOIN `running_activity` on `work_group`.`running_ID` = `running_activity`.`running_ID`
        WHERE `staff_participation`.`staff_ID`='$s_ID'; ";
        $result_qrcode = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");
        $data = array();
        foreach ($result_qrcode as $i){
            $array = array( 
                'Name' => urlencode($i['runName']),
                'Date' => $i['date'],
                'Running_ID' => $i['running_ID'],
                'Workgroup_ID' => $i['workgroup_ID']
            );
            array_push($data, $array);
        }
        echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
    }else{
        echo json_encode(["ans" => "staff_ID can't empty"]);
    }        
    // echo json_encode($data);
?>