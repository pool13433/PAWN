<?php

session_start();
include '../database/connect.php';
$mem_id = $_POST['mem_id'];
$mem_username = $_POST['mem_username'];
$mem_password = $_POST['mem_password'];
$mem_fname = $_POST['mem_fname'];
$mem_lname = $_POST['mem_lname'];
$mem_idcard = $_POST['mem_idcard'];
$mem_age = $_POST['mem_age'];
$mem_gender = $_POST['mem_gender'];
$mem_mobile = $_POST['mem_mobile'];
$mem_email = $_POST['mem_email'];
$mem_address = $_POST['mem_address'];
$mem_status = $_POST['mem_status'];
$href = $_POST['href'];

$authen = $_SESSION['member'];
$_id = $authen['mem_id'];

if (empty($mem_id)) { // NEW
    $sql = "INSERT INTO `member`(`mem_username`, `mem_password`, `mem_fname`, ";
    $sql .= " `mem_lname`, `mem_idcard`, `mem_age`, `mem_gender`, `mem_mobile`, ";
    $sql .= " `mem_email`, `mem_address`, `mem_status`, `create_date`, `create_by`) ";
    $sql .= " VALUES ('$mem_username',md5('$mem_password'),'$mem_fname' ,";
    $sql .= " '$mem_lname','$mem_idcard',$mem_age,'$mem_gender','$mem_mobile', ";
    $sql .= " '$mem_email','$mem_address','$mem_status',NOW(),$_id)";
} else { //EDIT
    $sql = "UPDATE `member` SET ";
    $sql .= " `mem_username`='$mem_username',`mem_password`=md5('$mem_password'),`mem_fname`='$mem_fname', ";
    $sql .= " `mem_lname`='$mem_lname',`mem_idcard`='$mem_idcard',`mem_age`=$mem_age,`mem_gender`='$mem_gender',";
    $sql .=" `mem_mobile`='$mem_mobile',`mem_email`='$mem_email',`mem_address`='$mem_address',`mem_status`='$mem_status',";
    $sql .= " `create_date`=NOW(),`create_by`=$_id ";
    $sql .=" WHERE `mem_id`=$mem_id";
}
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . ' sql =' . $sql);
if ($query) {
    echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
} else {
    echo 'ไม่สามารถบันทึกข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'' . (empty($href) ? 'member-list.php' : $href) . '\'" />';

