<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        $run_ID = $data[0]['running_ID'];
        $work_ID = $data[0]['workgroup_ID'];
        $s_ID = $data[0]['Staff_ID'];
        // $run_ID = 'A1';
        // $work_ID = 1;
        // $s_ID = 'S000001';
        
        if($run_ID != '' && $work_ID !='' && $s_ID!=''){
            $sql_id = "SELECT *,`running_activity`.`name`as runName,`work_group`.`name`as groupName 
            FROM `staff_participation` 
            JOIN `work_group` ON `work_group`.`workgroup_ID` = `staff_participation`.`workgroup_ID` 
            JOIN `running_activity` on `work_group`.`running_ID` = `running_activity`.`running_ID` 
            WHERE `staff_participation`.`staff_ID`='$s_ID' 
            AND `work_group`.`workgroup_ID`=$work_ID AND `work_group`.`running_ID`='$run_ID'";
            $result_qrcode = mysqli_query($con, $sql_id) or die("DB Error: Cannot retrieve message.");
            $data = array();
            foreach ($result_qrcode as $i){
                $array = array( 
                    'Name' => urlencode($i['runName']),
                    'Work_name' => urlencode($i['groupName']),
                    'Assembletime' => $i['assembletime'],
                    'Assembleplace' => urlencode($i['assembleplace']),
                    'Leader' => urlencode($i['leader']),
                    'Line' => urlencode($i['line'])
                );
                array_push($data, $array);
            }
            echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        }else{
            echo json_encode(["ans" => "regis_ID and run_ID can't empty"]);
        }        
        // echo json_encode($data);
    } else {
        echo json_encode(["ans" => "DataBase connection failed"]);
    }
?>