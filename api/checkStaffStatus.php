<?php
    // 先確認工作人員報到狀態
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        // 傳：workgroup_ID, staff_ID
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $result = array();
            // 先檢查有沒有這個組別
            $workgroup = check_work_group($data[0]['workgroup_ID']);
            $row = mysqli_fetch_assoc($workgroup);

            if ($row == NULL) { // 沒有這個組別
                $array = array(
                    'checkin_time' => NULL,
                    'group_name' => NULL,
                    'status' => 'NotExist'
                );
                array_push($result, $array);
                echo urldecode(json_encode($result, JSON_PRETTY_PRINT));
            } else {
                $registration = check_staff_registration($data[0]['workgroup_ID'], $data[0]['staff_ID']);
                $row2 = mysqli_fetch_assoc($registration);

                if ($row2 == NULL) { // 有這個組別但是這個工作人員沒有報名
                    $array = array(
                        'checkin_time' => NULL,

                        'group_name' => $row['name'],
                        'status' => 'Didn’tSignUpThisGroup'
                    );
                    array_push($result, $array);
                    echo urldecode(json_encode($result, JSON_PRETTY_PRINT));
                } else {
                    if ($row2['checkin_time'] == NULL) { // 沒有報到
                        $array = array(
                            'checkin_time' => NULL,
    
                            'group_name' => $row['name'],
                            'status' => 'NotCheckinYet'
                        );
                        array_push($result, $array);
                        echo urldecode(json_encode($result, JSON_PRETTY_PRINT));
                    } else {
                        $array = array(
                            'checkin_time' => $row2['checkin_time'],
                            'group_name' => $row['name'],
                            'status' => 'AlreadyChenkin'
                        );
                        array_push($result, $array);
                        echo urldecode(json_encode($result, JSON_PRETTY_PRINT));
                    }
                }
            }
        } else {
            echo json_encode(["ans" => "no"]);
        }
?>