<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $checkin = checkin($data[0]['registration_ID'], $data[0]['staff_ID'], $data[0]['time']);
            
            $result = check_checkin($data[0]['registration_ID']);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                echo json_encode(["ans" => "yes"]);
            } else {
                echo json_encode(["ans" => "no"]);
            }

        } else {
            echo json_encode(["ans" => "no"]);
        }
?>