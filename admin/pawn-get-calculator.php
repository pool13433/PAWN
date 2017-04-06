<?php

header('Content-Type: application/json');
include '../database/connect.php';
$pawn_price = $_POST['pawn_price'];
$sql = "SELECT `int_id`, `int_money_begin`, `int_money_end`, `int_duration`, `int_value`, ";
$sql .= " ROUND((($pawn_price * int_value) / 100)) as int_cal,";
$sql .= " ROUND(((($pawn_price * int_value) / 100)+$pawn_price)) as pawn_total,";
$sql .= " DATE_FORMAT(DATE_ADD(curdate(),INTERVAL int_duration DAY),'%d-%m-%Y') as pawn_date_end";
$sql .= " FROM `interest` WHERE int_money_begin <= $pawn_price AND int_money_end >= $pawn_price";
//var_dump($sql);
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
$interest = mysqli_fetch_assoc($query);
mysqli_close($conn);
echo json_encode($interest);
exit();
