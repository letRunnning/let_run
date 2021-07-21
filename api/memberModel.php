<?php
    require_once("dbconnect.php");

    function login() {
        global $db;
        $sql = "SELECT *, `member`.`name` AS `member_name`, `files`.`name` AS `file_name` FROM `member` JOIN `files` ON `files`.`no` = `member`.`file_no`";
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
?>