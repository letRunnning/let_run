<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $pwd = check_password($data[0]['member_ID']);

            $row = mysqli_fetch_assoc($pwd);
            $response['password'] = $row['password'];

            if ($row) {
                if ($response['password'] == $data[0]['password']) {
                    echo json_encode(["ans" => "yes"]);
                } else {
                    echo json_encode(["ans" => "no"]);
                }
            } else {
                echo json_encode(["ans" => "no"]);
            }
        } else {
            echo json_encode(["ans" => "no"]);
        }
?>