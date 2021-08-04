<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
        
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $data = json_decode(file_get_contents("php://input"), true);
        $staff_ID = $data[0]['Staff_ID'];
        $name = $data[0]['Name'];
        $id_card = $data[0]['Id_card'];
        $email = $data[0]['Email'];
        $phone = $data[0]['Phone'];
        $birthday = $data[0]['Birthday'];
        $address = $data[0]['Address'];
        $contact_name = $data[0]['Contact_name'];
        $contact_phone = $data[0]['Contact_phone'];
        $relation = $data[0]['Relation'];
        $uploadcode = $data[0]['Uploadcode'];
        $lineid = $data[0]['Line_ID'];

        $file_no ='';
        if($uploadcode){
            $imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';
            if (strstr($uploadcode,",")){
                $uploadcode = explode(',',$uploadcode);
                $uploadcode = $uploadcode[1];
            }
            $path = "../photo/staff/";
            $imageSrc=  $path."/". $imageName; 
            $r = file_put_contents($imageSrc, base64_decode($uploadcode));//返回的是位元組數
            if ($r) {
                $sql = "INSERT INTO `files`(`no`, `name`, `original_name`, `path`, `create_time`, `usable`) VALUES (null,'$imageName','$imageName','https://letrun05.000webhostapp.com/photo/staff',now(),1);";
                $result = mysqli_query($con, $sql) ;
                $file_no = mysqli_insert_id($con);
            }
        }
        if($file_no != ''){
            if($name != '' && $id_card !='' && $email !='' && $phone!=''){
                $sql = "UPDATE `staff` SET `id_card`='$id_card',`name`='$name',`phone`='$phone',
            `email`='$email',`birthday`='$birthday',`address`='$address',`contact_name`='$contact_name',
            `contact_phone`='$contact_phone',`relation`='$relation',`file_no`='$file_no',`lineid`='$lineid' WHERE `staff_ID` = '$staff_ID'";
                $result = mysqli_query($con, $sql) ;//or die("Insert failed, SQL query error,sql"); //執行SQL       
                if($result){
                    echo json_encode(["ans" => "yes"]);
                }else{
                    echo json_encode(["ans" => "no"]);
                }
            }else{
                echo json_encode(["ans" => "No empty"]);
            }
        }else{
            echo json_encode(["ans" => "photo upload failed"]);
        }
    }else {
        echo json_encode(["ans" => "DataBase connection failed"]);
        //echo "DataBase connection failed";
    }

?>