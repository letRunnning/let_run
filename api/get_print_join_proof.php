<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] = "GET") {
        // $mid = $_GET['member_ID'];
        // $rid = $_GET['running_ID'];
        $mid = 'M000004';
        $rid = 'A6';

        if ($mid) {
            $sql_start = get_starttime_member($rid,$mid);
            $result = $sql_start->fetch_object();
            print_r($result);
            $StartTime = $result->pass_time;
            print_r($StartTime);

            $sql_end = get_endtime_member($rid,$mid);
            $result_end = $sql_end->fetch_object();
            print_r($result_end);
            $EndTime = $result_end->pass_time;
            print_r($EndTime);
            echo "<br>";
            echo (strtotime($EndTime) - strtotime($StartTime))/ (60*60)." hours";
            // foreach ($sql_id as $i){
            //     echo $i['running_ID'];
            // }
            

            // $i = 0;
            // $response = array();
            // while ($row = mysqli_fetch_assoc($location)) {
            //     $response[$i]['beacon_ID'] = $row['beacon_ID'];
            //     $response[$i]['num'] = $row['num'];
            //     $i++;
            // }

            // if ($response) {
            //     echo urldecode(json_encode(["running_ID" => $mid, "number" => $response]));
            // } else {
            //     echo "0";
            // }
        } else {
            echo urldecode(json_encode(["ans" => "NoData"]));
        }
    }
?>