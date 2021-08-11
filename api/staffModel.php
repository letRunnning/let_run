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
?>