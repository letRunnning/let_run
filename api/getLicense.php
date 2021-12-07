<?php
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $hospitalName = $_GET['hospital_name'];

        if ($hospitalName) {
            $hospital = get_license($hospitalName);

            if (mysqli_num_rows($hospital) > 0) {
                echo "<select>";
                while ($row = mysqli_fetch_assoc($hospital)) {
                    echo "<option>" . $row['liciense_plate'] . "</option>";
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