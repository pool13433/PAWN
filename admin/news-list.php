<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$sql = "SELECT `news_id`, `news_title`, `news_desc`, ";
$sql .= " DATE_FORMAT(news_date_start,'%d-%m-%Y') news_date_start, DATE_FORMAT(news_date_end,'%d-%m-%Y') news_date_end, ";
$sql .= "  `create_date`, `create_by`";
$sql .= " FROM `news` ORDER BY news_date_start";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
<fieldset>
    <legend><img src="../images/menus/crud-news.png"/></legend>
    <a href="news-form.php">เพิ่มรายการข่าวสารประชาสัมพันธ์</a>
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
                $news_id = $row['news_id'];
                ?>
                <tr>
                    <td><?= $auto ?></td>
                    <td><?= $row['news_title'] ?></td>
                    <td><?= $row['news_desc'] ?></td>
                    <td align="center"><?= $row['news_date_start'] ?></td>
                    <td align="center"><?= $row['news_date_end'] ?></td>
                    <td><?= $row['create_date'] ?></td>
                    <td><a href="news-form.php?id=<?=$news_id?>">แก้ไข</a></td>
                    <td><a href="news-delete.php?id=<?=$news_id?>" onclick="return confirm('ยืนยันการลบข้อมูลนี้ ตกลง || ยกเลิก')">ลบ</a></td>
                </tr>
                <?php
                $auto++;
            }
            ?>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>