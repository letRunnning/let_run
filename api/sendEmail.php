<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailers/Exception.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailers/PHPMailer.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailers/SMTP.php';
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");
        $m_ID="M000004";
        if($m_ID!=''){
            $temp = rand(1111111,9999999);
            $sql = "UPDATE `member` SET `captcha`='$temp' WHERE `member_ID`='$m_ID'";
            $result = mysqli_query($con, $sql) ;
            if($result){
                $name = 'service';
                $email = 'letrun05@gmail.com';
                $subject = '【No1路跑服務有限公司】忘記密碼-驗證碼通知信';
                $body = '<h3>'.$m_ID.'您好，</h3><sapn>歡迎您加入No1路跑服務有限公司，您的驗證碼為：<span style="font-weight: bold">'.$temp.'</span></sapn><br>' . date('Y-m-d H:i:s');

                // require_once "PHPMailer/PHPMailer.php";
                // require_once "PHPMailer/SMTP.php";
                // require_once "PHPMailer/Exception.php";

                $mail = new PHPMailer();

                //SMTP Settings
                $mail->isSMTP();
                // $mail->SMTPDebug = 2;
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "letrun05@gmail.com";
                $mail->Password = 'letrunrun05';
                $mail->Port = 587; //587
                $mail->SMTPSecure = "tls"; //tls

                //Email Settings
                $mail->isHTML(true);
                $mail->setFrom($email, $name);
                $mail->addAddress($email);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                

                if ($mail->send()) {
                    $status = "success";
                    $response = "Email is sent!".$subject;
                } else {
                    $status = "failed";
                    $response = "Something is wrong: <br><br>" . $mail->ErrorInfo;
                }

                echo (json_encode(array("status" => $status, "response" => $response)));
            
            }else{
                echo json_encode(["ans" => "NoSuccess"]);
            }
        }else{
            echo json_encode(["ans" => "Member_ID can't empty!"]);
        }

        
    
    } else {
        echo json_encode(["ans" => "DataBase connection failed"]);
    }
?>