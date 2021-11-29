<?php
    require_once("dbconnect.php");

    function login() {
        global $db;
        $sql = "SELECT *, `staff`.`name` AS `staff_name`, `files`.`name` AS `file_name` FROM `staff` LEFT JOIN `files` ON `files`.`no` = `staff`.`file_no`";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_password($id) {
        global $db;
        $sql = "SELECT `password` FROM `staff` WHERE `staff_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function update_password($pwd, $id) {
        global $db;
        $sql = "UPDATE `staff` SET `password`= ? WHERE `staff_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $pwd, $id); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_password_update($id, $pwd) {
        global $db;
        $sql = "SELECT * FROM `staff` WHERE `staff_ID` = ? AND `password` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $id, $pwd); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_application($sid, $rid) {
        global $db;
        $sql = "SELECT `name` FROM `staff_participation` JOIN `work_group` ON `work_group`.`workgroup_ID` = `staff_participation`.`workgroup_ID` WHERE `staff_ID` = ? AND `staff_participation`.`running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $sid, $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_maximum_number($wid, $rid) {
        global $db;
        $sql = "SELECT `maximum_number` FROM `work_group` WHERE `workgroup_ID` = ? AND `running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "is", $wid, $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_application_number($wid, $rid) {
        global $db;
        $sql = "SELECT COUNT(`staff_ID`) FROM `staff_participation` WHERE `workgroup_ID` = ? AND `running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "is", $wid, $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function apply_job($wid, $sid, $rid) {
        global $db;
        $sql = "INSERT INTO `staff_participation`(`workgroup_ID`, `staff_ID`, `running_ID`) VALUES (?,?,?)";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "iss", $wid, $sid, $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function check_application_update($sid, $wid, $rid) {
        global $db;
        $sql = "SELECT * FROM `staff_participation` WHERE `staff_ID` = ? AND `workgroup_ID` = ? AND `running_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "sis", $sid, $wid, $rid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function get_work_content($wid) {
        global $db;
        $sql = "SELECT `content`, `assembletime`, `place` FROM `work_content` 
            JOIN `assignment` ON `assignment`.`work_ID` = `work_content`.`work_ID` 
            JOIN `work_group` ON `work_group`.`workgroup_ID` = `assignment`.`workgroup_ID` 
            WHERE `assignment`.`workgroup_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "i", $wid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function checkin($rid, $sid) {
        global $db;
        $sql = "SELECT `checkin_time` FROM `staff_participation` WHERE `running_ID` = ? AND `staff_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $rid, $sid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }

    function update_checkin_time($rid, $sid) {
        global $db;
        $sql = "UPDATE `staff_participation` SET `checkin_time`= DATE_SUB(NOW(), INTERVAL '-8' HOUR) WHERE `running_ID` = ? AND `staff_ID` = ?";
        $stmt = mysqli_prepare($db, $sql); // prepare sql statement
        mysqli_stmt_bind_param($stmt, "ss", $rid, $sid); // bind parameters with variables
        mysqli_stmt_execute($stmt); // 執行 SQL
        $result = mysqli_stmt_get_result($stmt); // get result
        
        return $result;
    }
?>