<?php
    $con = mysqli_connect("localhost", "id17256516_root", '&qM$(wP3Nu6/U$T3', "id17256516_run");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailers/Exception.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailers/PHPMailer.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailers/SMTP.php';
    
    if ($con) {
        header("Content-Type: application/json; charset=UTF-8");

        $data = json_decode(file_get_contents("php://input"), true);
        $mid = $_POST['member_ID'];
        $rid = $_POST['running_ID'];
        $sendEmail = $_POST['email'];

        if ($mid != '') {
            $sql = "SELECT `name` FROM `member` WHERE `member_ID` = '$mid'";
            $sql2 = "SELECT `name`, `end_time` FROM `running_activity` WHERE `running_ID` = '$rid'";
            $result = mysqli_fetch_assoc(mysqli_query($con, $sql));
            $result2 = mysqli_fetch_assoc(mysqli_query($con, $sql2));
            $sName = $result['name'];
            $rName = $result2['name'];

            if ($result) {
                $name = 'No1路跑服務有限公司';
                $email = $sendEmail;
                $subject = '【No1路跑服務有限公司】繳費通知信';
                $body = '<h3>'.$sName.' 您好，</h3><sapn>您參加之路跑活動 - </sapn><b>'.$rName.'</b><sapn>，繳費期限<b>只剩五天</b>，請您盡速繳費，若已繳費，請忽視此訊息，謝謝！</sapn><br><br><br>' . date('Y-m-d H:i:s');

                $mail = new PHPMailer();

                //SMTP Settings
                $mail->isSMTP();
                // $mail->SMTPDebug = 2;
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "letrun05@gmail.com";
                $mail->Password = 'letrunrun05';
                $mail->Port = 587;
                $mail->SMTPSecure = "tls";

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
            } else {
                echo json_encode(["ans" => "NoSuccess"]);
            }
        } else {
            echo json_encode(["ans" => "Member_ID can't empty!"]);
        }
    } else {
        echo json_encode(["ans" => "DataBase connection failed"]);
    }
?>