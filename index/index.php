<?php include '../include/inc_header.php'; ?>
<?php
if (!empty($_SESSION['member'])) {
    $member = $_SESSION['member'];
    if ($member['mem_status'] == 'admin') {
        echo '<meta http-equiv="refresh" content="2; URL=\'http://localhost/pawn/admin/\'" />';
    } else if ($member['mem_status'] == 'customer') {
        echo '<meta http-equiv="refresh" content="2; URL=\'http://localhost/pawn/customer/\'" />';
    }
}
?>
<div>
    ร้านอรัญซาวด์
        รับจำนำสินค้า
</div>
<?php include '../include/inc_footer.php'; ?>