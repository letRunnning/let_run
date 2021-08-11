<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);
        $result = get_checkin($data[0]['registration_ID']);

        $row = mysqli_fetch_assoc($result);

        if ($row) {
            if ($row['checkin_time'] == null) {
                $row['status'] = 'NotChechinYet';
                echo urldecode(json_encode($row, JSON_PRETTY_PRINT));
            } else {
                $row['status'] = 'AlreadyChenkin';
                echo urldecode(json_encode($row, JSON_PRETTY_PRINT));
            }
        } else {
            echo json_encode(['checkin_time' => null, 'running_name' => null, 'group_name' => null, 'status' => 'NotExist']);
        }
?>