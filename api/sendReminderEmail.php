<?php
    require_once("dbconnect.php");
    header("Content-Type: application/json; charset=UTF-8");

    $data = json_decode(file_get_contents("php://input"), true);
    $mid = $_POST['member_ID'];
    $rid = $_POST['running_ID'];
    $sendEmail = $_POST['email'];
    $now = date('Y-m-d H:i:s');

    if ($mid != '') {
        $sql = "SELECT `name` FROM `member` WHERE `member_ID` = '$mid'";
        $sql2 = "SELECT `name`, `end_time` FROM `running_activity` WHERE `running_ID` = '$rid'";
        $result = mysqli_fetch_assoc(mysqli_query($con, $sql));
        $result2 = mysqli_fetch_assoc(mysqli_query($con, $sql2));
        $sName = $result['name'];
        $rName = $result2['name'];
        $endTime = $result2['end_time'] - $now;

        if ($result) {
            $name = 'No1路跑服務有限公司';
            $email = $sendEmail;
            $subject = '【No1路跑服務有限公司】繳費通知信';
            $body = '<h3>'.$sName.' 您好，</h3><sapn>您參加之路跑活動 - </sapn><b>'.$rName.'天</b><sapn>，繳費期限<b>只剩'.$endTime.'</b>，請您盡速繳費，若已繳費，請忽視此訊息，謝謝！</sapn><br><br><br>' . date('Y-m-d H:i:s');
            
            mail($email, $subject, $body,"From:Let's run\nContent-Type:text/html");
            echo json_encode(["ans" => "Success"]);
        } else {
            echo json_encode(["ans" => "NoSuccess"]);
        }
    } else {
        echo json_encode(["ans" => "Member_ID can't empty!"]);
    }
?>