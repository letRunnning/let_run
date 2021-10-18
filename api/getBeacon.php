<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $data2 = array();

            $now = date("Y-m-d");
            $activity = get_today_activity($now);
            $registration = get_registration($data[0]['member_ID']);

            $i = 0;
            while ($row = mysqli_fetch_assoc($activity)) {
                $response[$i]['running_ID'] = $row['running_ID'];
                $response[$i]['name'] = $row['name'];
                $response[$i]['date'] = $row['date'];
                $i++;
            }

            $row2 = mysqli_fetch_assoc($registration);

            if ($row2) {
                echo json_encode($response[0]['running_ID']);
                // if ($response == null) {
                //     $array = array(
                //         'running_ID' => null,
                //         'group_name' => null,
                //         'beaconList' => [],
                //         'ifCheckin' => 'NoActivity'
                //     );
                //     array_push($data2, $array);
                //     echo urldecode(json_encode($data2, JSON_PRETTY_PRINT));
                // } else {
                //     for ($i = 0; $i < count($response); $i++) {
                //         $beacon = get_beacon($response[$i]['running_ID']);
                //         $registrationID = $response[$i]['running_ID'].$data[0]['member_ID'];
                //         $checkin = get_checkin_by_mid($registrationID);
                //         $row2 = mysqli_fetch_assoc($checkin);

                //         $beaconList = array();

                //         foreach ($beacon as $j) {
                //             array_push($beaconList, $j['beacon_ID']);
                //         }

                //         if ($row2) {
                //             $response[$i]['ifCheckin'] = 'AlreadyChenkedIn';
                //         } else {
                //             $response[$i]['ifCheckin'] = 'NotYetChenkedIn';
                //         }

                //         $array = array(
                //             'running_ID' => $response[$i]['running_ID'],
                //             'group_name' => urlencode($response[$i]['name']),
                //             'beaconList' => $beaconList,
                //             'ifCheckin' => $response[$i]['ifCheckin']
                //         );
                //         array_push($data2, $array);
                //     }
                //     echo urldecode(json_encode($data2, JSON_PRETTY_PRINT));
                // }
            } else{
                echo json_encode(array(["ifCheckin" => "No registration data"]));
            }
        } else {
            echo json_encode(array(["ans" => "No data sent"]));
        }
?>