<html>
    <header><title>เลขที่ตั๋วใบจำนำเลขที่ <?= $pawn_code ?></title></header>
    <link href="../css/pawn-style.css" type="text/css" rel="stylesheet"/>
    <body>
        <fieldset id="fieldsetPawnPrint">            
            <legend>ใบตั๋วจำนำอย่างย่อ [เลขที่ตั๋วใบจำนำเลขที่ <?= $pawn_code ?>]</legend>
            <table border="0" width="100%">
                <tbody>
                    <tr>
                        <td>วันที่ทำรายการจำนำ</td>
                        <td><?= date('d-m-Y') ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>ชื่อลูกค้า</td>
                        <td><?= $mem_fullname ?></td>
                        <td>รหัสบัตรลูกค้า</td>
                        <td><?= $mem_idcard ?></td>
                    </tr>
                    <tr>
                        <td>โทรศัพท์</td>
                        <td><?= $mem_mobile ?></td>
                        <td>อีเมลล์</td>
                        <td><?= $mem_email ?></td>
                    </tr>
                    <tr>
                        <td>รูปสินค้า</td>
                        <td><img src="../uploads/product/<?=$product_image?>" style="max-width: 200px;"/></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>ชื่อสินค้า</td>
                        <td><?= $product_name ?></td>
                        <td>ประเภทสินค้า</td>
                        <td><?= $type_name ?></td>
                    </tr>
                    <tr>
                        <td>เงินต้น</td>
                        <td><?= $product_price ?> บาท</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>ดอกเบี้ย</td>
                        <td><?= $int_value ?> %</td>
                        <td>ยอดรวม</td>
                        <td><?= $pawn_total ?> บาท</td>
                    </tr>
                    <tr>
                        <td>อายุตั๋ว</td>
                        <td><?= $int_duration ?> วัน</td>
                        <td>วันสิ้นอายุตั๋ว</td>
                        <td><?= $pawn_date_end ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"><hr/></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">ลงชื่อ (................................................)</td>                                
                        <td colspan="2" style="text-align: center;">ลงชื่อ (................................................)</td>                                
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">(............................................................)</td>                                
                        <td colspan="2" style="text-align: center;">(............................................................)</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">ลงชื่อลูกค้าที่มารับบริการ</td>                                
                        <td colspan="2" style="text-align: center;">ลงชื่อเจ้าหน้าที่ให้บริการ</td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <script type="text/javascript">window.print();</script>
    </body>
</html>
