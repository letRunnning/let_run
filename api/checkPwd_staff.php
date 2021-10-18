<?php
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $pwd = check_password($data[0]['Staff_ID']);

            $row = mysqli_fetch_assoc($pwd);
            $response['password'] = $row['password'];

            if ($row) {
                if (password_verify($data[0]['Password'], $response['password'])) {
                    echo json_encode(["ans" => "yes"]);
                } else {
                    echo json_encode(["ans" => "no"]);
                }
            } else {
                echo json_encode(["ans" => "No data in the database"]);
            }
        } else {
            echo json_encode(["ans" => "No data sent"]);
        }
?>