<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $rid = $_POST['running_ID'];
        $data = json_decode(file_get_contents("php://input"), true);
        $result = get_location($rid);

        $i = 0;
        $response = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $response[$i]['beacon_ID'] = $row['beacon_ID'];
            $response[$i]['num'] = $row['num'];
            $i++;
        }

        if ($response) {
            echo urldecode(json_encode($response, JSON_PRETTY_PRINT));
        }
    }
?>