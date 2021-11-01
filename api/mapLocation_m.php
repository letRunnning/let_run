<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $Member_ID = $data[0]['Member_ID'];
    $Running_ID = $data[0]['Running_ID'];
    $Latitude = $data[0]['Latitude'];
    $Longitude = $data[0]['Longitude'];
    $RegisID = $Running_ID.$Member_ID;
    // $Member_ID = 'M000001';
    // $Running_ID = 'A1';
    // $Latitude = '111';
    // $Longitude = '222';

    $sql = "select group_name from registration where registration.registration_ID = '$RegisID';";
    $row = mysqli_fetch_assoc(mysqli_query($db, $sql));
    $Gname = $row['group_name'];
    
    $sql_1 = "SELECT start_time,end_time FROM `running_group` where running_ID='$Running_ID' and group_name = '$Gname' limit 1;";
    $result = mysqli_query($db, $sql_1);
    $row = mysqli_fetch_assoc($result);

    if(time() >= $row['start_time'] && time() <= $row['end_time']){
        if($Member_ID != '' && $Running_ID != '' && $Latitude != '' && $Longitude != ''){
            $sql_id = "INSERT INTO `location`(`member_ID`, `running_ID`, `pass_time`, `pass_longitude`, `pass_latitude`, `beacon_ID`) 
            VALUES ('$Member_ID','$Running_ID',now(),'$Latitude','$Longitude',null)";
            $result = mysqli_query($db, $sql_id) or die("DB Error: Cannot retrieve message.");

            if($result){
                echo json_encode(["ans" => "yes"]);
            }else{
                echo json_encode(["ans" => "no"]);
            }
        
        }else{
            echo json_encode(["ans" => "Member_ID,Running_ID,Latitude,Longitude can't empty"]);
        }  
    }
    // else {
    //     echo json_encode(["result" => "time"]);
    // }    
?>