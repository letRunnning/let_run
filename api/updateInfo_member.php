<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
    $member_ID = $data[0]['Member_ID'];
    $name = $data[0]['Name'];
    $id_card = $data[0]['Id_card'];
    $password = $data[0]['Password'];
    $email = $data[0]['Email'];
    $phone = $data[0]['Phone'];
    $birthday = $data[0]['Birthday'];
    $address = $data[0]['Address'];
    $contact_name = $data[0]['Contact_name'];
    $contact_phone = $data[0]['Contact_phone'];
    $relation = $data[0]['Relation'];
    $uploadcode = $data[0]['Uploadcode'];

    $file_no ='';
    $imageName='';
    if($uploadcode){
        $imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';
        if (strstr($uploadcode,",")){
            $uploadcode = explode(',',$uploadcode);
            $uploadcode = $uploadcode[1];
        }
        $path = "../photo/";
        $imageSrc=  $path."/". $imageName; 
        $r = file_put_contents($imageSrc, base64_decode($uploadcode));//返回的是位元組數
        if ($r) {
            $sql = "INSERT INTO `files`(`no`, `name`, `original_name`, `path`, `create_time`, `usable`) VALUES (null,'$imageName','$imageName','http://running.im.ncnu.edu.tw/running/files/photo/member/',now(),1);";
            $result = mysqli_query($db, $sql) ;
            $file_no = mysqli_insert_id($db);
        }
    }
    if($file_no != ''){
        if($name != '' && $id_card !='' && $email !='' && $phone!=''){
            $sql = "UPDATE `member` SET `id_card`='$id_card',`name`='$name',`phone`='$phone',
        `email`='$email',`birthday`='$birthday',`address`='$address',`contact_name`='$contact_name',
        `contact_phone`='$contact_phone',`relation`='$relation',`file_no`='$file_no' WHERE `member_ID` = '$member_ID'";
            $result = mysqli_query($db, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
            if($result){
                echo json_encode([["Photo_code" => "$imageName"]]);
            }else{
                echo json_encode([["ans" => "no"]]);
            }
        }else{
            echo json_encode([["ans" => "No empty"]]);
        }
    }else{
        echo json_encode([["ans" => "photo upload failed"]]);
    }

?>