<?php

include '../database/connect.php';
if (!empty($_POST)) {
    $sale_waiting = $_pawn_status['SALE-WAITING']; // หลุดจำนำรอขาย
    $pawns = array();
    $pawns = $_POST['pawn'];
    foreach ($pawns as $key => $value) {
        $sql = "UPDATE pawn SET sta_id = $sale_waiting WHERE pawn_id = " . $value;
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
    if ($query) {
        echo 'เปลี่ยนสถานะสินค้าหลุดจำนำไปเป็นสถานะเพื่อรอขายสำเร็จเรียบร้อยแล้ว';
    } else {
        echo 'ไม่สามารถเปลี่ยนสถานะสินค้าหลุดจำนำไปเป็นสถานะเพื่อรอขายได้ กรุณาติดต่อเจ้าหน้าที่';
    }
    
}else{
    echo 'คุณยังไม่ได้เลือกตั๋วจำนำที่ต้องการทำรายการ กรุณาเลือกรายการก่อน';
}
 echo '<meta http-equiv="refresh" content="2; URL=\'pawn-list.php?case=expire\'" />';

