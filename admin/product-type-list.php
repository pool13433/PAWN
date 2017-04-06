<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$sql = "SELECT `type_id`, `type_name`, `type_desc`, DATE_FORMAT(create_date,'%d-%m-%Y') create_date, `create_by` FROM `product_type` ORDER BY type_name";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
<fieldset>
    <legend><img src="../images/menus/crud-type.png"/></legend>
    <a href="product-type-form.php">เพิ่มรายการประเภทสินค้าจำนำ</a>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อประเภทสินค้า</th>
                <th>รายละเอียดประเภทสินค้า</th>
                <th>วันที่แก้ไข</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $auto = 1;
            while ($row = mysqli_fetch_array($query)) {
                $type_id = $row['type_id'];
                ?>
                <tr>
                    <td><?= $auto ?></td>
                    <td><?= $row['type_name'] ?></td>
                    <td><?= $row['type_desc'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><a href="product-type-form.php?id=<?=$type_id?>">แก้ไข</a></td>
                    <td><a href="product-type-delete.php?id=<?=$type_id?>" onclick="return confirm('ยืนยันการลบข้อมูลนี้ ตกลง || ยกเลิก')">ลบ</a></td>
                </tr>
                <?php
                $auto++;
            }
            ?>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>