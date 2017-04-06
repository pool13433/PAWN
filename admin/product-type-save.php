<?php
session_start();
include '../database/connect.php';
$type_id = $_POST['type_id'];
$type_name = $_POST['type_name'];
$type_desc = $_POST['type_desc'];
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
//var_dump($_POST);
//exit();
if(empty($type_id)){ // NEW
    $sql = "INSERT INTO `product_type`(`type_name`, `type_desc`, `create_date`, `create_by`) ";
    $sql .= " VALUES ('$type_name','$type_desc',NOW(),$mem_id)";
}else{ //EDIT
    $sql = "UPDATE `product_type` SET ";
    $sql .= " `type_name`='$type_name',`type_desc`='$type_desc',`create_date`=NOW(),`create_by`=$mem_id ";
    $sql .= " WHERE `type_id`=$type_id";
}
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if($query){
    echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
}else{
   echo 'ไม่สามารถบันทึกข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'product-type-list.php\'" />';

