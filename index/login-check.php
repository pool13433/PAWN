<?php
session_start();
include '../database/connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
//var_dump($_POST);
if (empty($username) || empty($password)) {
    echo 'กรุณากรอกข้อมูล username หรือ password';
    echo '<meta http-equiv="refresh" content="1; URL=\'../index/login.php\'" />';
} else {
    $sql = "SELECT * FROM member WHERE mem_username = '" . $username . "' AND mem_password = md5('" . $password . "') ";
    //var_dump($sql);
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    //var_dump($result);
    if ($result) {
        $member = $result;
        $_SESSION['member'] = $member;
        $status = $member['mem_status'];
        echo 'ระบบกำลังพาไปเมนูการใช้งานกรุณารอ....';
        switch ($status) {
            case 'admin':
                echo '<meta http-equiv="refresh" content="1; URL=\'../admin/pawn-form.php?case=create&href=pawn-form.php?case=create\'" />';
                break;
            case 'employee':
                echo '<meta http-equiv="refresh" content="1; URL=\'../employee/\'" />';
                break;
            case 'customer':
                echo '<meta http-equiv="refresh" content="1; URL=\'../customer/\'" />';
                break;
            default:
                break;
        }
    } else {
        echo 'ไม่พบข้อมูลผู้ใช้งาน';
    }
}