<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        // $running_ID = $data[0]['Running_ID'];
        $running_ID = 'A1';

        if($running_ID != ''){
            $sql_id = "SELECT * FROM `supply_location` WHERE `running_ID` = '$running_ID'";
            $result_member = mysqli_query($con, $sql_id) or die("DB Error: Cannot retrieve message.");
            $data = array();
            foreach ($result_member as $i){
                $array = array( 
                    'Longitude' => $i['longitude'],
                    'Latitude' => $i['latitude'],
                    'Supplies' => urlencode($i['supplies'])
                );
                array_push($data, $array);
            }
            echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        }else{
            echo json_encode(["ans" => "running_ID can't empty"]);
        }    
    } else {
        echo json_encode(["result" => "DataBase connection failed"]);
    }
?>