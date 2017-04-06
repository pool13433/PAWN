<?php include '../include/inc_header.php'; ?>
<?php
$date_return_begin = (empty($_GET['date_return_begin']) ? '' : $_GET['date_return_begin']);
$date_return_end = (empty($_GET['date_return_end']) ? '' : $_GET['date_return_end']);
?>
<fieldset>
     <legend><img src="../images/menus/report-pawn.png"/></legend>
    <form name="pawn-return">
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>วันที่ไถ่ถอน</label></td>
                    <td width="35%"><input type="text" class="datepicker" name="date_return_begin" value="<?= $date_return_begin ?>"/></td>
                    <td width="15%"><label>ถึง</label></td>
                    <td width="35%"><input type="text" class="datepicker"  name="date_return_end" value="<?= $date_return_end ?>"/></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="action" value="submit"/></td>
                    <td><input type="submit" value="ค้นหารายงาน" /></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </form>
    <hr/>
    <?php
    if (!empty($_GET['action'])) {
        include '../database/connect.php';
        $sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
        $sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";
        $sql .=" (SELECT CONCAT(mem_fname,'  ',mem_lname) FROM member m WHERE m.mem_id = p.mem_id ) as mem_fullname,";
        $sql .= " FORMAT((product_price + ((product_price * int_value)/100)),0) as pawn_total ,";
        $sql .= " int_value ,sta_id,p.int_duration,";
        $sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
        $sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
        $sql .= " DATE_FORMAT(DATE_ADD(p.pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y %h:%i %p') as pawn_date_end,";
        $sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
        $sql .= " p.create_date, p.create_by";
        $sql .= " FROM pawn p ";
        $sql .= " JOIN member m ON m.mem_id = p.mem_id WHERE  sta_id =  ".$_pawn_status['PAWN-FINISH'];

        $date_return_begin = (empty($_GET['date_return_begin']) ? '' : $_GET['date_return_begin']);
        $date_return_end = (empty($_GET['date_return_end']) ? '' : $_GET['date_return_end']);
        if (!empty($date_return_begin) && !empty($date_return_end)) {
            $sql .= " AND pawn_date_return BETWEEN STR_TO_DATE('$date_return_begin','%d-%m-%Y') AND STR_TO_DATE('$date_return_end','%d-%m-%Y')";
        }
        $sql .= " ORDER BY pawn_date_return DESC";
        //echo 'sql : ' . $sql;
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
        ?>
        <div id="export">
            <div style="text-align: center;font-size: 25px;">รายงานรายการไถถอนจํานํา</div>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รหัสตั๋วจำนำ</th>
                        <th>ชื่อลูกค้า</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภท</th>
                        <th>เงินต้น</th>
                        <th>ดอกเบี้ย</th>
                        <th>รวม</th>
                        <th>วันที่จำนำ</th>
                        <th>วันที่สิ้นอายุ</th>
                        <th>วันที่ไถ่ถอน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $auto = 1;
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td align="center"><?= $auto ?></td>
                            <td><?= $row['pawn_code'] ?></td>
                            <td><?= $row['mem_fullname'] ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['type_name'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td align="center"><?= $row['int_value'] ?> %</td>
                            <td><?= $row['pawn_total'] ?></td>
                            <td><?= $row['pawn_date_get'] ?></td>
                            <td><?= $row['pawn_date_end'] ?></td>
                            <td><?= $row['pawn_date_return'] ?></td>
                        </tr>
                        <?php
                        $auto++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="text-align: center;"><input type="submit" value="Export PDF" onclick="exportHtml('export', {title: 'รายงานรายการไถถอนจํานํา_<?= date('d-m-Y') ?>'})"/></div>
        <?php } ?>
</fieldset>
<?php include '../include/inc_footer.php'; ?>

