<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$date_return_begin = (empty($_GET['date_return_begin']) ? '' : $_GET['date_return_begin']);
$date_return_end = (empty($_GET['date_return_end']) ? '' : $_GET['date_return_end']);
$type_id = (empty($_GET['type_id']) ? '' : $_GET['type_id']);
$sta_id = (empty($_GET['sta_id']) ? '' : $_GET['sta_id']);
?>
<fieldset>
    <legend><img src="../images/menus/report-product.png"/></legend>
    <form name="pawn-return">
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>ประเภทสินค้า</label></td>
                    <td width="35%">
                        <?php
                        $type_sql = "SELECT `type_id`, `type_name` FROM `product_type` ORDER BY type_name ASC";
                        $type_query = mysqli_query($conn, $type_sql) or die(mysqli_error($conn) . 'sql : ' . $type_sql);
                        ?>
                        <select name="type_id">
                            <option value="">-- เลือกประเภทสินค้า --</option>
                            <?php while ($type = mysqli_fetch_array($type_query)) { ?>
                                <?php if ($type['type_id'] == $type_id) { ?>
                                    <option value="<?= $type['type_id'] ?>" data-name="<?= $type['type_name'] ?>" selected><?= $type['type_name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $type['type_id'] ?>" data-name="<?= $type['type_name'] ?>"><?= $type['type_name'] ?></option>
                                <?php } ?>    
                            <?php } ?>
                        </select>
                    </td>
                    <td width="15%"><label>สถานะของสินค้า</label></td>
                    <td width="35%">
                        <?php
                        $sta_sql = "SELECT `sta_id`, `sta_desc` FROM `pawn_status` ORDER BY sta_desc ASC";
                        $sta_query = mysqli_query($conn, $sta_sql) or die(mysqli_error($conn) . 'sql : ' . $sta_sql);
                        ?>
                        <select name="sta_id">
                            <option value="">-- เลือกสถานะของสินค้า --</option>
                            <?php while ($status = mysqli_fetch_array($sta_query)) { ?>
                                <?php if ($status['sta_id'] == $sta_id) { ?>
                                    <option value="<?= $status['sta_id'] ?>"  selected><?= $status['sta_desc'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $status['sta_id'] ?>" ><?= $status['sta_desc'] ?></option>
                                <?php } ?>    
                            <?php } ?>
                        </select>
                    </td>
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
        $sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
        $sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";
        $sql .=" (SELECT sta_desc FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_desc, ";
        $sql .=" (SELECT CONCAT(mem_fname,'  ',mem_lname) FROM member m WHERE m.mem_id = p.mem_id ) as mem_fullname,";
        $sql .= " FORMAT((product_price + ((product_price * int_value)/100)),0) as pawn_total ,";
        $sql .= " int_value ,sta_id,p.int_duration,";
        $sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
        $sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
        $sql .= " DATE_FORMAT(DATE_ADD(p.pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y %h:%i %p') as pawn_date_end,";
        $sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
        $sql .= " DATE_FORMAT(p.create_date,'%d-%m-%Y %h:%i %p') as create_date , p.create_by";
        $sql .= " FROM pawn p ";
        $sql .= " JOIN member m ON m.mem_id = p.mem_id WHERE 1=1 ";

        $date_return_begin = (empty($_GET['date_return_begin']) ? '' : $_GET['date_return_begin']);
        $date_return_end = (empty($_GET['date_return_end']) ? '' : $_GET['date_return_end']);
        if (!empty($date_return_begin) && !empty($date_return_end)) {
            $sql .= " AND pawn_date_return BETWEEN STR_TO_DATE('$date_return_begin','%d-%m-%Y') AND STR_TO_DATE('$date_return_end','%d-%m-%Y')";
        }
        if (!empty($type_id)) {
            $sql .= " AND type_id = $type_id";
        }
        if(!empty($sta_id)){
            $sql .= " AND sta_id = $sta_id";
        }
        $sql .= " ORDER BY sta_id,type_id ASC";
        //echo 'sql : ' . $sql;
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
        ?>
        <div id="export">
            <div style="text-align: center;font-size: 25px;">รายงานสินคาในระบบ</div>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภท</th>
                        <th>ราคาสินค้า</th>
                        <th>สถานะสินค้า</th>
                        <th>วันที่จำนำ</th>
                        <th>วันที่ตั๋วหมดอายุ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $auto = 1;
                    while ($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td align="center"><?= $auto ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['type_name'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td><?= $row['sta_desc'] ?></td>
                            <td><?= $row['pawn_date_get'] ?></td>
                            <td><?= $row['pawn_date_end'] ?></td>
                        </tr>
                        <?php
                        $auto++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="text-align: center;"><input type="submit" value="Export PDF" onclick="exportHtml('export', {title: 'รายงานสินคาหลุดจํานํา_<?= date('d-m-Y') ?>'})"/></div>
        <?php } ?>
</fieldset>
<?php include '../include/inc_footer.php'; ?>
