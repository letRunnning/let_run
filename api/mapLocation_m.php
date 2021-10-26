<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $Member_ID = $data[0]['Member_ID'];
    $Running_ID = $data[0]['Running_ID'];
    $Latitude = $data[0]['Latitude'];
    $Longitude = $data[0]['Longitude'];

    if($Member_ID != '' && $Running_ID != '' && $Latitude != '' && $Longitude != ''){
        $sql_id = "INSERT INTO `location`(`member_ID`, `running_ID`, `pass_time`, `pass_longitude`, `pass_latitude`, `beacon_ID`) 
        VALUES ('$running_ID','$Running_ID',now(),'$Latitude','$Longitude',null)";
        $result = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");

        if($result){
            echo json_encode(["ans" => "yes"]);
        }else{
            echo json_encode(["ans" => "no"]);
        }
    
    }else{
        echo json_encode(["ans" => "Member_ID,Running_ID,Latitude,Longitude can't empty"]);
    }    
?>