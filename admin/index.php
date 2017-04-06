<?php include '../include/inc_header.php'; ?>
<?php
$member = $_SESSION['member'];
if ($member['mem_status'] != 'admin') {
    echo '<meta http-equiv="refresh" content="2; URL=\'http://localhost/pawn/admin/\'" />';
}
include '../database/connect.php';
$sql = "SELECT 
            (SELECT COUNT(*) FROM pawn p WHERE p.sta_id IN (3,8) AND p.pawn_date_get = curdate()) as cnt_pawn_get,
            (SELECT COUNT(*) FROM pawn p WHERE p.sta_id IN (6)) as cnt_pawn_expired,
            (SELECT COUNT(*) FROM pawn p WHERE p.sta_id IN (9)) as cnt_pawn_finish,
            (SELECT COUNT(*) FROM pawn p WHERE p.sta_id IN (7)) as cnt_pawn_sale,
            (SELECT COUNT(*) FROM pawn p WHERE p.sta_id IN (5)) as cnt_sale_finish
           FROM pawn 
        ";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql ::==' . $sql);
$pawn = mysqli_fetch_assoc($query);
?>
<style type="text/css">
    .center {
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        color: red;
        background-color: palegreen;
    }
</style>
<fieldset>
    <legend>Dashboard</legend>
    <table width="100%">
        <tbody>
            <tr>
                <td>
                    <fieldset>
                        <legend>ทรัพย์รอไถ่ถอน วันนี้</legend>
                        <h1 class="center"><?= $pawn['cnt_pawn_get'] ?></h1>
                    </fieldset>
                </td>
                <td>
                    <fieldset>
                        <legend>ทรัพย์ไถ่ถอนเรียบร้อย ในระบบทั้งหมด</legend>
                        <h1 class="center"><?= $pawn['cnt_pawn_finish'] ?></h1>
                    </fieldset>
                </td>
            </tr>
            <tr>                
                <td>
                   <fieldset>
                        <legend>ทรัพย์หลุดจำนำ ในระบบทั้งหมด</legend>
                        <h1 class="center"><?= $pawn['cnt_pawn_expired'] ?></h1>
                    </fieldset>
                </td>
               <td>
                   <fieldset>
                        <legend>ทรัพย์ขายทอดตลาด ในระบบทั้งหมด</legend>
                        <h1 class="center"><?= $pawn['cnt_pawn_sale'] ?></h1>
                    </fieldset>
                </td>
            </tr>
            <tr>                
                 <td>
                    <fieldset>
                        <legend>ทรัพย์ขายออกไปจากระบบแล้ว</legend>
                        <h1 class="center"><?= $pawn['cnt_sale_finish'] ?></h1>
                    </fieldset>
                </td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>

</fieldset>
<?php include '../include/inc_footer.php'; ?>