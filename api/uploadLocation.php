<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $location = upload_location($data[0]['member_ID'], $data[0]['running_ID'], $data[0]['time'], $data[0]['beacon_ID']);
            
            $result = check_location($data[0]['member_ID'], $data[0]['running_ID'], $data[0]['time']);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                echo json_encode(["ans" => "yes"]);
            } else {
                echo json_encode(["ans" => "no"]);
            }
        } else {
            echo json_encode(["ans" => "No data sent"]);
        }
?>