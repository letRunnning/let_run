<?php
    // 工作人員掃描活動 QR Code 報到
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        // 傳：running_ID, staff_ID
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $checkin = checkin($data[0]['running_ID'], $data[0]['staff_ID']);
            $row = mysqli_fetch_assoc($checkin);
            
            if ($row['checkin_time'] != NULL) {
                echo json_encode(["ans" => "already checkin"]);
            } else {
                $result = update_checkin_time($data[0]['running_ID'], $data[0]['staff_ID']);
                $check = checkin($data[0]['running_ID'], $data[0]['staff_ID']);
                $row2 = mysqli_fetch_assoc($check);

                if ($row2 != NULL) {
                    echo json_encode(["ans" => "yes"]);
                } else {
                    echo json_encode(["ans" => "no"]);
                }
            }
        } else {
            echo json_encode(["ans" => "no"]);
        }
?>