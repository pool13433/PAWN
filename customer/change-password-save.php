<?php

session_start();
include '../database/connect.php';
$password_old = $_POST['password_old'];
$password_new = $_POST['password_new'];
$password_new_confirm = $_POST['password_new_confirm'];
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
$mem_password = $member['mem_password'];

// Check รหัสผ่านเก่าใน ตาราง Member
$sql = "SELECT count(*) as count_user FROM  member WHERE mem_id = $mem_id AND mem_password = md5('$password_old')";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
$count_user = mysqli_fetch_assoc($query)['count_user'];
if ($count_user == 0) {
    echo "กรุณา กรอกรหัสผ่านเก่าให้ถูกต้อง";
    echo '<meta http-equiv="refresh" content="2; URL=\'change-password.php\'" />';
} else {
    if ($password_new != $password_new_confirm) {
        echo 'กรุณา กรอกรหัสผ่านใหม่ให้ตรงกัน';
        echo '<meta http-equiv="refresh" content="2; URL=\'change-password.php\'" />';
    } else {
        $sql = "UPDATE member SET ";
        $sql .= " mem_password = md5('$password_new') ,create_date = NOW(),create_by =  $mem_id";
        $sql .= " WHERE mem_id = $mem_id";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
        if ($query) {
            echo "เปลี่ยนแปลงรหัสปผ่านใหม่ สำเร็จเรียบร้อย";
        } else {
            echo "ไม่สามารถเปลี่ยนรหัสผ่าน กรุณาติดต่อเจ้าหน้าที่";
        }
        echo '<meta http-equiv="refresh" content="2; URL=\'dashboard.php\'" />';
    }
}