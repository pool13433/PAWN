<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$type_id = empty($_GET['id']) ? '' : $_GET['id'];
$type_name = $type_desc = '';
if (!empty($type_id)) {
    $sql = "SELECT `type_id`, `type_name`, `type_desc`, DATE_FORMAT(create_date,'%d-%m-%Y') create_date, `create_by` ";
    $sql .= " FROM `product_type` WHERE type_id =  " . $type_id;
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    $type_name = $result['type_name'];
    $type_desc = $result['type_desc'];
    $type_id = $result['type_id'];
}
?>
<fieldset>
    <legend>ฟอร์มจัดการประเภทสินค้าจำนำ</legend>
    <a href="product-type-list.php">ย้อนกลับ</a>
    <form name="news" action="product-type-save.php" method="POST">
        <input type="hidden" name="type_id" value="<?= $type_id ?>"/>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>ชื่อ <span class="require">*</span></label></td>
                    <td width="35%">
                        <input type="text" style="width: 100%" name="type_name" value="<?= $type_name ?>" required/>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;"><label>รายละเอียด <span class="require">*</span></label></td>
                    <td colspan="3">
                        <textarea style="width: 100%;" rows="5" name="type_desc"><?= $type_desc ?></textarea>
                    </td>
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