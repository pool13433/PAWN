<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$mem_id = empty($_GET['id']) ? '' : $_GET['id'];
$mem_fname = $mem_lname = $mem_username = $mem_password = $mem_idcard = $mem_age = $mem_gender = $mem_mobile = $mem_email = $mem_status = $mem_address = '';
if (!empty($mem_id)) {
    $sql = "SELECT `mem_id`, `mem_username`, `mem_password`, `mem_fname`, `mem_lname`, `mem_idcard`, ";
    $sql .= " `mem_age`, `mem_gender`, `mem_mobile`, `mem_email`, `mem_address`, `mem_status`, `create_by` ";
    $sql .= " ,DATE_FORMAT(create_date,'%d-%m-%Y') as create_date";
    $sql .= " FROM `member` WHERE mem_id = " . $mem_id;
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    $mem_id = $result['mem_id'];
    $mem_username = $result['mem_username'];
    $mem_password = $result['mem_password'];
    $mem_fname = $result['mem_fname'];
    $mem_lname = $result['mem_lname'];
    $mem_idcard = $result['mem_idcard'];
    $mem_mobile = $result['mem_mobile'];
    $mem_email = $result['mem_email'];
    $mem_gender = $result['mem_gender'];
    $mem_age = $result['mem_age'];
    $mem_address = $result['mem_address'];
    $mem_status = $result['mem_status'];
}
?>
<fieldset>
    <legend>ฟอร์มจัดการข่าวสารประชาสัมพันธ์</legend>
    <a href="<?= (empty($_GET['href']) ? 'member-list.php' : $_GET['href']) ?>">ย้อนกลับ</a>
    <form name="news" action="member-save.php" method="POST">
        <input type="hidden" name="mem_id" value="<?= $mem_id ?>"/>
        <input type="hidden" name="href" value="<?= (empty($_GET['href']) ? '' : $_GET['href']) ?>"/>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>Username <span class="require">*</span></label></td>
                    <td width="35%">
                        <input type="text" style="width: 100%" name="mem_username" value="<?= $mem_username ?>" required/>
                    </td>
                    <td width="15%"><label>Password <span class="require">*</span></label></td>
                    <td width="35%">
                        <input type="password" style="width: 100%" name="mem_password" value="<?= $mem_password ?>" required/>
                    </td>
                </tr>
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
                    <td><label>Status <span class="require">*</span></label></td>
                    <td>
                        <select name="mem_status">
                            <?php foreach ($_mem_status as $key => $status) { ?>
                                <?php if ($mem_status == $key) { ?>
                                    <option value="<?= $key ?>" selected><?= $status ?></option>
                                <?php } else { ?>
                                    <option value="<?= $key ?>"><?= $status ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
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
                    <td><input type="submit" value="บันทึก" /></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </form>


</fieldset>
<?php include '../include/inc_footer.php'; ?>