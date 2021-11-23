<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    $data = json_decode(file_get_contents("php://input"), true);
    $result = get_location($data[0]['running_ID']);

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        echo urldecode(json_encode($row, JSON_PRETTY_PRINT));
    } else {
        echo json_encode(["ans" => "no"]);
    }
?>