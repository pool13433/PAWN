<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
// query pawn 
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
$sql .= " WHERE p.mem_id = $mem_id ";
$sql .= " ORDER BY p.pawn_id DESC";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
?>
<fieldset>
    <legend><img src="../images/menus/customer-pawn-title.png"/></legend>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>ชื่อสินค้า</th>
                <th>ราคา</th>
                <th>ระยะเวลา</th>
                <th>วันที่จำนำ</th>
                <th>วันไถ่ถอน</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $auto = 1;
            while ($row = mysqli_fetch_array($query)) {
                $pawn_id = $row['pawn_id'];
                $status = $row['sta_id'];
                ?>
                <tr>
                    <td>
                        <img src="../uploads/product/<?= $row['product_image'] ?>" style="max-width: 120px;"/>
                        <?= $row['pawn_code'] ?>
                    </td>
                    <td align="center"><?= $row['product_name'] ?></td>
                    <td align="center"><?= $row['product_price'] ?></td>
                    <td align="center"><?= $row['int_duration'] ?></td>
                    <td><?= $row['pawn_date_get'] ?></td>
                    <td><?= $row['pawn_date_end'] ?></td>
                    <td><?= $row['sta_name'] ?></td>
                </tr>
                <?php
                $auto++;
            }
            ?>
        </tbody>
    </table>
</fieldset>
<?php include '../include/inc_footer.php'; ?>