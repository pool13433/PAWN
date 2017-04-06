<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';
$sta_id = empty($_GET['id']) ? '' : $_GET['id'];
$sta_name = $sta_desc = '';
$readonly = '';
if (!empty($sta_id)) {
    $sql = "SELECT `sta_id`, `sta_name`, `sta_desc`, DATE_FORMAT(create_date,'%d-%m-%Y') create_date, `create_by` ";
    $sql .= " FROM `pawn_status` WHERE sta_id = " . $sta_id;
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $result = mysqli_fetch_assoc($query);
    $sta_name = $result['sta_name'];
    $sta_desc = $result['sta_desc'];
    $sta_id = $result['sta_id'];
    $readonly = 'readonly';
}
?>
<fieldset>
    <legend>ฟอร์มจัดการสถานะการจำนำ</legend>
    <a href="pawn-status-list.php">ย้อนกลับ</a>
    <form name="news" action="pawn-status-save.php" method="POST">
        <input type="hidden" name="sta_id" value="<?= $sta_id ?>"/>
        <table width="100%">
            <tbody>
                <tr>
                    <td width="15%"><label>ชื่อ <span class="require">*</span></label></td>
                    <td width="35%" colspan="3">
                        <input type="text" style="width: 100%" name="sta_name" value="<?= $sta_name ?>" required/>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;"><label>รายละเอียดสถานะ <span class="require">*</span></label></td>
                    <td colspan="3">
                        <textarea style="width: 100%;" rows="5" name="sta_desc"><?= $sta_desc ?></textarea>
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