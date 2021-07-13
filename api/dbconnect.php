<?php
/*
連線資料庫用的副程式
*/
$host = 'localhost'; // 執行 DB Server 的主機
$user = 'id16081463_root'; // 登入 DB 用的 DB 帳號
$pass = 'Zrdyy1w5kZn*mUEc'; // 登入 DB 用的 DB 密碼
$dbName = 'id16081463_run'; // 使用的資料庫名稱

/* $db 即為未來執行 SQL 指令所使用的物件 */
$db = mysqli_connect($host, $user, $pass, $dbName) or die('Error with MySQL connection'); // 跟 MyMSQL 連線並登入

mysqli_query($db, "SET NAMES utf8"); // 設定編碼為 unicode utf8
// echo "connect success"; // 確認連線
?>