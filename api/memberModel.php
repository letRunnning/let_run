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
?>