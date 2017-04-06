<?php

include '../database/connect.php';
$case = (empty($_GET['case']) ? '' : $_GET['case']);
$sql = "DELETE FROM pawn WHERE pawn_id = " . $_GET['id'];
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if ($query) {
    echo 'ลบข้อมูลเรียบร้อยแล้ว';
} else {
    echo 'ไม่สามารถลบข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'pawn-list.php?case='.$case.'\'" />';
