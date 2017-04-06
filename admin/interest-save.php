<?php
session_start();
include '../database/connect.php';
$int_value = $_POST['int_value'];
$int_money_begin = $_POST['int_money_begin'];
$int_money_end = $_POST['int_money_end'];
$int_duration = $_POST['int_duration'];
$int_id = $_POST['int_id'];
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];

if(empty($int_id)){ // NEW
    $sql = "INSERT INTO `interest`(`int_money_begin`, `int_money_end`, `int_duration`, `int_value`, `create_date`, `create_by`) ";
    $sql .= " VALUES ($int_money_begin,$int_money_end,$int_duration,$int_value,NOW(),$mem_id)";
}else{ //EDIT
    $sql = "UPDATE `interest` SET ";
    $sql .= " `int_money_begin`=$int_money_begin,`int_money_end`=$int_money_end,`int_duration`=$int_duration,";
    $sql .= " `int_value`=$int_value,`create_date`=NOW(),`create_by`=$mem_id ";
    $sql .= " WHERE `int_id`=$int_id";
}
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if($query){
    echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
}else{
   echo 'ไม่สามารถบันทึกข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'interest-list.php\'" />';

