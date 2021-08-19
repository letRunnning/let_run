<?php
    require_once("dbconnect.php");

    function login() {
        global $db;
        $sql = "SELECT *, `member`.`name` AS `member_name`, `files`.`name` AS `file_name` FROM `member` LEFT JOIN `files` ON `files`.`no` = `member`.`file_no`";
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

    function get_gift($rid, $gname) {
        global $db;
        $sql = "SELECT `gift_ID`, `gift_name` FROM `gift` WHERE `running_ID` = ? AND `group_name` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $rid, $gname); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_gift_size($rid, $gname) {
        global $db;
        $sql = "SELECT `gift_detail`.`gift_ID`, `gdetail_size` FROM `gift_detail` JOIN `gift` ON `gift`.`gift_ID` = `gift_detail`.`gift_ID` WHERE `running_ID` = ? AND `group_name` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $rid, $gname); // bind parameters with variables
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

    function insert_selected_gift_size($rid, $gid, $size) {
        global $db;
        $sql = "INSERT INTO `gift_size`(`registration_ID`, `gift_ID`, `size`) VALUES (?,?,?)";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "sss", $rid, $gid, $size); // bind parameters with variables
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

    function check_selected_gift_size($rid, $gid) {
        global $db;
        $sql = "SELECT * FROM `gift_size` WHERE `registration_ID` = ? AND `gift_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $rid, $gid); // bind parameters with variables
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

    function get_checkin($rid) {
        global $db;
        $sql = "SELECT `checkin`.`checkin_time`, `running_activity`.`name` AS `running_name`, `registration`.`group_name` FROM `registration` LEFT JOIN `checkin` ON `registration`.`registration_ID` = `checkin`.`registration_ID` JOIN `running_activity` ON `running_activity`.`running_ID` = `registration`.`running_ID` WHERE `registration`.`registration_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function checkin($rid, $sid, $time) {
        global $db;
        $sql = "INSERT INTO `checkin`(`registration_ID`, `staff_ID`, `checkin_time`) VALUES (?,?,?)";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "sss", $rid, $sid, $time); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_checkin($rID) {
        global $db;
        $sql = "SELECT * FROM `checkin` WHERE `registration_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $rID); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_today_activity($now) {
        global $db;
        $sql = "SELECT `running_ID`, `name`, `date` FROM `running_activity` WHERE `date` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $now); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_beacon($rid) {
        global $db;
        $sql = "SELECT `beacon_ID` FROM `beacon_placement` WHERE `running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_checkin_by_mid($rid) {
        global $db;
        $sql = "SELECT * FROM `checkin` WHERE `registration_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function upload_location($mid, $rid, $time, $bid) {
        global $db;
        $sql = "INSERT INTO `location`(`member_ID`, `running_ID`, `pass_time`, `beacon_ID`) VALUES (?,?,?,?)";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ssss", $mid, $rid, $time, $bid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_location($mid, $rid, $time) {
        global $db;
        $sql = "SELECT * FROM `location` WHERE `member_ID` = ? AND `running_ID` = ? AND `pass_time` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "sss", $mid, $rid, $time); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }
?>