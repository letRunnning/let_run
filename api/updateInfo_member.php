<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
        
    if ($con) {
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
        $Photo_code = $data[0]['Photo_code'];
        if($Photo_code){
            
        }

        if($name != '' && $id_card !='' && $password !='' && $email !='' && $phone!=''){
          $sql = "UPDATE `member` SET `id_card`='$id_card',`name`='$name',`phone`='$phone',
          `email`='$email',`birthday`='$birthday',`address`='$address',`contact_name`='$contact_name',
          `contact_phone`='$contact_phone',`relation`='$relation',`file_no`='$file_no' WHERE `member_ID` = '$member_ID'";
          $result = mysqli_query($con, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
          if($result){
              echo json_encode(["ans" => "yes"]);
          }else{
              echo json_encode(["ans" => "no"]);
          }
        }else{
              echo json_encode(["ans" => "No empty"]);
          }
      } else {
          echo json_encode(["ans" => "DataBase connection failed"]);
          //echo "DataBase connection failed";
      }

?>