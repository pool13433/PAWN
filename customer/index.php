<?php include '../include/inc_header.php'; ?>
<?php 
include '../database/connect.php';
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
$sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
$sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";
$sql .=" (SELECT CONCAT(mem_fname,'  ',mem_lname) FROM member m WHERE m.mem_id = p.mem_id ) as mem_fullname,";
$sql .= " int_value ,sta_id,p.int_duration,";
$sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
$sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
$sql .= " DATE_FORMAT(DATE_ADD(p.pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y %h:%i %p') as pawn_date_end,";
$sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
$sql .= " p.create_date, p.create_by";
$sql .= " FROM pawn p ";
$sql .= " JOIN member m ON m.mem_id = p.mem_id ";
$sql .= " WHERE p.mem_id = $mem_id ORDER BY p.create_date DESC LIMIT 0,1";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn).'sql :: '.$sql);
$pawn = mysqli_fetch_assoc($query);
?>
<fieldset>
    <legend>Dashboard</legend>
    <div style="width: 50%;">
        <fieldset>
            <legend>แจ้งเตือนการจำนำล่าสุด</legend>
            <img src="../uploads/product/<?=$pawn['product_image']?>" style="max-width: 400px"/>
            <div>รหัสใบจำนำ: <?=$pawn['pawn_code']?></div>
            <div>ชื่อสินค้า: <?=$pawn['product_name']?></div>
            <div>ราคาสินค้า: <?=$pawn['product_price']?> บาท</div>
            <div>ประเภท: <?=$pawn['type_name']?></div>
            <div>อัตราดอกเบีี้ย: <?=$pawn['int_value']?> %</div>
             <div>ระยะเวลา: <?=$pawn['int_duration']?> วัน</div>
             <div>วันที่จำนำ: <?=$pawn['pawn_date_get']?> วันสิ้นอายุตั๋ว <?=$pawn['pawn_date_end']?> </div>
        </fieldset>
    </div>
</fieldset>
<?php include '../include/inc_footer.php'; ?>