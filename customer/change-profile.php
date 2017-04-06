<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$member = $_SESSION['member'];
$mem_id = $member['mem_id'];
$mem_username = $member['mem_username'];
$mem_password = $member['mem_password'];
$mem_fname = $member['mem_fname'];
$mem_lname = $member['mem_lname'];
$mem_idcard = $member['mem_idcard'];
$mem_mobile = $member['mem_mobile'];
$mem_email = $member['mem_email'];
$mem_gender = $member['mem_gender'];
$mem_age = $member['mem_age'];
$mem_address = $member['mem_address'];
$mem_status = $member['mem_status'];
?>
<fieldset>
    <legend><img src="../images/menus/customer-profile-title.png"/></legend>
    <form name="profile" action="change-profile-save.php" method="POST">
        <table width="100%">
            <tbody>
                <tr>
                    <td><label>First Name <span class="require">*</span></label></td>
                    <td>
                        <input type="text" style="width: 100%" name="mem_fname" value="<?= $mem_fname ?>" required/>
                    </td>
                    <td><label>Last Name <span class="require">*</span></label></td>
                    <td>
                        <input type="text" style="width: 100%" name="mem_lname" value="<?= $mem_lname ?>" required/>
                    </td>
                </tr>
                <tr>
                    <td><label>Id Card <span class="require">*</span></label></td>
                    <td>
                        <input type="text" style="width: 45%" name="mem_idcard" value="<?= $mem_idcard ?>" maxlength="13" required/>
                    </td>
                    <td><label>Age <span class="require">*</span></label></td>
                    <td>
                        <input type="number" style="width: 20%" name="mem_age" value="<?= $mem_age ?>" maxlength="2" required/>
                    </td>
                </tr>
                <tr>
                    <td><label>Mobile <span class="require">*</span></label></td>
                    <td>
                        <input type="text" style="width: 45%" name="mem_mobile" value="<?= $mem_mobile ?>" maxlength="10" required/>
                    </td>
                    <td><label>Email <span class="require">*</span></label></td>
                    <td>
                        <input type="email" style="width: 100%" name="mem_email" value="<?= $mem_email ?>" required/>
                    </td>
                </tr>
                <tr>
                    <td><label>Gender <span class="require">*</span></label></td>
                    <td>
                        <select name="mem_gender">
                            <?php foreach ($_mem_gender as $key => $gender) { ?>
                                <?php if ($mem_gender == $key) { ?>
                                    <option value="<?= $key ?>" selected><?= $gender ?></option>
                                <?php } else { ?>
                                    <option value="<?= $key ?>"><?= $gender ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;"><label>ที่อยู่ <span class="require">*</span></label></td>
                    <td colspan="3">
                        <textarea style="width: 100%;" rows="5" name="mem_address"><?= $mem_address ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="เปลี่ยนแปลงข้อมูลส่วนตัว" /></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>
<?php include '../include/inc_footer.php'; ?>