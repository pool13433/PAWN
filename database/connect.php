<?php

define("HOSTING", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "db_pawn");

// Create connection
$conn = mysqli_connect(HOSTING, USERNAME, PASSWORD, DATABASE);
// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");

$_mem_status = array('admin' => 'ผู้ดูแลระบบ (admin)', 'customer' => 'ลูกค้า');
$_mem_gender = array('MALE' => 'ชาย', 'FEMALE' => 'หญิง');
$_pawn_status = array(
    'FAIL' => 2,
    'PAWN-PROCESS' => 3,
    'SALE-FINISH' => 5,
    'PAWN-EXPIRE' => 6,
    'SALE-WAITING' => 7,
    'PAWN-REDUCE' => 8,
    'PAWN-FINISH' => 9
);
