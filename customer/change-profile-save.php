<?php

session_start();
include '../database/connect.php';

$mem_fname = $_POST['mem_fname'];
$mem_lname = $_POST['mem_lname'];
$mem_idcard = $_POST['mem_idcard'];
$mem_age = $_POST['mem_age'];
$mem_gender = $_POST['mem_gender'];
$mem_mobile = $_POST['mem_mobile'];
$mem_email = $_POST['mem_email'];
$mem_address = $_POST['mem_address'];

$authen = $_SESSION['member'];
$_id = $authen['mem_id'];

$sql = "UPDATE `member` SET ";
$sql .= " `mem_fname`='$mem_fname',`mem_lname`='$mem_lname',`mem_idcard`='$mem_idcard',`mem_age`=$mem_age, ";
$sql .=" `mem_gender`='$mem_gender',`mem_mobile`='$mem_mobile',`mem_email`='$mem_email',`mem_address`='$mem_address', ";
$sql .= " `create_date`=NOW(),`create_by`=$_id ";
$sql .=" WHERE `mem_id`=$_id";

$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . ' sql =' . $sql);
if ($query) {
    $sql = "SELECT * FROM member WHERE mem_id =  ".$_id;    
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    $_SESSION['member'] = $result;
    echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
} else {
    echo 'ไม่สามารถบันทึกข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'dashboard.php\'" />';
