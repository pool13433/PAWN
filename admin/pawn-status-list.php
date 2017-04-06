<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$sql = "SELECT `sta_id`, `sta_name`, `sta_desc`, DATE_FORMAT(create_date,'%d-%m-%Y') create_date, `create_by` FROM `pawn_status` ORDER BY sta_id";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
<fieldset>
    <legend><img src="../images/menus/crud-status.png"/></legend>
    <!--<a href="pawn-status-form.php">เพิ่มรายการสถานะการจำนำ</a>-->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>รหัสสถานะ</th>
                <th>ชื่อสถานะ</th>
                <th>รายละเอียดสถานะ</th>
                <th>วันที่แก้ไข</th>
                <th>แก้ไข</th>
                <!-- <th>แก้ไข</th>                           -->
            </tr>
        </thead>
        <tbody>
            <?php
            $auto = 1;
            while ($row = mysqli_fetch_array($query)) {
                $sta_id = $row['sta_id'];
                ?>
                <tr>
                    <td style="text-align: center;"><?= $sta_id ?></td>
                    <td><?= $row['sta_name'] ?></td>
                    <td><?= $row['sta_desc'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><a href="pawn-status-form.php?id=<?=$sta_id?>">แก้ไข</a></td>
                    <!--<td><a href="pawn-status-delete.php?id=<?=$sta_id?>" onclick="return confirm('ยืนยันการลบข้อมูลนี้ ตกลง || ยกเลิก')">ลบ</a></td>-->
                </tr>
                <?php
                $auto++;
            }
            ?>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>
