<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$sql = "SELECT `mem_id`, `mem_username`, `mem_password`, `mem_fname`, `mem_lname`, `mem_idcard`, ";
$sql .= " `mem_age`, `mem_gender`, `mem_mobile`, `mem_email`, `mem_address`, `mem_status`, `create_by` ";
$sql .= " ,DATE_FORMAT(create_date,'%d-%m-%Y') as create_date";
$sql .= " FROM `member` ORDER BY mem_status,create_date ASC";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
<fieldset>
    <legend><img src="../images/menus/crud-member.png"/></legend>
    <a href="member-form.php">เพิ่มรายการผู้ใช้งาน</a>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>หัวข้อข่าว</th>
                <th>รายละเอียดข่าว</th>
                <th>วันที่เผยแพร่ข่าว</th>
                <th>วันที่สิ้นสุดข่าว</th>
                <th>วันที่แก้ไข</th>
                <th>แก้ไข</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $auto = 1;
            while ($row = mysqli_fetch_array($query)) {
                $mem_id = $row['mem_id'];
                ?>
                <tr>
                    <td><?= $auto ?></td>
                    <td><?= $row['mem_fname'].' '.$row['mem_lname'] ?></td>
                    <td><?= $row['mem_idcard'] ?></td>
                    <td align="center"><?= $row['mem_mobile'] ?></td>
                    <td align="center"><?= $row['mem_email'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><a href="member-form.php?id=<?=$mem_id?>">แก้ไข</a></td>
                    <td><a href="member-delete.php?id=<?=$mem_id?>" onclick="return confirm('ยืนยันการลบข้อมูลนี้ ตกลง || ยกเลิก')">ลบ</a></td>
                </tr>
                <?php
                $auto++;
            }
            ?>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>