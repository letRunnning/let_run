<?php
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $participation = check_application($data[0]['staff_ID'], $data[0]['running_ID']);
            $row = mysqli_fetch_assoc($participation);

            if ($row == null) {
                $number = check_application_number($data[0]['workgroup_ID'], $data[0]['running_ID']);
                $row2 = mysqli_fetch_assoc($number);
                $maxNum = get_maximum_number($data[0]['workgroup_ID'], $data[0]['running_ID']);
                $row3 = mysqli_fetch_assoc($maxNum);
                
                if ($row2['COUNT(`staff_ID`)'] == $row3['maximum_number']) {
                    echo json_encode(["ans" => "ToTheMaximumNumber"]);
                } else {
                    $apply = apply_job($data[0]['workgroup_ID'], $data[0]['staff_ID'], $data[0]['running_ID']);
                    $result = check_application_update($data[0]['staff_ID'], $data[0]['workgroup_ID'], $data[0]['running_ID']);
                    $row4 = mysqli_fetch_assoc($result);

                    if ($row4) {
                        echo json_encode(["ans" => "yes"]);
                    } else {
                        echo json_encode(["ans" => "no"]);
                    }
                }
            } else {
                echo urldecode(json_encode(["ans" => $row['name']], JSON_PRETTY_PRINT));
            }
        } else {
            echo json_encode(["ans" => "No data sent"]);
        }
?>