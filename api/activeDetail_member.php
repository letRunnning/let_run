<?php
require("memberModel.php");
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id = isset($_GET['running_ID']) ? $_GET['running_ID'] : null;

    if ($id) {
        $activity = get_running_activity_detail($id);
        $group = get_running_group_detail($id);
        $gift = get_gift_detail($id);

        $rs = [];
        $rs1 = [];
        $rs2 = [];
        for ($i = 0; $i < mysqli_num_rows($activity); $i++) {
            $rs[$i] = mysqli_fetch_assoc($activity);
        }
        for ($i = 0; $i < mysqli_num_rows($group); $i++) {
            $rs1[$i] = mysqli_fetch_assoc($group);
        }
        for ($i = 0; $i < mysqli_num_rows($gift); $i++) {
            $rs2[$i] = mysqli_fetch_assoc($gift);
        }
        echo json_encode(array($rs, $rs1, $rs2));
    }
}
?>