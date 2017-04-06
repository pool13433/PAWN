<?php include '../include/inc_header.php'; ?>
<?php
$member = $_SESSION['member'];
$mem_username = $member['mem_username'];
$mem_password = $member['mem_password'];
?>
<fieldset>
    <legend><img src="../images/menus/customer-password-title.png"/></legend>
    <form action="change-password-save.php" method="POST" name="password">
        <table width="100%;">
            <tbody>
                <tr>
                    <td width="15%;"><label>รหัสผ่านเก่า</label></td>
                    <td width="35%;"><input type="text" name="password_old" value="" required/></td>
                    <td width="15%;"></td>
                    <td width="35%;"></td>
                </tr>
                <tr>
                    <td><label>รหัสผ่านใหม่</label></td>
                    <td><input type="text" name="password_new" value="" required/></td>
                    <td><label>รหัสผ่านใหม่ อีกครั้ง</label></td>
                    <td><input type="text" name="password_new_confirm" value="" required/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="บันทึกรหัสผ่านใหม่" /></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </form>


</fieldset>
<?php include '../include/inc_footer.php'; ?>