<?php
    require_once("dbconnect.php");

    function login_member() {
        global $db;
        $sql = "SELECT *, `member`.`name` AS `member_name`, `files`.`name` AS `file_name` FROM `member` LEFT JOIN `files` ON `files`.`no` = `member`.`file_no`";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function login_staff() {
        global $db;
        $sql = "SELECT *, `staff`.`name` AS `staff_name`, `files`.`name` AS `file_name` FROM `staff` LEFT JOIN `files` ON `files`.`no` = `staff`.`file_no`";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_running_group_detail($id) {
        global $db;
        $sql = "SELECT `running_ID`, `group_name`, `amount`, `maximum_number`, `start_time`, `end_time` FROM `running_group` WHERE `running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_gift_detail($id) {
        global $db;
        $sql = "SELECT `gift`.`group_name`, `gift`.`gift_name`, `files`.`name` FROM `gift` JOIN `files` ON `files`.`no` = `gift`.`file_no` WHERE `gift`.`running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_registration($id) {
        global $db;
        $sql = "SELECT `affidavit` FROM `running_activity` WHERE `running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function confirm_information($registrationID, $mID, $runningID, $group, $time) {
        global $db;
        $sql = "INSERT INTO `registration`(`registration_ID`, `member_ID`, `running_ID`, `group_name`, `time`) VALUES (?,?,?,?,?)";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "sssss", $registrationID, $mID, $runningID, $group, $time); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_information($rID) {
        global $db;
        $sql = "SELECT * FROM `registration` WHERE `registration_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $rID); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_group_name($rID) {
        global $db;
        $sql = "SELECT `group_name` FROM `registration` WHERE `registration_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $rID); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_password($id) {
        global $db;
        $sql = "SELECT `password` FROM `member` WHERE `member_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function update_password($pwd, $id) {
        global $db;
        $sql = "UPDATE `member` SET `password`= ? WHERE `member_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $pwd, $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_password_update($id, $pwd) {
        global $db;
        $sql = "SELECT * FROM `member` WHERE `member_ID` = ? AND `password` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $id, $pwd); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_checkin($sid, $rid) {
        global $db;
        $sql = "SELECT `checkin`.`checkin_time`, `registration`.`running_ID`, `registration`.`group_name` FROM `checkin` JOIN `registration` ON `registration`.`registration_ID` = `checkin`.`registration_ID` WHERE `staff_ID` = ? AND `checkin`.`registration_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $sid, $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function checkin($sid, $rid, $time) {
        global $db;
        $sql = "INSERT INTO `checkin`(`staff_ID`, `registration_ID `, `checkin_time`) VALUES (?,?,?)";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "sss", $sid, $rid, $time); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }
?>