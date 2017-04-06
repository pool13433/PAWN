<?php
session_start();
include '../database/connect.php';
$news_id = $_POST['news_id'];
$news_title = $_POST['news_title'];
$news_desc = $_POST['news_desc'];
$news_date_start = $_POST['news_date_start'];
$news_date_end = $_POST['news_date_end'];
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
//var_dump($_POST);
//exit();
if(empty($news_id)){ // NEW
    $sql = "INSERT INTO `news`(`news_title`, `news_desc`, `news_date_start`, `news_date_end`, `create_date`, `create_by`) ";
    $sql .= " VALUES ('$news_title','$news_desc',STR_TO_DATE('$news_date_start','%d-%m-%Y'),STR_TO_DATE('$news_date_end','%d-%m-%Y'),NOW(),$mem_id)";
}else{ //EDIT
    $sql = "UPDATE `news` SET ";
    $sql .= " `news_title`='$news_title',`news_desc`='$news_desc',";
    $sql .= " `news_date_start`=STR_TO_DATE('$news_date_start','%d-%m-%Y'),`news_date_end`=STR_TO_DATE('$news_date_end','%d-%m-%Y'),";
    $sql .=" `create_date`=NOW(),`create_by`=$mem_id ";
    $sql .= " WHERE `news_id`=$news_id";
}
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if($query){
    echo 'บันทึกข้อมูลเรียบร้อยแล้ว';
}else{
   echo 'ไม่สามารถบันทึกข้อมูลได้';
}
echo '<meta http-equiv="refresh" content="2; URL=\'news-list.php\'" />';

