<?php

session_start();
include '../database/connect.php';
if (!empty($_POST)) {
    $pawn_id = $_POST['pawn_id'];
    $pawn_pay = $_POST['pawn_pay'];

    $member = $_SESSION['member'];
    $mem_id = $member['mem_id'];
    $sta_id = $_pawn_status['PAWN-FINISH']; // ไถ่ถอนสินค้า เรียบร้อย

    $sql = "UPDATE pawn SET pawn_date_return = NOW(),pawn_pay = $pawn_pay,create_date = NOW(),create_by = $mem_id , sta_id = $sta_id ";
    $sql .= " WHERE pawn_id = " . $pawn_id;
    
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ');
    if ($query) {
        $sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
        $sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";        
        $sql .= " p.int_value ,p.sta_id,p.type_id,p.int_duration,";
        $sql .= " FORMAT(p.pawn_pay,0) as pawn_pay,";
        $sql .= " FORMAT(p.pawn_total,0) as pawn_total,";
        $sql .= " FORMAT((p.pawn_total - p.pawn_pay),0) as pawn_money,";        
        $sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
        $sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return, ";
        $sql .= " DATE_FORMAT(DATE_ADD(pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y') as pawn_date_end,";        
        $sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
        $sql .= " p.create_date, p.create_by,p.mem_id,";
        $sql .= " CONCAT(m.mem_fname,' ',m.mem_lname) as mem_fullname,m.mem_mobile,m.mem_email,m.mem_idcard ";
        $sql .= " FROM pawn p JOIN member m ON m.mem_id = p.mem_id";
        $sql .= " WHERE p.pawn_id = " . $pawn_id;
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn).'sql : '.$sql);
        $pawn = mysqli_fetch_assoc($query);

        $pawn_status = $pawn['sta_id'];
        $mem_id = $pawn['mem_id'];
        $mem_fullname = $pawn['mem_fullname'];
        $mem_idcard = $pawn['mem_idcard'];
        $mem_mobile = $pawn['mem_mobile'];
        $mem_email = $pawn['mem_email'];

        $pawn_code = $pawn['pawn_code'];
        $product_name = $pawn['product_name'];
        $type_id = $pawn['type_id'];
        $type_name = $pawn['type_name'];
        $product_price = $pawn['product_price'];
        $pawn_pay = $pawn['pawn_pay'];
        $int_value = $pawn['int_value'];
        $pawn_total = $pawn['pawn_total'];
        $pawn_money = $pawn['pawn_money'];
        $int_duration = $pawn['int_duration'];
        $pawn_date_end = $pawn['pawn_date_end'];
        $pawn_date_get = $pawn['pawn_date_get'];
        $pawn_date_return = $pawn['pawn_date_return'];
        
        $product_image = $pawn['product_image'];

        //echo 'บันทึกข้อมูลการไถ่ถอนสินค้าเรียบร้อยแล้ว';
        include './pawn-return-print.php';
    } else {
        echo 'ไม่สามารถบันทึกข้อมูลการไถ่ถอนสินค้าได้';
    }
    echo '<meta http-equiv="refresh" content="2; URL=\'pawn-list.php?case=return\'" />';
}