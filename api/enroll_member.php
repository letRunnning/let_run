<?php
    $con = mysqli_connect("localhost", "id17225959_user", 'zS/-\q?JOg+Yvn1$', "id17225959_running");
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
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
        
        $sql_num = "SELECT COUNT(*) as num FROM `member` WHERE 1 LIMIT 1";
        $nums=mysqli_query($con,$sql_num) or die("DB Error: Cannot retrieve message.");
        $nums = mysqli_fetch_assoc($nums);
        $member_ID = 'M'.sprintf("%06d",$nums['num']+1);

        if($name != '' && $id_card !='' && $password !='' && $email !='' && $phone!=''){
          $sql = "INSERT INTO `member`(`member_ID`, `id_card`, `name`, `phone`, `email`, `birthday`, `password`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) 
          VALUES ('$member_ID','$id_card','$name','$phone','$email','$brithday','$password','$address','$contact_name','$contact_phone','$relation',null);";
          $result = mysqli_query($con, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
          if($result){
              echo json_encode(["result" => "$member_ID"]);
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
?>