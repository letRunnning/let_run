<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $rid = $_GET['running_ID'];

        if ($rid) {
            $location = get_location($rid);

            $i = 0;
            $response = array();
            while ($row = mysqli_fetch_assoc($location)) {
                $response[$i]['beacon_ID'] = $row['beacon_ID'];
                $response[$i]['num'] = $row['num'];
                $i++;
            }

            if ($response) {
                echo urldecode(json_encode(["running_ID" => $rid, "number" => $response]));
            } else {
                echo "0";
            }
        } else {
            echo urldecode(json_encode(["ans" => "NoData"]));
        }
    }
?>