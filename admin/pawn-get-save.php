<?php

session_start();
include '../database/connect.php';
$pawn_status = $_pawn_status['PAWN-PROCESS']; // รอไถ่ถอน
$mem_id = $_POST['mem_id'];
$mem_fullname = $_POST['mem_fullname'];
$mem_idcard = $_POST['mem_idcard'];
$mem_mobile = $_POST['mem_mobile'];
$mem_email = $_POST['mem_email'];

$pawn_id = $_POST['pawn_id'];
$pawn_code = $_POST['pawn_code'];
$product_name = $_POST['product_name'];
$type_id = $_POST['type_id'];
$type_name = $_POST['type_name'];
$product_price = $_POST['product_price'];

$int_value = $_POST['int_value'];
$pawn_total = $_POST['pawn_total'];
$int_duration = $_POST['int_duration'];
$pawn_date_end = $_POST['pawn_date_end'];
$case = $_POST['case'];
$href = $_POST['href'];

$member = $_SESSION['member'];
$_id = $member['mem_id'];

//Uplaod File
$target_dir = "../uploads/product/";
$is_upload = true;
if (!empty($_FILES['product_image'])) {
    $file = $_FILES['product_image'];
    $original_file = $file['name'];
    $imageFileType = pathinfo($original_file, PATHINFO_EXTENSION);
    $product_image = $pawn_code . '.' . $imageFileType;
    $target_file = $target_dir . $product_image;


    if (!empty($file["tmp_name"]) && $file['size'] > 0) {
        if (!empty($pawn_id)) {
            unlink($target_file);
        }
        $is_upload = move_uploaded_file($file["tmp_name"], $target_file);
    } else {
        $product_image = '';
    }
}


if ($is_upload) {

    if (empty($pawn_id)) {
        $sql = "INSERT INTO `pawn`(`pawn_code`, `product_name`, `product_price`, `product_image`, `type_id`, ";
        $sql .= " `int_value`, int_duration, `pawn_date_get`, `pawn_date_return`, pawn_total,`sta_id`, ";
        $sql .=" `mem_id`,`create_date`, `create_by`) ";
        $sql .= " VALUES ('$pawn_code','$product_name',$product_price,'$product_image',$type_id, ";
        $sql .= " $int_value,$int_duration,NOW(),NOW(),$pawn_total,$pawn_status,";
        $sql .= " $mem_id,NOW(),$_id)";
        
        $href .= "&mem_id=".$mem_id;
    } else {
        $sql = "UPDATE pawn SET ";
        $sql .= " product_name = '$product_name',product_price = $product_price,type_id = $type_id ";
        $sql .= " ,int_value = $int_value,int_duration = $int_duration ,pawn_total = $pawn_total";
        $sql .= " ,mem_id = $mem_id,create_date = NOW(),create_by = $_id ";
        if (!empty($product_image)) {
            $sql .= ",product_image = '$product_image' ";
        }
        $sql .= " WHERE pawn_id = " . $pawn_id;
    }
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
    if (empty($pawn_id)) {
        $insert_id = mysqli_insert_id($conn);
    } else {
        $insert_id = $pawn_id;
    }

    if ($query) {
        //echo 'บันทึกข้อมูลการจำนำเลขตั๋ว ' . $pawn_code . 'เข้าระบบเรียบร้อยแล้ว';
        $sql = "SELECT product_image,FORMAT(pawn_total,0) as pawn_total,FORMAT(product_price,0) as product_price  FROM pawn WHERE pawn_id = " . $insert_id;
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
        $pawn = mysqli_fetch_assoc($query);

        $product_image = $pawn['product_image'];
        $pawn_total = $pawn['pawn_total'];
        $product_price = $pawn['product_price'];
        if (empty($pawn_id)) {
            include './pawn-get-print.php';
        } else {
            echo 'บันทึกการแก้ไขข้อมูลการจำนำสำเร็จ';
        }
    } else {
        echo 'ไม่สามารถบันทึกข้อมูลได้';
    }
    echo '<meta http-equiv="refresh" content="2; URL=\'' . $href . '\'" />';
} else {
    echo "ไม่สามารถอัพโหลดไฟล์รูปภาพสินค้าเข้าระบบได้";
    //echo '<meta http-equiv="refresh" content="2; URL=\'pawn-get-form.php\'" />';
}

