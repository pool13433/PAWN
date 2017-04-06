<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$type_id = (empty($_GET['type_id']) ? '' : $_GET['type_id']);
$sort_by = (empty($_GET['sort_by']) ? '' : $_GET['sort_by']);
$scope = (empty($_GET['scope']) ? '' : $_GET['scope']);
$free_search = (empty($_GET['free_search']) ? '' : $_GET['free_search']);

$sorts = array(
    'product_price ASC' => 'ราคาน้อย ไป มาก',
    'product_price DESC' => 'ราคามาก ไป น้อย',
    //'DATE_ADD(CURDATE(),INTERVAL int_duration DAY) ASC' => 'วันที่ขายถอนตลาดปัจจุบัน ไป อดีต',
    //'DATE_ADD(CURDATE(),INTERVAL int_duration DAY) DESC' => 'วันที่ขายถอนตลาดอดีต มา ปัจจุบัน',
    'create_date ASC' => 'วันที่ขายถอนตลาดปัจจุบัน ไป อดีต',
    'create_date DESC' => 'วันที่ขายถอนตลาดอดีต มา ปัจจุบัน',
);

$sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
$sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";
$sql .=" (SELECT CONCAT(mem_fname,'  ',mem_lname) FROM member m WHERE m.mem_id = p.mem_id ) as mem_fullname,";
$sql .= " int_value ,sta_id,";
$sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
$sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
$sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
$sql .= " DATE_FORMAT(create_date,'%d-%m-%Y') as create_date, `create_by`";
$sql .= " FROM pawn p WHERE sta_id IN (7)";
if ($scope == 'today') {
    $sql .= " AND p.create_date = CURDATE()";
}
if (!empty($type_id)) {
    $sql .= " AND type_id = " . $type_id;
}
if (!empty($free_search)) {
    $sql .= " AND (product_name LIKE '%$free_search%' OR product_price = $free_search )";
}
if (!empty($sort_by)) {
    $sql .= " ORDER BY $sort_by ";
} else {
    $sql .= " ORDER BY pawn_id DESC";
}
//echo 'sql : ' . $sql;
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
$count = mysqli_num_rows($query);
$rows = array();
$columns = array();
$col = 1;
while ($row = mysqli_fetch_array($query)) {
    $columns[] = $row;
    if ($col == 3) {
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
    <legend>แสดงรายการสินค้าที่หลุดจำนำ จากทางร้าน (<?= $count ?>) ชิ้น</legend>
    <form style="float: right" method="get">     
        <input type="hidden" name="scope" value="<?= (empty($_GET['scope']) ? '' : $_GET['scope']) ?>"/>
        <label>กรอกข้อมูลสินค้า </label>
        <input type="text" name="free_search" value="<?= (empty($free_search) ? '' : $free_search) ?>" />
        <label>ประเภทสินค้า </label>
        <?php
        $type_sql = "SELECT `type_id`, `type_name` FROM `product_type` ORDER BY type_name ASC";
        $type_query = mysqli_query($conn, $type_sql) or die(mysqli_error($conn) . 'sql : ' . $type_sql);
        ?>
        <select name="type_id">
            <option value=""> -- ทั้งหมด --</option>
            <?php while ($type = mysqli_fetch_array($type_query)) { ?>
                <?php if ($type['type_id'] == $type_id) { ?>
                    <option value="<?= $type['type_id'] ?>" selected><?= $type['type_name'] ?></option>
                <?php } else { ?>
                    <option value="<?= $type['type_id'] ?>"><?= $type['type_name'] ?></option>
                <?php } ?>
            <?php } ?>
        </select> || 
        <label>เรียงข้อมูล </label>
        <select name="sort_by">
            <option value=""> -- ปกติ --</option>
            <?php foreach ($sorts as $key => $sort) { ?>
                <?php if ($sort_by == $key) { ?>
                    <option value="<?= $key ?>" selected> <?= $sort ?></option>
                <?php } else { ?>
                    <option value="<?= $key ?>"> <?= $sort ?></option>
                <?php } ?>
            <?php } ?>
        </select>
        <input type="submit" value="ค้นหา" />
    </form>
    <table border="1" style="width: 100%">
        <tbody>
            <?php foreach ($rows as $index => $row) { ?>
                <tr>
                    <?php foreach ($row as $index => $col) { ?>
                        <td>
                            <table width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td rowspan="3" style="vertical-align: top;width: 65%">                                            
                                            <img src="../uploads/product/<?= $col['product_image'] ?>" style="max-width: 150px;"/>
                                        </td>
                                        <td>ชื่อ <?= $col['product_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>ประเภท <?= $col['type_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>ราคา <?= $col['product_price'] ?> บาท</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: bottom"><strong style="background-color: yellow">สถานะสินค้า <?= $col['sta_name'] ?></strong></td>
                                        <td>วันที่อัพเดทข้อมูล <br/><?= $col['create_date'] ?></td>
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