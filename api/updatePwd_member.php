<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $password = $data[0]['Password'];
        $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

        $update = update_password($pwd_hash, $data[0]['Member_ID']);

        $result = check_password_update($data[0]['Member_ID'], $pwd_hash);

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