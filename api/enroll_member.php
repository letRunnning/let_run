<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");
    $data = json_decode(file_get_contents("php://input"), true);
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
    // $name ='123';
    // $id_card = '123';
    // $password = '123';
    // $email = '123';
    // $phone = '123';
    // $birthday = '2021-07-01';
    // $address = '123';
    // $contact_name = '123';
    // $contact_phone = '123';
    // $relation = '123';

    $pwd_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql_num = "SELECT * FROM `member` ORDER BY `member`.`member_ID` DESC LIMIT 1";
    $nums=mysqli_query($db,$sql_num) or die("DB Error: Cannot retrieve message.");
    $nums = mysqli_fetch_assoc($nums);
    $sNums = substr($nums['member_ID'],1,strlen($nums['member_ID']));
    $member_ID = 'M'.sprintf("%06d",$sNums+1);

    if($name != '' && $id_card !='' && $email !='' && $phone!=''){
        // if (preg_match("/[0-9]+/", $password) && (preg_match("/[a-z]+/", $password) || preg_match("/[A-Z]+/", $password)) && (strlen($password) >= 8)) {
        $sql = "INSERT INTO `member`(`member_ID`, `id_card`, `name`, `phone`, `email`, `birthday`, `password`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) 
        VALUES ('$member_ID','$id_card','$name','$phone','$email','$birthday','$pwd_hash','$address','$contact_name','$contact_phone','$relation',null);";
        $result = mysqli_query($db, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
        if($result){
            echo json_encode(["ans" => "$member_ID"]);
        }else{
            echo json_encode(["ans" => "NoSuccess"]);
        }
        // }else{
        //     echo urldecode(json_encode(["ans" => urlencode("密碼需包含英文字母與數字並長度大於8")]));
        // }
    }else{
            echo json_encode(["ans" => "NoEmpty"]);
    }
?>