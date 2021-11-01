<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $r_ID = $data[0]['registration_ID'];
    // $r_ID = 'A1M000001';

    // 原本是先判斷該報名編號是否兌換禮品了，若兌換了就顯示當時兌換時間+禮品，
    // 若尚未兌換則時間顯示null+應兌換禮品
    
    // 我想說在檢查是否兌換前先檢查是否報名跟有沒有禮品要兌換 
    if($r_ID != '' ){
        $sql_c = "SELECT * FROM `registration` WHERE `registration_ID`='$r_ID'";
        $result_c = mysqli_query($db, $sql_c) or die("DB Error: Cannot retrieve message.");
        if($result_c->num_rows != 0){
            $sql_checkin = "SELECT * FROM `checkin` WHERE `registration_ID`='$r_ID'";
            $result_checkin = mysqli_query($db, $sql_checkin) or die("DB Error: Cannot retrieve message.");
            if($result_checkin->num_rows != 0){
                $sql_red = "SELECT * FROM `redeem` WHERE `registration_ID`='$r_ID'";
                $result_reedem = mysqli_query($db, $sql_red) or die("DB Error: Cannot retrieve message.");
                if($result_reedem->num_rows != 0){
                    $sql_g = "SELECT * FROM `gift_size` join gift 
                    ON `gift_size`.`gift_ID`=`gift`.`gift_ID` 
                    WHERE gift_size.`registration_ID`= '$r_ID'";
                    // $data = array();
                    $sql_giftlist ="SELECT * FROM `gift_size` join gift 
                    ON `gift_size`.`gift_ID`=`gift`.`gift_ID` 
                    WHERE gift_size.`registration_ID`= '$r_ID'";
                    $result_giftlist = mysqli_query($db, $sql_giftlist) or die("DB Error: Cannot retrieve message.");

                    $giftList = array();
                    foreach ($result_giftlist as $j => $i) {
                        array_push($giftList, urlencode($i['gift_name']));
                        array_push($giftList, urlencode($i['size'])); }

                    foreach ($result_reedem as $i){
                        $array = array( 
                            'exchange_time' => date($i['redeem_time']),
                            'gift' => $giftList,
                            'status' => "AlreadyRedeemed"
                        );
                        // array_push($data, $array);
                    }
                    echo urldecode(json_encode($array, JSON_PRETTY_PRINT));

                }else{
                    $sql_giftlist ="SELECT * FROM `gift_size` join gift 
                        ON `gift_size`.`gift_ID`=`gift`.`gift_ID` 
                        WHERE gift_size.`registration_ID`= '$r_ID'";
                    $result_giftlist = mysqli_query($db, $sql_giftlist) or die("DB Error: Cannot retrieve message.");
                    $giftList = array();
                    foreach ($result_giftlist as $j => $i) {
                        array_push($giftList, urlencode($i['gift_name']));
                        array_push($giftList, urlencode($i['size']));
                    }
                    // $data = array();
                    
                    $array = array( 
                        'exchange_time' => null,
                        'gift' => $giftList,
                        'status' => "NotRedeemedYet"
                    );
                    // array_push($data, $array);
                    echo urldecode(json_encode($array, JSON_PRETTY_PRINT));

                }
            }else{
                $array = array( 
                    'exchange_time' => null,
                    'gift' => null,
                    'status' => "NotCheckInYet"
                );
                echo urldecode(json_encode($array, JSON_PRETTY_PRINT));
                }
        }else{
            $array = array( 
                'exchange_time' => null,
                'gift' => null,
                'status' => "NotExist"
            );
            echo urldecode(json_encode($array, JSON_PRETTY_PRINT));
            }
    }
    else
    {
        echo json_encode(["ans" => "registration_ID can't empty"]);
    }        
    // echo json_encode($data);
?>