<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $registrationID = $data[0]['running_ID'].$data[0]['member_ID'];

            $check = get_group_name($registrationID);
            $row = mysqli_fetch_assoc($check);

            if ($row) {
                echo json_encode($row);
            } else {
                $information = confirm_information($registrationID, $data[0]['member_ID'], $data[0]['running_ID'], $data[0]['group_name'], $data[0]['registration_time']);
                
                for ($i = 0; $i < count($data[0]['gift_size']); $i++) {
                    $gift = insert_selected_gift_size($registrationID, $data[0]['gift_size'][$i]['id'], $data[0]['gift_size'][$i]['selectedSize']);
                }

                $result = check_information($registrationID);
                $row2 = mysqli_fetch_assoc($result);

                $result2 = check_selected_gift_size($registrationID, $data[0]['gift_size'][0]['id']);
                $row3 = mysqli_fetch_assoc($result2);

                if ($row2 && $row3) {
                    echo json_encode(["ans" => "yes"]);
                } else {
                    echo json_encode(["ans" => "no"]);
                }
            }
        } else {
            echo json_encode(["ans" => "No data sent"]);
        }
?>