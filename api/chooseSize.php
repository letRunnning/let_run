<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $gift = get_gift($data[0]['running_ID'], $data[0]['group_name']);
            $size = get_gift_size($data[0]['running_ID'], $data[0]['group_name']);
            
            $data = array();

            foreach ($gift as $i) {
                $giftArray = array();
                foreach ($size as $j) {
                    if ($i['gift_ID'] == $j['gift_ID']) {
                        array_push($giftArray, urlencode($j['gdetail_size']));
                    }
                }

                $array = array(
                    'id' => $i['gift_ID'],
                    'name' => urlencode($i['gift_name']),
                    'sizeList' => $giftArray
                );
                array_push($data, $array);
            }
            echo urldecode(json_encode($data, JSON_PRETTY_PRINT));
        } else {
            echo json_encode(["ans" => "No data sent"]);
        }
?>