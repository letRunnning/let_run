<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');
    
    $i = 0;
    $result = login_staff();

    while ($row = mysqli_fetch_assoc($result)) {
        $response[$i]['staff_ID'] = $row['staff_ID'];
        $response[$i]['password'] = $row['password'];
        $i++;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $data2 = array();
    $data3 = array();
    $data4 = array();

    $count = 0;
    for ($i = 0; $i < count($response); $i++) {
        if ($data[0]['Staff_ID'] == $response[$i]['staff_ID']) {
            if (password_verify($data[0]['Password'], $response[$i]['password'])) {
                foreach ($result as $j) {
                    if ($data[0]['Staff_ID'] == $j['staff_ID']) {
                        $array = array(
                            'Staff_ID' => $j['staff_ID'],
                            'Email' => $j['email'],
                            'Name' => urlencode($j['staff_name']),
                            'Id_card' => $j['id_card'],
                            'Photo_code' => urlencode($j['file_name'])
                        );
                        array_push($data2, $array);
                    }
                }
                echo urldecode(json_encode($data2, JSON_PRETTY_PRINT));
                break;
            } else {
                array_push($data3, array("ans" => "no"));
                echo urldecode(json_encode($data3, JSON_PRETTY_PRINT));
                break;
            }
        } else {
            $count++;
            if ($count == count($response)) {
                $array2 = array("ans" => "staff_ID doesn't exist");
                array_push($data4, $array2);
                echo urldecode(json_encode($data4, JSON_PRETTY_PRINT));
            }
        }
    }
?>