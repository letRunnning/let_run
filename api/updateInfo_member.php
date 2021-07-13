<?php
    $con = mysqli_connect("localhost", "id17225959_user", 'zS/-\q?JOg+Yvn1$', "id17225959_running");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        $member_ID = $data[0]['member_ID'];
        $name = $data[0]['name'];
        $id_card = $data[0]['id_card'];
        $password = $data[0]['password'];
        $email = $data[0]['email'];
        $phone = $data[0]['phone'];
        $birthday = $data[0]['birthday'];
        $address = $data[0]['address'];
        $contact_name = $data[0]['contact_name'];
        $contact_phone = $data[0]['contact_phone'];
        $relation = $data[0]['relation'];

        if($name != '' && $id_card !=''  && $email !='' && $phone!=''){
          $sql = "UPDATE `member` SET `id_card`='$id_card',`name`='$name',`phone`='$phone',
          `email`='$email',`birthday`='$birthday',`address`='$address',`contact_name`='$contact_name',
          `contact_phone`='$contact_phone',`relation`='$relation',`file_no`='$file_no' WHERE `member_ID` = '$member_ID'";
          $sql = "UPDATE `member` SET `id_card`='A221234567',`name`='會員一',`phone`='0912345678',
          `email`='123@gmail.com',`birthday`='2000-07-01',`address`='台北市',`contact_name`='會依爸',
          `contact_phone`='0975321854',`relation`='父女',`file_no`=null WHERE `member_ID` = 'M000001'";
          $result = mysqli_query($con, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
          if($result){
              echo json_encode(["result" => "yes"]);
          }else{
              echo json_encode(["result" => "no"]);
          }
        }else{
              echo json_encode(["result" => "No empty"]);
        }
      } else {
          echo json_encode(["result" => "DataBase connection failed"]);
          //echo "DataBase connection failed";
      }
?>