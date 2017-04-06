<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$int_id = empty($_GET['id']) ? '' : $_GET['id'];
$int_value = $int_money_begin = $int_money_end = $int_duration = '';
if (!empty($int_id)) {
    $sql = "SELECT `int_id`, `int_money_begin`, `int_money_end`, `int_duration`, `int_value`, `create_date`, `create_by` ";
    $sql .= " FROM `interest` WHERE int_id = ".$int_id;
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    $int_value = $result['int_value'];
    $int_money_begin = $result['int_money_begin'];
    $int_money_end = $result['int_money_end'];
    $int_duration = $result['int_duration'];
    $int_id = $result['int_id'];
}
?>
<fieldset>
    <legend>ฟอร์มจัดการดอกเบี้ย</legend>
    <a href="interest-list.php">ย้อนกลับ</a>
    <form name="interrest" action="interest-save.php" method="POST">
        <input type="hidden" name="int_id" value="<?=$int_id?>"/>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>เงินต้นช่วงเริ่ม <span class="require">*</span></label></td>
                    <td width="35%"><input type="number" name="int_money_begin" value="<?=$int_money_begin?>" required/><label>บาท</label></td>
                    <td width="15%"><label>ถึงช่วง <span class="require">*</span></label></td>
                    <td width="35%"><input type="number" name="int_money_end" value="<?=$int_money_end?>" required/><label>บาท</label></td>
                </tr>
                <tr>
                    <td><label>อายุเวลา <span class="require">*</span></label></td>
                    <td><input type="number" name="int_duration" value="<?=$int_duration?>" required/><label>วัน</label></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><label>ดอกเบี้ย <span class="require">*</span></label></td>
                    <td><input type="number" name="int_value" value="<?=$int_value?>" required/><label> %</label></td>
                    <td></td>
                    <td></td>
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