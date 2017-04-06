<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$news_id = empty($_GET['id']) ? '' : $_GET['id'];
$news_title = $news_date_start = $news_date_end = $news_desc = "";
if (!empty($news_id)) {
    $sql = "SELECT `news_id`, `news_title`, `news_desc`, ";
    $sql .= " DATE_FORMAT(news_date_start,'%d-%m-%Y') news_date_start, DATE_FORMAT(news_date_end,'%d-%m-%Y') news_date_end, ";
    $sql .= "  `create_date`, `create_by`";
    $sql .= " FROM `news` WHERE news_id = ".$news_id;
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    $news_date_end = $result['news_date_end'];
    $news_date_start = $result['news_date_start'];
    $news_desc = $result['news_desc'];
    $news_title = $result['news_title'];
    $news_id = $result['news_id'];
}
?>
<fieldset>
    <legend>ฟอร์มจัดการข่าวสารประชาสัมพันธ์</legend>
    <a href="news-list.php">ย้อนกลับ</a>
    <form name="news" action="news-save.php" method="POST">
        <input type="hidden" name="news_id" value="<?= $news_id ?>"/>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>หัวข้อข่าว <span class="require">*</span></label></td>
                    <td width="85%" colspan="3">
                        <input type="text" style="width: 100%" name="news_title" value="<?= $news_title ?>" required/>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;"><label>รายละเอียดข่าว <span class="require">*</span></label></td>
                    <td colspan="3">
                        <textarea style="width: 100%;" rows="5" name="news_desc"><?=$news_desc?></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="15%"><label>วันที่เริ่มเผยแพร่ <span class="require">*</span></label></td>
                    <td width="35%"><input type="text" class="datepicker" name="news_date_start" value="<?= $news_date_start ?>" required/></td>
                    <td width="15%"><label>ถึง <span class="require">*</span></label></td>
                    <td width="35%"><input type="text" class="datepicker" name="news_date_end" value="<?= $news_date_end ?>" required/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="บันทึก" /></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </form>


</fieldset>
<?php include '../include/inc_footer.php'; ?>