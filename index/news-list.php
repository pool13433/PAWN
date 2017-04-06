<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';

$sql = "SELECT `news_id`, `news_title`, `news_desc`, ";
$sql .= " DATE_FORMAT(news_date_start,'%d-%m-%Y') as news_date_start, DATE_FORMAT(news_date_end,'%d-%m-%Y') as news_date_end, ";
$sql .= " DATE_FORMAT(create_date,'%d-%m-%Y') as create_date, `create_by` FROM `news` ";
$sql .= " WHERE news_date_end >= curdate()";
$sql .= " ORDER BY create_date DESC";

$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
$count = mysqli_num_rows($query);
$rows = array();
$columns = array();
$col = 1;
while ($row = mysqli_fetch_array($query)) {
    $columns[] = $row;
    if ($col == 2) {
        $rows[] = $columns;
        $columns = array();
        $col = 1;
    } else {
        $col++;
    }
}
$rows[] = $columns;
?>
<fieldset>
    <legend>ข่าวประชาสัมพันธ์</legend>    
    <table border="1" style="width: 100%">
        <tbody>
            <?php foreach ($rows as $index => $row) { ?>
                <tr>
                    <?php foreach ($row as $index => $col) { ?>
                        <td>
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="font-size: xx-large;">
                                                <?= $col['news_title'] ?>
                                            </div>
                                            <div style="font-size: x-large;">
                                                <?= $col['news_desc'] ?>
                                            </div>                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            ข่าวเมื่อวันที่<?= $col['create_date'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            อายุข่าว <?= $col['news_date_start'] ?> ถึง
                                            <?= $col['news_date_end'] ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>