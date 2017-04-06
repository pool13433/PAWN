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
        $sql = "SELECT `mem_id`,CONCAT(`mem_fname`,'    ', `mem_lname`) as mem_fullname, `mem_idcard`, `mem_age`, ";
        $sql .= " `mem_gender`, `mem_mobile`, `mem_email`, `mem_address`, `mem_status`, `create_date`, `create_by` ";
        $sql .=" FROM `member` WHERE mem_status = 'customer' ";
        if(!empty($data)){
            $sql .= " AND (mem_fname LIKE '%$data%' OR mem_lname LIKE '%$data%' OR mem_idcard LIKE '%$data%' OR mem_mobile LIKE '%$data%' OR mem_email LIKE '%$data%' )";
        }        
        $sql .= " ORDER BY mem_fname ASC";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        ?>
        <table width="100%" border="1">
            <thead>
                <tr>
                    <th>เลขที่บัตร</th>
                    <th>ชื่อ-สกุล</th>                    
                    <th>เบอร์โทร</th>
                    <th>อีเมลล์</th>
                    <th>อายุ</th>
                    <th>เพศ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                    <tr class="select-item" data-mem_id="<?= $row['mem_id'] ?>">
                        <td><a href="#" ><?= $row['mem_idcard'] ?></a></td>                        
                        <td><?= $row['mem_fullname'] ?></td>
                        <td><?= $row['mem_mobile'] ?></td>
                        <td><?= $row['mem_email'] ?></td>
                        <td><?= $row['mem_age'] ?></td>
                        <td><?= $row['mem_gender'] ?></td>
                    </tr>
                <?php } mysqli_close($conn)?>
            </tbody>
        </table>

    </body>
    <script type="text/javascript">
        $('.select-item').on('click', function () {
            var mem_id = $(this).attr('data-mem_id');
            var mem_idcard = $(this).find('td:eq(0)').text();
            var mem_fulllname = $(this).find('td:eq(1)').text();
            var mem_mobile = $(this).find('td:eq(2)').text();
            var mem_email = $(this).find('td:eq(3)').text();
            var mem_age = $(this).find('td:eq(4)').text();
            var mem_gender = $(this).find('td:eq(5)').text();
            var $parent = window.opener;
            $parent.$('input[name="mem_id"]').val(mem_id);
            $parent.$('input[name="mem_fullname"]').val(mem_fulllname);
            $parent.$('input[name="mem_idcard"]').val(mem_idcard);
            $parent.$('input[name="mem_mobile"]').val(mem_mobile);
            $parent.$('input[name="mem_email"]').val(mem_email);
            window.close();
        });
    </script>
</html>
