<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        $r_ID = $data[0]['registration_ID'];
        // $r_ID = 'A1M000001';
        
        if($r_ID != '' ){
            $sql_red = "SELECT * FROM `redeem` WHERE `registration_ID`='$r_ID'";
            $result_qrcode = mysqli_query($con, $sql_red) or die("DB Error: Cannot retrieve message.");
            if($result_qrcode->num_rows != 0){
                $sql_g = "SELECT * FROM `gift_size` join gift 
                ON `gift_size`.`gift_ID`=`gift`.`gift_ID` 
                WHERE gift_size.`registration_ID`= '$r_ID'";
                $data = array();
                $sql_giftlist ="SELECT * FROM `gift_size` join gift 
                ON `gift_size`.`gift_ID`=`gift`.`gift_ID` 
                WHERE gift_size.`registration_ID`= '$r_ID'";
                $result_giftlist = mysqli_query($con, $sql_giftlist) or die("DB Error: Cannot retrieve message.");

                $giftList = array();
                foreach ($result_giftlist as $j => $i) {
                    array_push($giftList, urlencode($i['gift_name']));
                    array_push($giftList, urlencode($i['size']));
                }
                foreach ($result_qrcode as $i){
                    $array = array( 
                        'exchange_time' => date($i['redeem_time']),
                        'giftList' => $giftList
                    );
                    array_push($data, $array);
                }
                echo urldecode(json_encode($data, JSON_PRETTY_PRINT));

            }else{
                $sql_giftlist ="SELECT * FROM `gift_size` join gift 
                ON `gift_size`.`gift_ID`=`gift`.`gift_ID` 
                WHERE gift_size.`registration_ID`= '$r_ID'";
                $result_giftlist = mysqli_query($con, $sql_giftlist) or die("DB Error: Cannot retrieve message.");
                $giftList = array();
                foreach ($result_giftlist as $j => $i) {
                    array_push($giftList, urlencode($i['gift_name']));
                    array_push($giftList, urlencode($i['size']));
                }
                
                $data = array();
                $array = array( 
                    'exchange_time' => null,
                    'giftList' => $giftList
                );
                array_push($data, $array);
                echo urldecode(json_encode($data, JSON_PRETTY_PRINT));

            }
        }else{
            echo json_encode(["ans" => "registration_ID can't empty"]);
        }        
        // echo json_encode($data);
    } else {
        echo json_encode(["ans" => "DataBase connection failed"]);
    }
?>