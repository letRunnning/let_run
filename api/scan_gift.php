<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        // $s_ID = $data[0]['staff_ID'];
        // $r_ID = $data[0]['registration_ID'];
        // $time = $data[0]['time'];
        $s_ID = 'S000001';
        $r_ID = 'A1M000003';
        $time = '2021-08-09 24:05';
        
        if($r_ID != '' && $s_ID != '' && $time !=''){
            $sql = "INSERT INTO `redeem`(`registration_ID`, `staff_ID`, `redeem_time`) 
                VALUES ('$r_ID','$s_ID','$time')";
                $result = mysqli_query($con, $sql);       
                if($result){
                    echo json_encode(["ans" => "yes"]);
                }else{
                    echo json_encode(["ans" => "no"]);
                }
        }else{
            echo json_encode(["ans" => "staff_ID and registration_ID and time can't empty"]);
        }        
        // echo json_encode($data);
    } else {
        echo json_encode(["ans" => "DataBase connection failed"]);
    }
?>