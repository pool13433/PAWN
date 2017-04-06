<?php

session_start();
include '../database/connect.php';

if (!empty($_POST)) {
    $pawn_deal_interest_duration = $_POST['pawn_deal_interest_duration'];
    $pawn_deal_interest_value = $_POST['pawn_deal_interest_value'];
    $pawn_pay = $_POST['pawn_pay'];
    $pawn_deal_interest = $_POST['pawn_deal_interest'];
    $pawn_deal_total = $_POST['pawn_deal_total'];
    $pawn_deal_date = $_POST['pawn_deal_date'];

    $pawn_id = $_POST['pawn_id'];
    $href = $_POST['href'];
    $member = $_SESSION['member'];
    $mem_id = $member['mem_id'];

    $sta_id = $_pawn_status['PAWN-REDUCE']; // จ่ายเงินลดดอก หรือต่อระยะเวลา
    //1. insert pawn_transaction
    $tran_type = 'DEAL';
    $sql = "INSERT INTO `pawn_tran`(`pawn_id`, `tran_pay`, `tran_type`, `int_duration`, ";
    $sql .= " `int_value`, `tran_total`, `create_date`, `create_by`) VALUES ";
    $sql .= " ($pawn_id,$pawn_pay,'$tran_type',$pawn_deal_interest_duration,";
    $sql .= " $pawn_deal_interest_value,$pawn_deal_total,NOW(),$mem_id)";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    if ($query) {
        // 2. update pawn status 
        $sql = "UPDATE pawn SET sta_id = $sta_id,pawn_date_reduce = NOW() WHERE pawn_id = " . $pawn_id;
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($query) {
            $sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
            $sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";

            $sql .= " p.int_value ,p.sta_id,p.type_id,p.int_duration,";
            $sql .= " FORMAT(p.pawn_pay,0) as pawn_pay,FORMAT(p.pawn_total,0) as pawn_total,";
            $sql .= " FORMAT((p.pawn_total - p.pawn_pay),0) as pawn_pending,";

            $sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
            $sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
            $sql .= " DATE_FORMAT(pawn_date_reduce,'%d-%m-%Y %h:%i %p') pawn_date_reduce,  ";
            $sql .= " DATE_FORMAT(DATE_ADD(pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y') as pawn_date_end,";
            $sql .= " DATE_FORMAT(DATE_ADD(pawn_date_get,INTERVAL (int_duration) DAY),'%d-%m-%Y') as pawn_date_end_new,";
            $sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
            $sql .= " p.create_date, p.create_by,p.mem_id,";
            $sql .= " CONCAT(m.mem_fname,' ',m.mem_lname) as mem_fullname,m.mem_mobile,m.mem_email,m.mem_idcard ";
            $sql .= " FROM pawn p JOIN member m ON m.mem_id = p.mem_id";
            $sql .= " WHERE p.pawn_id = " . $pawn_id;
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
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
            $pawn_pending = $pawn['pawn_pending'];
            $int_duration = $pawn['int_duration'];
            $pawn_date_end = $pawn['pawn_date_end'];
            $pawn_date_end_new = $pawn['pawn_date_end_new'];
            $pawn_date_get = $pawn['pawn_date_get'];
            $pawn_date_return = $pawn['pawn_date_return'];
            $pawn_date_reduce = $pawn['pawn_date_reduce'];
            $product_image = $pawn['product_image'];
            //$pawn_day = $pawn['pawn_day'];
            //echo 'บันทึกข้อมูลการไถ่ถอนสินค้าเรียบร้อยแล้ว';
            include './pawn-reduce-print.php';
        } else {
            echo 'ไม่สามารถบันทึกข้อมูลการไถ่ถอนสินค้าได้';
        }
    }else{
        echo 'ไม่สามารถบันทึกข้อมูลการไถ่ถอนสินค้าได้';
    }
    echo '<meta http-equiv="refresh" content="2; URL=\''.$href.'\'" />';
}
    
    
    