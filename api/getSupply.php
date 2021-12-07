<?php
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $rid = $_GET['running_ID'];

        if ($rid) {
            $supply = get_supply($rid);

            if (mysqli_num_rows($supply) > 0) {
                echo "<select>";
                while ($row = mysqli_fetch_assoc($supply)) {
                    echo "<option value='" . $row['supply_ID']. "'>" . $row['supply_name'] . "</option>";
                }
                echo "</select>";
            } else {
                echo "<select><option disabled selected value>請選擇</option></select>";
            }
        } else {
            echo urldecode(json_encode(["ans" => "NoData"]));
        }
    }
?>