<?php
    require_once("dbconnect.php");
    header('Content-Type: application/json; charset=UTF-8');
    $data = json_decode(file_get_contents("php://input"), true);
    $s_ID = $data[0]['staff_ID'];
    $w_ID = $data[0]['workgroup_ID'];

    if ($s_ID!='' && $w_ID!='') {
        $check_SQL = "SELECT * from `staff_participation` where `workgroup_ID` = $w_ID and `staff_ID` = '$s_ID';";
        $result = mysqli_query($db, $check_SQL) or die("DB Error: Cannot retrieve message.");
        if($result){
            echo json_encode(["ans" => "already participate"]);
        }
        else{
            $sql_now_num = "SELECT COUNT(*)as people_now FROM `staff_participation` WHERE `workgroup_ID`= $w_ID";
            $now_num = mysqli_query($db, $sql_now_num) or die("DB Error: Cannot retrieve message.");
            $sql_Max_num = "SELECT maximum_number FROM `work_group` WHERE `workgroup_ID`= $w_ID";
            $Max_num = mysqli_query($db, $sql_Max_num) or die("DB Error: Cannot retrieve message.");
            
            $Max = mysqli_fetch_assoc($Max_num)['maximum_number'];
            $now = mysqli_fetch_assoc($now_num)['people_now'];
            if($Max > $now){
                $sql = "INSERT INTO `staff_participation` (`workgroup_ID`, `staff_ID`, `status`) VALUES
                ('$w_ID', '$s_ID', 1);";
                $result = mysqli_query($db, $sql) ;
                if($result){
                    echo json_encode(["ans" => "yes"]);
                }else{
                    echo json_encode(["ans" => "no"]);
                }
            }else{
                echo json_encode(["ans" => "no"]);
            }
        }
    }else {
        echo json_encode(["ans" => "staff_ID and workgroup_ID can't empty"]);
    }  
?>