<?php
    // 工作人員掃描活動 QR Code 報到
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        // 傳：workgroup_ID, staff_ID
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            // 上傳報到時間
            $result = update_checkin_time($data[0]['workgroup_ID'], $data[0]['staff_ID']);
            $check = checkin($data[0]['workgroup_ID'], $data[0]['staff_ID']);
            $row2 = mysqli_fetch_assoc($check);

            if ($row2 != NULL) {
                echo json_encode(["ans" => "yes"]); // 報到成功
            } else {
                echo json_encode(["ans" => "no"]); // 報到失敗
            }
        } else {
            echo json_encode(["ans" => "no"]);
        }
?>