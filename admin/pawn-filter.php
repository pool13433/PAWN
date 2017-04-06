<?php
$sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
$sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";
$sql .=" (SELECT CONCAT(mem_fname,'  ',mem_lname) FROM member m WHERE m.mem_id = p.mem_id ) as mem_fullname,";
$sql .= " int_value ,sta_id,p.int_duration,";
$sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
$sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
$sql .= " DATE_FORMAT(DATE_ADD(p.pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y %h:%i %p') as pawn_date_end,";
$sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
$sql .= " p.create_date, p.create_by";
$sql .= " FROM pawn p ";
$sql .= " JOIN member m ON m.mem_id = p.mem_id WHERE  1=1 ";
if (!empty($_GET['mem_fullname'])) {
    $mem_fullname = $_GET['mem_fullname'];
    $sql .= " AND ( m.mem_fname LIKE '%$mem_fullname%' OR m.mem_lname LIKE '%$mem_fullname%') ";
}
if (!empty($_GET['mem_idcard'])) {
    $mem_idcard = $_GET['mem_idcard'];
    $sql .= " AND m.mem_idcard LIKE '%$mem_idcard%' ";
}
if (!empty($_GET['mem_mobile'])) {
    $mem_mobile = $_GET['mem_mobile'];
    $sql .= " AND m.mem_mobile LIKE '%$mem_mobile%' ";
}
if (!empty($_GET['mem_email'])) {
    $mem_email = $_GET['mem_email'];
    $sql .= " AND m.mem_email LIKE '%$mem_email%' ";
}
if (!empty($_GET['pawn_code'])) {
    $pawn_code = $_GET['pawn_code'];
    $sql .= " AND p.pawn_code LIKE '%$pawn_code%' ";
}
if (!empty($_GET['product_name'])) {
    $product_name = $_GET['product_name'];
    $sql .= " AND p.product_name LIKE '%$product_name%' ";
}
if (!empty($_GET['product_price'])) {
    $product_price = $_GET['product_price'];
    $sql .= " AND p.product_price = $product_price ";
}
if (!empty($_GET['type_id'])) {
    $type_id = $_GET['type_id'];
    $sql .= " AND p.type_id = $type_id ";
}
if (!empty($_GET['pawn_total'])) {
    $pawn_total = $_GET['pawn_total'];
    $sql .= " AND p.pawn_total = $pawn_total ";
}
if (!empty($_GET['int_value'])) {
    $int_value = $_GET['int_value'];
    $sql .= " AND p.int_value = $int_value ";
}
if (!empty($_GET['sta_id'])) {
    $sta_id = $_GET['sta_id'];
    $sql .= " AND p.sta_id = $sta_id ";
}
if (!empty($_GET['int_duration'])) {
    $int_duration = $_GET['int_duration'];
    $sql .= " AND p.int_duration = $int_duration ";
}
if (!empty($_GET['date_get_begin']) && !empty($_GET['date_get_end'])) {
    $date_get_begin = $_GET['date_get_begin'];
    $date_get_end = $_GET['date_get_end'];
    $sql .= " AND p.pawn_date_get BETWEEN STR_TO_DATE('$date_get_begin','%d-%m-%Y') AND STR_TO_DATE('$date_get_end','%d-%m-%Y') ";
}
if (!empty($_GET['date_return_begin']) && !empty($_GET['date_return_end'])) {
    $date_return_begin = $_GET['date_return_begin'];
    $date_return_end = $_GET['date_return_end'];
    $sql .= " AND DATE_ADD(p.pawn_date_get,INTERVAL p.int_duration DAY) BETWEEN STR_TO_DATE('$date_return_begin','%d-%m-%Y') AND STR_TO_DATE('$date_return_end','%d-%m-%Y') ";
}
$sql .= " ORDER BY p.pawn_id DESC";
//echo 'sql :: '.$sql;
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);


// Dropdown Interest
$interest_sql = "SELECT `int_id`, `int_value`,int_duration FROM `interest` ORDER BY int_value ASC";
$interest_query = mysqli_query($conn, $interest_sql) or die(mysqli_error($conn) . 'sql : ' . $interest_sql);
$interests = array();
while ($int = mysqli_fetch_array($interest_query)) {
    $interests[] = $int;
}
?>
<form name="pawn" action="pawn-list.php">
    <fieldset>
        <legend>ค้นหารายการจำนำสินค้า</legend>
        <table width="100%;">
            <tbody>
                <tr>
                    <td width="15%"><label>ชื่อลูกค้า-สกุล</label></td>
                    <td width="35%"><input type="text" name="mem_fullname" value="<?= empty($_GET['mem_fullname']) ? '' : $_GET['mem_fullname'] ?>" /></td>
                    <td width="15%"><label>รหัสบัตรประชาชน</label></td>
                    <td width="35%"><input type="text" name="mem_idcard" value="<?= empty($_GET['mem_idcard']) ? '' : $_GET['mem_idcard'] ?>" /></td>
                </tr>
                <tr>
                    <td><label>โทรศัพท์</label></td>
                    <td><input type="text" name="mem_mobile"value="<?= empty($_GET['mem_mobile']) ? '' : $_GET['mem_mobile'] ?>" /></td>
                    <td><label>อีเมลล์</label></td>
                    <td><input type="email" name="mem_email" value="<?= empty($_GET['mem_email']) ? '' : $_GET['mem_email'] ?>" /></td>
                </tr>
                <tr>
                    <td><label>เลขตั๋วจำนำ</label></td>
                    <td><input type="text" name="pawn_code" value="<?= empty($_GET['pawn_code']) ? '' : $_GET['pawn_code'] ?>"/></td>
                    <td><label>ประเภทสินค้า</label></td>
                    <td>
                        <?php
                        $type_sql = "SELECT `type_id`, `type_name` FROM `product_type` ORDER BY type_name ASC";
                        $type_query = mysqli_query($conn, $type_sql) or die(mysqli_error($conn) . 'sql : ' . $type_sql);
                        ?>
                        <select name="type_id">
                            <option value="">-- เลือกประเภทสินค้า --</option>
                            <?php while ($type = mysqli_fetch_array($type_query)) { ?>
                                <?php if ($type['type_id'] == (empty($_GET['type_id']) ? '' : $_GET['type_id'])) { ?>
                                    <option value="<?= $type['type_id'] ?>" selected><?= $type['type_name'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $type['type_id'] ?>"><?= $type['type_name'] ?></option>
                                <?php } ?>    
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>วันที่จำนำเริ่ม</label></td>
                    <td><input type="text" class="datepicker" name="date_get_begin" value="<?= empty($_GET['date_get_begin']) ? '' : $_GET['date_get_begin'] ?>"/></td>
                    <td><label>ถึง</label></td>
                    <td><input type="text" class="datepicker" name="date_get_end"  value="<?= empty($_GET['date_get_end']) ? '' : $_GET['date_get_end'] ?>"/></td>
                </tr>
                <tr>
                    <td><label>วันที่ไถ่ถอนเริ่ม</label></td>
                    <td><input type="text" class="datepicker" name="date_return_begin"  value="<?= empty($_GET['date_return_begin']) ? '' : $_GET['date_return_begin'] ?>"/></td>
                    <td><label>ถึง</label></td>
                    <td><input type="text" class="datepicker" name="date_return_end"  value="<?= empty($_GET['date_return_end']) ? '' : $_GET['date_return_end'] ?>"/></td>
                </tr>
                <tr>
                    <td><label>ชื่อสินค้า</label></td>
                    <td><input type="text" name="product_name" value="<?= empty($_GET['product_name']) ? '' : $_GET['product_name'] ?>"/></td>
                    <td><label>ราคาจำนำ</label></td>
                    <td><input type="text" name="product_price" value="<?= empty($_GET['product_price']) ? '' : $_GET['product_price'] ?>"/></td>
                </tr>
                <tr>
                    <td><label>สถานะการจำนำ</label></td>
                    <td>
                        <?php
                        $status_sql = "SELECT `sta_id`, `sta_desc` FROM `pawn_status` ORDER BY sta_id ASC";
                        $status_query = mysqli_query($conn, $status_sql) or die(mysqli_error($conn) . 'sql : ' . $status_sql);
                        ?>
                        <select name="sta_id">
                            <option value="">-- เลือกสถานะการจำนำ --</option>
                            <?php while ($status = mysqli_fetch_array($status_query)) { ?>
                                <?php if ($status['sta_id'] == (empty($_GET['sta_id']) ? '' : $_GET['sta_id'])) { ?>
                                    <option value="<?= $status['sta_id'] ?>" selected><?= $status['sta_desc'] ?></option>
                                <?php } else { ?>
                                    <option value="<?= $status['sta_id'] ?>"><?= $status['sta_desc'] ?></option>
                                <?php } ?>    
                            <?php } ?>
                        </select>
                    </td>
                    <td><label>ราคารวม</label></td>
                    <td><input type="text" name="pawn_total" value="<?= empty($_GET['pawn_total']) ? '' : $_GET['pawn_total'] ?>" /></td>
                </tr>
                <tr>
                    <td><label>ดอกเบี้ย</label></td>
                    <td>
                        <select name="int_value">
                            <option value="">-- เลือกอัตราดอกเบี้ย --</option>
                            <?php foreach ($interests as $index => $int) { ?>
                                <?php if ($int['int_value'] == (empty($_GET['int_value']) ? '' : $_GET['int_value'])) { ?>
                                    <option value="<?= $int['int_value'] ?>" selected><?= $int['int_value'] ?> %</option>
                                <?php } else { ?>
                                    <option value="<?= $int['int_value'] ?>"><?= $int['int_value'] ?> %</option>
                                <?php } ?>    
                            <?php } ?>
                        </select>
                    </td>
                    <td><label>ระยะเวลา</label></td>
                    <td>
                        <select name="int_duration">
                            <option value="">-- เลือกระยะเวลา --</option>
                            <?php foreach ($interests as $index => $int) { ?>
                                <?php if ($int['int_duration'] == (empty($_GET['int_duration']) ? '' : $_GET['int_duration'])) { ?>
                                    <option value="<?= $int['int_duration'] ?>" selected><?= $int['int_duration'] ?> วัน</option>
                                <?php } else { ?>
                                    <option value="<?= $int['int_duration'] ?>"><?= $int['int_duration'] ?> วัน</option>
                                <?php } ?>    
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="ค้นหาข้อมูล" />
                        <input type="reset" value="ล้างค่าค้นหา" />
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</form>