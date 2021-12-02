<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    $data = json_decode(file_get_contents("php://input"), true);

    if ($data[0]['Member_ID'] && $data[0]['Password']) {
        $password = $data[0]['Password'];
        if (preg_match("/[0-9]+/", $password) && (preg_match("/[a-z]+/", $password) || preg_match("/[A-Z]+/", $password)) && strlen($password) >= 8) {
            $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

            $update = update_password($pwd_hash, $data[0]['Member_ID']);

            $result = check_password_update($data[0]['Member_ID'], $pwd_hash);

            $row = mysqli_fetch_assoc($result);

            if ($row) {
                echo json_encode(["ans" => "yes"]);
            } else {
                echo json_encode(["ans" => "no"]);
            }
        }else{
            echo urldecode(json_encode(["ans" => urlencode("密碼需包含英文字母與數字並長度大於8")]));
        }
    } else {
        echo json_encode(["ans" => "No data sent"]);
    }
?>