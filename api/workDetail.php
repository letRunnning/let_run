<?php
    require("staffModel.php");
    header('Content-Type: application/json; charset=UTF-8');

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data) {
            $workContent = get_work_content($data[0]['Workgroup_ID']);
            $row = mysqli_fetch_assoc($workContent);
            $data2 = array();

            if ($row) {
                foreach ($workContent as $i) {
                    $array = array(
                        'Content' => urlencode($i['content']),
                        'Time' => $i['assembletime'],
                        'Place' => urlencode($i['place'])
                    );
                    array_push($data2, $array);
                }
                echo urldecode(json_encode($data2, JSON_PRETTY_PRINT));
            } else {
                echo json_encode(["ans" => "no"]);
            }
        } else {
            echo json_encode(["ans" => "No data sent"]);
        }
?>