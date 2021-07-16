<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    
    if ($con) {
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
        
        $sql_num = "SELECT COUNT(*) as num FROM `member` WHERE 1 LIMIT 1";
        $nums=mysqli_query($con,$sql_num) or die("DB Error: Cannot retrieve message.");
        $nums = mysqli_fetch_assoc($nums);
        $member_ID = 'M'.sprintf("%06d",$nums['num']+1);

        if($name != '' && $id_card !='' && $password !='' && $email !='' && $phone!=''){
          $sql = "INSERT INTO `member`(`member_ID`, `id_card`, `name`, `phone`, `email`, `birthday`, `password`, `address`, `contact_name`, `contact_phone`, `relation`, `file_no`) 
          VALUES ('$member_ID','$id_card','$name','$phone','$email','$birthday','$password','$address','$contact_name','$contact_phone','$relation',null);";
          $result = mysqli_query($con, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
          if($result){
              echo json_encode(["ans" => "$member_ID"]);
          }else{
              echo json_encode(["ans" => "NoSuccess"]);
          }
        }else{
              echo json_encode(["ans" => "NoEmpty"]);
          }
      } else {
          echo json_encode(["ans" => "DataBase connection failed"]);
          //echo "DataBase connection failed";
      }
?>