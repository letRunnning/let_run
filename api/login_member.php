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
    $result = login();

    while ($row = mysqli_fetch_assoc($result)) {
        $response[$i]['email'] = $row['email'];
        $response[$i]['password'] = $row['password'];
        $i++;
    }

    $data = json_decode(file_get_contents("php://input"), true);
    $data2 = array();

    $count = 0;
    for ($i = 0; $i < count($response); $i++) {
        if ($data[0]['Email'] == $response[$i]['email']) {
            if ($data[0]['Password'] == $response[$i]['password']) {
                foreach ($result as $j) {
                    if ($data[0]['Email'] == $j['email']) {
                        $array = array(
                            'Member_ID' => urlencode($j['member_ID']),
                            'Name' => urlencode($j['name']),
                            'Email' => urlencode($j['email']),
                            'Image' => urlencode($j['file_name'])
                        );
                        array_push($data2, $array);
                    }
                }
                echo urldecode(json_encode($data2, JSON_PRETTY_PRINT));
                break;
            } else {
                $count++;
                if ($count == count($response))
                    echo json_encode(["ans" => "no"]);
            }
        } else {
            $count++;
            if ($count == count($response))
                echo json_encode(["ans" => "email doesn't exist"]);
        }
    }
?>