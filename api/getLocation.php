<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $rid = $_POST['running_ID'];
        $bid = $_POST['beacon_ID'];
        $data = json_decode(file_get_contents("php://input"), true);
        $result = get_location($rid, $bid);

        $row = mysqli_fetch_assoc($result);

        if ($row) {
            echo urldecode(json_encode($row, JSON_PRETTY_PRINT));
        } else {
            echo json_encode(["ans" => "no"]);
        }
    }
?>