<?php
require("memberModel.php");
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if ($email && $password) {
        $result = login($email, $password);

        $row = mysqli_fetch_assoc($result);
        if ($row == "") {
            echo json_encode(["ans" => "no"]);
        } else {
            echo json_encode(["ans" => "yes"]);
        }
    } else {
        echo json_encode(["ans" => "no"]);
    }
}
?>