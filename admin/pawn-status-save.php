<?php
session_start();
include '../database/connect.php';
$sta_id = $_POST['sta_id'];
$sta_name = $_POST['sta_name'];
$sta_desc = $_POST['sta_desc'];
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
//var_dump($_POST);
//exit();
if(empty($sta_id)){ // NEW
    $sql = "INSERT INTO `pawn_status`(`sta_name`, `sta_desc`, `create_date`, `create_by`) ";
    $sql .= " VALUES ('$sta_name','$sta_desc',NOW(),$mem_id)";
}else{ //EDIT
    $sql = "UPDATE `pawn_status` SET ";
    $sql .= " `sta_name`='$sta_name',`sta_desc`='$sta_desc',`create_date`=NOW(),`create_by`=$mem_id ";
    $sql .= " WHERE `sta_id`=$sta_id";
}
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if($query){
    echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
}else{
   echo 'ไม่สามารถบันทึกข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'pawn-status-list.php\'" />';

