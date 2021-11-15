<?php
    require_once("dbconnec.php");
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
    $line_id = $data[0]['Line_ID'];
    // $name = 'testMan';
    // $id_card = 't00000000';
    // $password = 'Password';
    // $email = 'test@gmail.com';
    // $phone = '09999999';
    // $birthday = '2021-8-8';
    // $address = 'test-add';
    // $contact_name = 'test-parent';
    // $contact_phone = '08888888';
    // $relation = '父子';
    // $line_id = 'testlineid';
    
    $pwd_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql_num = "SELECT * FROM `staff` ORDER BY `staff`.`staff_ID` DESC LIMIT 1";
    $nums=mysqli_query($db,$sql_num) or die("DB Error: Cannot retrieve message.");
    $nums = mysqli_fetch_assoc($nums);
    $sNums = substr($nums['staff_ID'],1,strlen($nums['staff_ID']));
    $staff_ID = 'S'.sprintf("%06d",$sNums+1);
    
    if($name != '' && $id_card !='' && $password !='' && $email !='' && $phone!=''){
        if (preg_match("/[0-9]+/", $password) && (preg_match("/[a-z]+/", $password) || preg_match("/[A-Z]+/", $password)) && (strlen($password) >= 8)) {
            
            $sql = "INSERT INTO `staff`(`staff_ID`, `name`, `password`, `id_card`, `phone`, `email`, `lineid`, `birthday`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) 
            VALUES ('$staff_ID','$name','$pwd_hash','$id_card','$phone','$email','$line_id','$birthday','$address','$contact_name','$contact_phone','$relation',null);";
            $result = mysqli_query($db, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
            if($result){
                echo json_encode(["ans" => "$staff_ID"]);
            }else{
                echo json_encode(["ans" => "NoSuccess"]);
            }
        }else{
            echo urldecode(json_encode(["ans" => urlencode("密碼需包含英文字母與數字並長度大於8")]));
        }
    }else{
        echo json_encode(["ans" => "NoEmpty"]);
    }
?>