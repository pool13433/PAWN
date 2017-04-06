<?php
if (empty($conn)) {
    include '../database/connect.php';
}
// check param case
$params = array();
$params['case'] = (empty($_GET['case']) ? '' : $_GET['case']);
$mem_id = (empty($_GET['mem_id']) ? '' : $_GET['mem_id']);
$params['image'] = 'pawn-waiting.png';
switch ($params['case']) {
    case 'create':
        $params['status'] = '';//$_pawn_status['PAWN-PROCESS'] . ',' . $_pawn_status['PAWN-REDUCE'];
        $params['image'] = 'pawn-waiting.png';
        break;
    case 'return':
        $params['status'] = $_pawn_status['PAWN-PROCESS'] . ',' . $_pawn_status['PAWN-REDUCE'];
        $params['image'] = 'pawn-return.png';
        break;
    case 'reduce':
        $params['status'] = $_pawn_status['PAWN-PROCESS'] . ',' . $_pawn_status['PAWN-REDUCE'];
        $params['image'] = 'pawn-reduce.png';
        break;
    case 'finish':
        $params['status'] = $_pawn_status['PAWN-FINISH'];
        $params['image'] = 'pawn-finish.png';
        break;
    case 'expire':
        $params['status'] = $_pawn_status['PAWN-EXPIRE'];
        $params['image'] = 'pawn-expire.png';
// auto update วันที่เกินระยะเวลาไถ่ถอน
        $sta_id = $_pawn_status['PAWN-EXPIRE'];
        $sta_id_not_update = $_pawn_status['SALE-WAITING'];
        $sql = " UPDATE pawn SET ";
        $sql .= " sta_id =  $sta_id ";
        $sql .= " WHERE DATEDIFF(DATE_ADD(pawn_date_get,INTERVAL int_duration DAY),curdate()) <= 0 ";
        $sql .= " AND sta_id not in (7,8,9)";
        $exe = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
        break;
    case 'sale':
        $params['status'] = $_pawn_status['SALE-WAITING'];
        $params['image'] = 'pawn-sale.png';
        break;
    default:
        break;
}


// query pawn 
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
$sql .= " JOIN member m ON m.mem_id = p.mem_id WHERE 1=1 ";
if (!empty($params['status'])) {
    $sql .= " AND p.sta_id IN (" . $params['status'] . ")";
}
if(!empty($mem_id)){
    $sql .= " AND p.mem_id = ".$mem_id;
}
$sql .= " ORDER BY p.pawn_id DESC";
//echo 'sql :: ' . $sql;
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
?>

<fieldset>
    <legend><img src="../images/menus/<?= $params['image'] ?>"/></legend>
    <?php //include './pawn-filter.php';  ?>
    <!--<a href="pawn-form.php?href=pawn-get">เพิ่มรายการจำนำ</a>&nbsp;&nbsp; -->
    <?php if ($params['case'] == 'expire') { ?>
        <a href="javascript:void()" id="btnMoveToSale"><img src="../images/buttons/btn-sale.png"/></a>
    <?php } ?>
    <form name="pawnMoveSale" action="pawn-move-sale.php" method="POST" style="height: 600px; overflow-y: scroll;">
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <?php if ($params['case'] == 'expire') { ?>
                        <th>*</th>  
                    <?php } ?>
                    <th>ชื่อลูกค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>ราคา</th>
                    <th>ระยะเวลา</th>
                    <th>วันที่จำนำ</th>
                    <th>วันไถ่ถอน</th>
                    <th>สถานะ</th>
                    <?php if ($params['case'] == 'return') { ?>
                        <th>ไถ่ถอน</th>
                    <?php } ?>
                    <?php if ($params['case'] == 'reduce') { ?>
                        <th>ลดราคา</th>
                    <?php } ?>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $auto = 1;
                while ($row = mysqli_fetch_array($query)) {
                    $pawn_id = $row['pawn_id'];
                    $status = $row['sta_id'];
                    ?>
                    <tr>
                        <td>
                            <img src="../uploads/product/<?= $row['product_image'] ?>" style="max-width: 120px;"/>
                            <?= $row['pawn_code'] ?>
                        </td>
                        <?php if ($params['case'] == 'expire') { ?>
                            <td>
                                <?php if ($status == $_pawn_status['PAWN-EXPIRE']) { ?>
                                    <input type="checkbox" name="pawn[]" value="<?= $row['pawn_id'] ?>"/>
                                <?php } ?>
                            </td>
                        <?php } ?>
                        <td><?= $row['mem_fullname'] ?></td>
                        <td align="center"><?= $row['product_name'] ?></td>
                        <td align="center"><?= $row['product_price'] ?></td>
                        <td align="center"><?= $row['int_duration'] ?></td>
                        <td><?= $row['pawn_date_get'] ?></td>
                        <td><?= $row['pawn_date_end'] ?></td>
                        <td><?= $row['sta_name'] ?></td>
                        <?php if ($params['case'] == 'return') { ?>
                            <td nowrap>
                                <a href="pawn-form.php?href=pawn-list.php?case=return&id=<?= $pawn_id ?>&case=return">ไถ่ถอน</a>
                            </td>                        
                        <?php } ?>
                        <?php if ($params['case'] == 'reduce') { ?>
                            <td nowrap>                            
                                <a href="pawn-form.php?href=pawn-list.php?case=reduce&id=<?= $pawn_id ?>&case=reduce">ลดราคา</a>                            
                            </td>
                        <?php } ?>
                        <td nowrap><a href="pawn-form.php?href=pawn-list.php?case=<?= $params['case'] ?>&id=<?= $pawn_id ?>&case=edit">แก้ไข</a></td>
                        <td nowrap><a href="pawn-delete.php?id=<?= $pawn_id ?>&case=<?= $params['case'] ?>" onclick="return confirm('ยืนยันการลบข้อมูลนี้ ตกลง || ยกเลิก')">ลบ</a></td>
                    </tr>
                    <?php
                    $auto++;
                }
                ?>
            </tbody>
        </table>
    </form>
</fieldset>
<script type="text/javascript">
    $(function () {
        $('#btnMoveToSale').click(function () {
            var isConfirm = confirm('ยืนยันการเปลี่ยนสถานะสินค้าที่เหลือเหล่านี้เพื่อนำปขายถอดตลาด ใช่หรือไม่');
            if (isConfirm) {
                $('form[name="pawnMoveSale"]').submit();
            }
        });
    });
</script>