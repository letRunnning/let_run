<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        $run_ID = $data[0]['running_ID'];
        $regis_ID = $data[0]['registration_ID'];
        // $run_ID = 'A1';
        // $regis_ID = 'A1M000001';
        
        if($run_ID != ''&& $regis_ID !=''){
            $sql_id = "SELECT * FROM `registration` JOIN `running_activity` ON `registration`.`running_ID` = `running_activity`.`running_ID`
            WHERE `registration_ID` = '$regis_ID' and `registration`.`running_ID`='$run_ID'";
            $result_qrcode = mysqli_query($con, $sql_id) or die("DB Error: Cannot retrieve message.");
            $data = array();
            foreach ($result_qrcode as $i){
                $array = array( 
                    'name' => urlencode($i['name']),
                    'group_name' => urlencode($i['group_name']),
                    'place' => urlencode($i['place']),
                    'time' => $i['time']
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