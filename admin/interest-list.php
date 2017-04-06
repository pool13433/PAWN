<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$sql = "SELECT `int_id`, FORMAT(int_money_begin,0) int_money_begin, FORMAT(int_money_end,0) int_money_end, ";
$sql .= " `int_duration`, `int_value`, DATE_FORMAT(create_date,'%d-%m-%Y') create_date, `create_by` FROM `interest` ";
$sql .= " ORDER BY int_value";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
<fieldset>
    <legend><img src="../images/menus/crud-interest.png"/></legend>
    <a href="interest-form.php">เพิ่มรายการดอกเบี้ย</a>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ค่าดอกเบี้ย (%)</th>
                <th>จำนวนเงินเริ่ม (บาท)</th>
                <th>จำนวนเงินสิ้นสุด (บาท)</th>
                <th>ระยะเวลา (วัน)</th>
                <th>วันที่แก้ไข</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $auto = 1;
            while ($row = mysqli_fetch_array($query)) {
                $int_id = $row['int_id'];
                ?>
                <tr>
                    <td><?= $auto ?></td>
                    <td align="center"><?= $row['int_value'] ?></td>
                    <td align="center"><?= $row['int_money_begin'] ?></td>
                    <td align="center"><?= $row['int_money_end'] ?></td>
                    <td align="center"><?= $row['int_duration'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><a href="interest-form.php?id=<?=$int_id?>">แก้ไข</a></td>
                    <td><a href="interest-delete.php?id=<?=$int_id?>" onclick="return confirm('ยืนยันการลบข้อมูลนี้ ตกลง || ยกเลิก')">ลบ</a></td>
                </tr>
                <?php
                $auto++;
            }
            ?>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>