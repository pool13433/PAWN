<?php

include '../database/connect.php';
$sql = "DELETE FROM pawn_status WHERE sta_id = " . $_GET['id'];
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if ($query) {
    echo 'ลบข้อมูลเรียบร้อยแล้ว';
} else {
    echo 'ไม่สามารถลบข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'pawn-status-list.php\'" />';

