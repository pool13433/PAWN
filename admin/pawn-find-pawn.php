<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/pawn-style.css" type="text/css"/>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
    </head>
    <body>
        <?php
        include '../database/connect.php';
        $data = $_GET['data'];
        $sql = "SELECT `pawn_id`, `pawn_code`, `product_name`, FORMAT(product_price,0) as product_price, `product_image`, ";
        $sql .=" (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name, ";
        $sql .=" CONCAT(m.mem_fname,'  ',m.mem_lname) as mem_fullname,m.mem_idcard,m.mem_email,m.mem_mobile,";
        $sql .= " int_value ,sta_id,p.int_duration,";
        $sql .= " ROUND((p.product_price * p.int_value)/100) as int_cal,";
        $sql .= " ROUND(((p.product_price * p.int_value)/100)+product_price) as pawn_total,";
        $sql .= " DATE_FORMAT(pawn_date_get,'%d-%m-%Y %h:%i %p') pawn_date_get, ";
        $sql .= " DATE_FORMAT(pawn_date_return,'%d-%m-%Y %h:%i %p') pawn_date_return,  ";
        $sql .= " DATE_FORMAT(DATE_ADD(p.pawn_date_get,INTERVAL int_duration DAY),'%d-%m-%Y') as pawn_date_end,";
        $sql .= " (SELECT sta_desc  FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
        $sql .= " p.create_date, p.create_by";
        $sql .= " FROM pawn p ";
        $sql .= " JOIN member m ON m.mem_id = p.mem_id ";
        $sql .= " WHERE 1=1";
        // condition search
        if (!empty($data)) {
            $sql .= " AND (
                     m.mem_fname LIKE '%$data%' OR m.mem_lname LIKE '%$data%' OR m.mem_idcard LIKE '%$data%' OR 
                     m.mem_mobile LIKE '%$data%' OR m.mem_email LIKE '%$data%' OR p.pawn_id LIKE '%$data%' OR 
                     p.pawn_code LIKE '%$data%'  OR p.product_name LIKE '%$data%' OR p.product_price LIKE '%$data%' OR  
                     p.int_value LIKE '%$data%' OR p.int_duration = '%$data%' OR p.pawn_total LIKE '%$data%' OR p.pawn_pay LIKE '%$data%'
                )";
        }
        $sql .= " ORDER BY p.pawn_id DESC";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql ::' . $sql);
        ?>
        <table width="100%" border="1">
            <thead>
                <tr>
                    <th>รหัสการจอง</th>                    
                    <th>ชื่อ-สกุล</th>     
                    <th>เลขที่บัตร</th>
                    <th>เบอร์โทร</th>
                    <th>อีเมลล์</th>
                    <th>ชื่อสินค้า</th>
                    <th>ประเภทสินค้า</th>
                    <th>ราคา</th>
                    <th>อัตราดอกเบี้ย</th>
                    <th>ดอกเบี้ย</th>                    
                    <th>รวม</th>
                    <th>ระยะเวลา</th>
                    <th>วันที่จำนำ</th>
                    <th>วันหมดอายุตํ๋วสัญญา</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $auto = 1;
                while ($row = mysqli_fetch_array($query)) {
                    $pawn_id = $row['pawn_id'];
                    $status = $row['sta_id'];
                    ?>
                    <tr class="select-item" data-mem_id="<?= $row['mem_id'] ?>" 
                        data-pawn_id="<?= $row['pawn_id'] ?>" data-product_image="<?= $row['product_image'] ?>">
                        <td><a href="javascript:void(0)"><?= $row['pawn_code'] ?></a></td>
                        <td><?= $row['mem_fullname'] ?></td>
                        <td><?= $row['mem_idcard'] ?></td>
                        <td><?= $row['mem_mobile'] ?></td>
                        <td><?= $row['mem_email'] ?></td>
                        <td align="center"><?= $row['product_name'] ?></td>
                        <td align="center"><?= $row['type_name'] ?></td>
                        <td align="center"><?= $row['product_price'] ?></td>
                        <td align="center"><?= $row['int_value'] ?></td>
                        <td align="center"><?= $row['int_cal'] ?></td>
                        <td align="center"><?= $row['pawn_total'] ?></td>
                        <td align="center"><?= $row['int_duration'] ?></td>                        
                        <td><?= $row['pawn_date_get'] ?></td>
                        <td><?= $row['pawn_date_end'] ?></td>
                        <td><?= $row['sta_name'] ?></td>                        
                    </tr>
                    <?php
                    $auto++;
                }
                ?>
            </tbody>
        </table>

    </body>
    <script type="text/javascript">
        $('.select-item').on('click', function () {
            var mem_id = $(this).attr('data-mem_id');
            var mem_fulllname = $(this).find('td:eq(1)').text();
            var mem_idcard = $(this).find('td:eq(2)').text();
            var mem_mobile = $(this).find('td:eq(3)').text();
            var mem_email = $(this).find('td:eq(4)').text();

            var pawn_id = $(this).attr('data-pawn_id');
            var pawn_code = $(this).find('td:eq(0)').text();
            var product_name = $(this).find('td:eq(5)').text();
            var type_name = $(this).find('td:eq(6)').text();
            var product_price = $(this).find('td:eq(7)').text().replace(',', '');
            var int_value = $(this).find('td:eq(8)').text();
            var int_cal = $(this).find('td:eq(9)').text();
            var pawn_total = $(this).find('td:eq(10)').text();
            var int_duration = $(this).find('td:eq(11)').text();
            var pawn_date_end = $(this).find('td:eq(13)').text();
            var product_image = $(this).attr('data-product_image');

            var $parent = window.opener;
            $parent.$('form[name="pawn-return"]')[0].reset();
            $parent.$('input[name="mem_id"]').val(mem_id);
            $parent.$('input[name="mem_fullname"]').val(mem_fulllname);
            $parent.$('input[name="mem_idcard"]').val(mem_idcard);
            $parent.$('input[name="mem_mobile"]').val(mem_mobile);
            $parent.$('input[name="mem_email"]').val(mem_email);

            $parent.$('input[name="pawn_id"]').val(pawn_id);
            $parent.$('input[name="pawn_code"]').val(pawn_code);
            $parent.$('input[name="product_name"]').val(product_name);
            $parent.$('input[name="product_price"]').val(product_price);
            $parent.$('input[name="int_value"]').val(int_value);
            $parent.$('input[name="int_cal"]').val(int_cal);
            $parent.$('input[name="pawn_total"]').val(pawn_total);
            $parent.$('input[name="int_duration"]').val(int_duration);
            $parent.$('input[name="pawn_date_end"]').val(pawn_date_end);
            $parent.$('select[name="type_id"] option:eq(0)').html(type_name);
            $parent.$('img#product_image').attr('src','../uploads/product/'+product_image);            
            window.close();
        });
    </script>
</html>
