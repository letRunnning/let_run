<?php
require_once("dbconnect.php");

function login($email, $password) {
    global $db;
    $sql = "SELECT * FROM `member` WHERE `email` = ? AND `password` = ?";
    $stmt = mysqli_prepare($db, $sql); // prepare sql statement
    mysqli_stmt_bind_param($stmt, "ss", $email, $password); // bind parameters with variables
    mysqli_stmt_execute($stmt); // 執行 SQL
    $result = mysqli_stmt_get_result($stmt); // get result
    
    return $result;
}

function get_running_activity_detail($id) {
    global $db;
    $sql = "SELECT `name`, `place`, `date` FROM `running_activity` WHERE `running_ID` = ?";
    $stmt = mysqli_prepare($db, $sql); // prepare sql statement
    mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
    mysqli_stmt_execute($stmt); // 執行 SQL
    $result = mysqli_stmt_get_result($stmt); // get result

    return $result;
}

function get_running_group_detail($id) {
    global $db;
    $sql = "SELECT `group_name`, `amount`, `maximum_number`, `start_time`, `end_time` FROM `running_group` WHERE `running_ID` = ?";
    $stmt = mysqli_prepare($db, $sql); // prepare sql statement
    mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
    mysqli_stmt_execute($stmt); // 執行 SQL
    $result = mysqli_stmt_get_result($stmt); // get result
    
    return $result;
}

function get_gift_detail($id) {
    global $db;
    $sql = "SELECT `gift_name` FROM `gift` WHERE `running_ID` = ?";
    $stmt = mysqli_prepare($db, $sql); // prepare sql statement
    mysqli_stmt_bind_param($stmt, "s", $id); // bind parameters with variables
    mysqli_stmt_execute($stmt); // 執行 SQL
    $result = mysqli_stmt_get_result($stmt); // get result
    
    return $result;
}
?>