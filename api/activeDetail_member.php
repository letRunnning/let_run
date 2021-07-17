<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    // if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // $id = $_POST['running_ID'];

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $group = get_running_group_detail($data[0]['running_ID']);
            $gift = get_gift_detail($data[0]['running_ID']);

            $data = array();
            $giftArray = array();

            foreach ($group as $i) {
                foreach ($gift as $j) {
                    array_push($giftArray, urlencode($j['gift_name']));
                    array_push($giftArray, $j['name']);
                }

                if ($i['group_name'] == $j['group_name']) {
                    $array = array(
                        'running_ID' => $i['running_ID'],
                        'group_name' => urlencode($i['group_name']),
                        'amount' => $i['amount'],
                        'maximum_number' => $i['maximum_number'],
                        'start_time' => $i['start_time'],
                        'total_time' => strtotime($i['end_time']) - strtotime($i['start_time']),
                        'gift' => $giftArray
                    );
                    array_push($data, $array);
                } else {
                    $array = array(
                        'running_ID' => $i['running_ID'],
                        'group_name' => urlencode($i['group_name']),
                        'amount' => $i['amount'],
                        'maximum_number' => $i['maximum_number'],
                        'start_time' => $i['start_time'],
                        'total_time' => strtotime($i['end_time']) - strtotime($i['start_time'])
                    );
                    array_push($data, $array);
                    break;
                }
            }
            echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        }
    // }
?>