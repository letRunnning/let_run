<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);
        $result = get_checkin($data[0]['staff_ID'], $data[0]['registration_ID']);

        $row = mysqli_fetch_assoc($result);

        if ($row) {
            echo json_encode(["checkin_time" => $row['checkin_time']]);
        } else {
            echo json_encode(["ans" => "null"]);
        }
?>