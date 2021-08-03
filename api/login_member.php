<?php
    require("memberModel.php");
    header('Content-Type: application/json; charset=UTF-8');

    // if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //     $email = $_POST['Email'];
    //     $password = $_POST['Password'];
        
    //     if ($email && $password) {
    //         $result = login($email, $password);

    //         $row = mysqli_fetch_assoc($result);
    //         if ($row == "") {
    //             echo json_encode(["ans" => "no"]);
    //         } else {
    //             echo json_encode(["ans" => "yes"]);
    //         }
    //     } else {
    //         echo json_encode(["ans" => "no"]);
    //     }
    // }
    
    $i = 0;
    $result = login_member();

    while ($row = mysqli_fetch_assoc($result)) {
        $response[$i]['email'] = $row['email'];
        $response[$i]['password'] = $row['password'];
        $i++;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $data2 = array();
    $data3 = array();
    $data4 = array();

    $count = 0;
    for ($i = 0; $i < count($response); $i++) {
        if ($data[0]['Email'] == $response[$i]['email']) {
            if (password_verify($data[0]['Password'], $response[$i]['password'])) {
                foreach ($result as $j) {
                    if ($data[0]['Email'] == $j['email']) {
                        $array = array(
                            'Member_ID' => $j['member_ID'],
                            'Name' => urlencode($j['member_name']),
                            'Email' => $j['email'],
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
                $array2 = array("ans" => "email doesn't exist");
                array_push($data4, $array2);
                echo urldecode(json_encode($data4, JSON_PRETTY_PRINT));
            }
        }
    }
?>