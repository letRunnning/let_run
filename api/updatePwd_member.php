<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $update = update_password($data[0]['Password'], $data[0]['Member_ID']);

        $result = check_password_update($data[0]['Member_ID'], $data[0]['Password']);

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