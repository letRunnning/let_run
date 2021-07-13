<?php
    $con = mysqli_connect("localhost", "id17225959_user", 'zS/-\q?JOg+Yvn1$', "id17225959_running");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");

        $sql_runs = "SELECT *,`running_activity`.`name` as `runName`,`files`.name as fileName FROM `running_activity` JOIN `files` ON `files`.`no` = `running_activity`.`file_no`";
        $result_runs = mysqli_query($con, $sql_runs) or die("DB Error: Cannot retrieve message.");
        $weekarray=array("日","一","二","三","四","五","六");
        $data = array();
        foreach ($result_runs as $i){
            $tmpID = $i['running_ID'];
            $tmpName = $i['fileName'];
            $sql_rungroup ="SELECT * ,`running_activity`.`name` as runName,`running_activity`.`place` as runPlace
            FROM `running_group` 
            JOIN `running_activity` ON `running_group`.`running_ID`=`running_activity`.`running_ID` 
            where `running_activity`.`running_ID`='$tmpID'";
            $result_rungroup = mysqli_query($con, $sql_rungroup) or die("DB Error: Cannot retrieve message.");
            $text = '';
            $kiloList = array();
            foreach ($result_rungroup as $j => $i) {
                if($j != 0) $text = $text.'/';
                $text =  $text.$i['group_name'].'('.$i['kilometers'].'K)';
                array_push($kiloList, urlencode($i['group_name']));
                array_push($kiloList, $i['kilometers']);
            }
            $array = array( 
                'Id' => $i['running_ID'],
                'Name' => urlencode($i['runName']),
                'Date' => $i['date'], // 因為有中文所以要用 urlencode 去 encode
                'Startdate' => $i['start_time'],
                'Enddate' => $i['end_time'],
                'Location' => urlencode($i['place']),
                //'Group' => urlencode($text),
                'Group' => $kiloList,
                'ImageUrl' =>$tmpName
            );
            array_push($data, $array);
        }
        echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        
        // echo json_encode($data);
    } else {
        echo json_encode(["result" => "DataBase connection failed"]);
    }
?>