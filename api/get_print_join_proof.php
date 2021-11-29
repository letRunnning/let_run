<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $mid = $_GET['member_ID'];
        $rid = $_GET['running_ID'];
        // $mid = 'M000004';
        // $rid = 'A6';

        if ($mid) {
            $sql_start = get_starttime_member($rid,$mid);
            $result = $sql_start->fetch_object();
            $StartTime = $result->pass_time;

            $sql_end = get_endtime_member($rid,$mid);
            $result_end = $sql_end->fetch_object();
            $EndTime = $result_end->pass_time;
            
            $total_time = (strtotime($EndTime) - strtotime($StartTime))/ (60*60);
            $total_time = number_format($total_time,2)." hours";
            echo urldecode(json_encode(["total_time" => $total_time]));

        } else {
            echo urldecode(json_encode(["ans" => "NoData"]));
        }
    }
?>