<?php include '../include/inc_header.php'; ?>
<?php
include '../database/connect.php';

$pawn_code = $product_name = $product_image = $product_price = $mem_id = '';
$int_value = $int_duration = $pawn_total = $int_cal = $type_id = $type_name = $sta_name = $pawn_date_get = '';
$mem_fullname = $mem_idcard = $mem_mobile = $mem_email = $create_date = '';

$visible = true;
$form = array(
    'action' => 'pawn-get-save.php', 'title' => "ฟอร์มเพิ่มรายการจำนำ", 'button' => "บันทึกการจำนำสินค้า", 'name' => 'pawn-get',
    'case' => 'create', 'readonly' => "", 'require' => 'require', 'image' => 'pawn-get.png', 'disabled' => ''
);
$pawn_id = (empty($_GET['id']) ? '' : $_GET['id']);
$form['case'] = (empty($_GET['case']) ? '' : $_GET['case']);
$form['href'] = (empty($_GET['href']) ? 'pawn-form.php?case=create' : $_GET['href']);

if (empty($pawn_id)) { // NEW
    if ($form['case'] == 'create') {
        $sql = "SELECT CONCAT('ARAN',DATE_FORMAT(CURDATE(),'%Y%m%d'),lpad((pawn_id+1), 4, '0')) as ticket FROM pawn ORDER BY pawn_id DESC limit 0,1";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
        $pawn_code = mysqli_fetch_assoc($query)['ticket'];
        $form['action'] = 'pawn-get-save.php';
        $form['title'] = 'ฟอร์มการจำนำ';
        $form['button'] = "บันทึกการจำนำสินค้า";
        $form['name'] = 'pawn-get';
        $form['readonly'] = '';
        $form['require'] = 'required';
    } else {
        $form['action'] = 'pawn-return-save.php';
        $form['title'] = 'ฟอร์มไถ่ถอนการจำนำ';
        $form['button'] = "บันทึกการไถ่ถอนสินค้า";
        $form['name'] = 'pawn-return';
        $form['readonly'] = 'readonly';
        $form['disabled'] = 'disabled';
        $form['image'] = 'pawn-return.png';
    }
} else { //RETURN / REDUCE
    $sql = "SELECT p.pawn_id,p.pawn_code,p.product_name,p.product_price,p.product_image,";
    $sql .= " p.int_value,p.int_duration,p.pawn_total,p.type_id,";
    $sql .= " (SELECT type_name FROM product_type pt WHERE pt.type_id = p.type_id) as type_name,";
    $sql .= " ROUND((p.product_price * p.int_value)/100) as int_cal,";
    $sql .= " (SELECT sta_desc FROM pawn_status ps WHERE ps.sta_id = p.sta_id) as sta_name,";
    $sql .= " DATE_FORMAT(p.pawn_date_get,'%d-%m-%Y') as pawn_date_get,DATE_FORMAT(p.pawn_date_return,'%d-%m-%Y') as pawn_date_return,";
    $sql .= " CONCAT(m.mem_fname,' ',m.mem_lname) as mem_fullname,m.mem_idcard,m.mem_mobile,m.mem_email,m.mem_id,";
    $sql .= " DATE_FORMAT(p.create_date,'%d-%d-%Y') as create_date,p.create_by ";
    $sql .= " FROM pawn p ";
    $sql .= " JOIN member m ON m.mem_id = p.mem_id";
    $sql .= " WHERE p.pawn_id = " . $pawn_id;
    //echo 'sql ::==' . $sql;
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . 'sql : ' . $sql);
    $pawn = mysqli_fetch_assoc($query);
    $pawn_id = $pawn['pawn_id'];
    $pawn_code = $pawn['pawn_code'];
    $product_name = $pawn['product_name'];
    $product_price = $pawn['product_price'];
    $product_image = $pawn['product_image'];
    $int_value = $pawn['int_value'];
    $int_duration = $pawn['int_duration'];
    $pawn_total = $pawn['pawn_total'];
    $int_cal = $pawn['int_cal'];
    $type_id = $pawn['type_id'];
    $type_name = $pawn['type_name'];
    $sta_name = $pawn['sta_name'];
    $pawn_date_get = $pawn['pawn_date_get'];
    $pawn_date_return = $pawn['pawn_date_return'];
    $mem_fullname = $pawn['mem_fullname'];
    $mem_id = $pawn['mem_id'];
    $mem_idcard = $pawn['mem_idcard'];
    $mem_mobile = $pawn['mem_mobile'];
    $mem_email = $pawn['mem_email'];
    $create_date = $pawn['create_date'];
    $visible = false;
}
?>
<fieldset>
    <legend><img src="../images/menus/<?= $form['image'] ?>"/></legend>
    <!--<a href="pawn-list.php">ย้อนกลับ</a>-->
    <form name="<?= $form['name'] ?>" action="<?= $form['action'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="case" value="<?= $form['case'] ?>" />
        <input type="text" name="href" value="<?= $form['href'] ?>" />
        <fieldset>
            <legend>ข้อมูลลูกค้า</legend>
            <table width="100%">
                <tbody>
                    <?php if ($form['case'] == 'edit' || $form['case'] == 'create') { ?>
                        <tr>
                            <td width="15%"><label>กรอกข้อมูลลูกค้า</label></td>
                            <td width="35%"><input type="text" name="searchValue" value="" /><input type="button" value="ค้นหาลูกค้า" id="btnFindCustomer"/></td>
                            <td width="15%"><a href="member-form.php?href=pawn-form.php?case=create">เพิ่มลูกค้าใหม่</a></td>
                            <td width="35%"></td>
                        </tr>
                    <?php } ?>
                    <?php if ($form['case'] == 'return') { ?>
                        <tr>
                            <td width="15%"><label>กรอกข้อมูลการจำนำ</label></td>
                            <td width="50%" colspan="2"><input type="text" name="searchValue" value="" />
                                <input type="button" value="ค้นหาข้อมูลการจำนำ" id="btnFindPawn"/>
                            </td>
                            <td width="35%"></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td width="15%"><label>ชื่อ-สกุล</label></td>
                        <td width="35%"><input type="hidden" name="mem_id" value="<?= $mem_id ?>"/>
                            <input type="text" name="mem_fullname" required value="<?= $mem_fullname ?>" <?= $form['readonly'] ?>/></td>
                        <td width="15%"><label>เลขบัตรประชาชน</label></td>
                        <td width="35%"><input type="text" name="mem_idcard" required readonly value="<?= $mem_idcard ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>โทรศัพท์</label></td>
                        <td><input type="text" name="mem_mobile" required readonly value="<?= $mem_mobile ?>"/></td>
                        <td><label>อีเมลล์</label></td>
                        <td><input type="text" name="mem_email" required readonly value="<?= $mem_email ?>"/></td>
                    </tr>
                </tbody>
            </table>

        </fieldset>
        <fieldset>
            <legend>ข้อมูลการจำนำ</legend>
            <table width="100%">
                <tbody>
                    <tr>
                        <td><label>รหัสตั๋วจำนำ</label></td>
                        <td>
                            <input type="hidden" name="pawn_id" value="<?= $pawn_id ?>" />
                            <input type="text" name="pawn_code" value="<?= $pawn_code ?>" readonly/>
                        </td>
                        <td rowspan="4" style="vertical-align: top;"><label>แนบไฟล์รูปสินค้า [.PNG,JPG,GIF] <span class="require">*</span></label></td>
                        <td rowspan="4" style="vertical-align: top;">
                            <?php if ($form['case'] == 'edit' || $form['case'] == 'create') { ?>
                                <?php if (!empty($pawn_id)) { ?>
                                    <img src="../uploads/product/<?= $product_image ?>" id="product_image" style="max-width: 280px;"/>
                                <?php } ?>
                                <input type="file" name="product_image" value="" accept="image/*" <?= $form['require'] ?>/>                                
                            <?php } else { ?>  
                                <img src="../uploads/product/<?= $product_image ?>" id="product_image" style="max-width: 280px;"/>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>

                        <td width="15%"><label>ประเภทสินค้า <span class="require">*</span></label></td>
                        <td width="35%">
                            <?php
                            $type_sql = "SELECT `type_id`, `type_name` FROM `product_type` ORDER BY type_name ASC";
                            $type_query = mysqli_query($conn, $type_sql) or die(mysqli_error($conn) . 'sql : ' . $type_sql);
                            ?>
                            <select name="type_id" required <?= $form['readonly'] ?>  <?= $form['disabled'] ?>>
                                <option value="">-- เลือกประเภทสินค้า --</option>
                                <?php while ($type = mysqli_fetch_array($type_query)) { ?>
                                    <?php if ($type['type_id'] == $type_id) { ?>
                                        <option value="<?= $type['type_id'] ?>" data-name="<?= $type['type_name'] ?>" selected><?= $type['type_name'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $type['type_id'] ?>" data-name="<?= $type['type_name'] ?>"><?= $type['type_name'] ?></option>
                                    <?php } ?>                                            
                                <?php } ?>
                            </select>
                            <input type="hidden" name="type_name"/>
                        </td>                        
                    </tr>
                    <tr>
                        <td width="15%"><label>ชื่อสินค้า <span class="require">*</span></label></td>
                        <td width="35%"><input type="text" name="product_name" required value="<?= $product_name ?>" <?= $form['readonly'] ?>/></td>                        
                    </tr>
                    <tr>
                        <td><label>เงินต้น<span class="require">*</span></label></td>
                        <td>
                            <input type="number" name="product_price" required value="<?= $product_price ?>" <?= $form['readonly'] ?>/>
                            <label>บาท</label>
                            <?php if ($form['case'] == 'create') { ?>
                                <button type="button" id="btnCalInterest">คำนวนดอกเบี้ย</button>
                            <?php } ?>
                        </td>

                    </tr>
                    <tr>
                        <td><label>ดอกเบี้ย</label></td>
                        <td>
                            <input type="text" name="int_value" readonly value="<?= $int_value ?>"/>
                            <label>%</label>
                        </td>
                        <td><label>ยอดหลังจากคำนวนดอกเบี้ย</label></td>
                        <td><input type="text" name="int_cal" readonly value="<?= $int_cal ?>"/><label>บาท</label></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        </td>
                        <td><label>ยอดรวม</label></td>
                        <td><input type="text" name="pawn_total" readonly value="<?= $pawn_total ?>"/><label>บาท</label></td>
                    </tr>
                    <tr>
                        <td><label>อายุตั๋ว</label></td>
                        <td><input type="text" name="int_duration" readonly value="<?= $int_duration ?>"/><label>วัน</label></td>
                        <td><label>วันสิ้นอายุ</label></td>
                        <td><input type="text" name="pawn_date_end" readonly  value="<?= $pawn_date_get ?>"/></td>
                    </tr>
                    <?php if ($form['case'] == 'return') { ?>
                        <tr  style="background-color: orange">
                            <td><label>จำนวนเงินที่ไถ่ถอน <span class="require">*</span></label></td>
                            <td><input type="number" name="pawn_pay" required/><label>บาท</label></td>
                            <td>ระยะเวลาที่ต้องการขยายออกไป</td>
                            <td>
                                <?php
                                $interest_sql = "SELECT * FROM `interest` ORDER BY int_duration ASC";
                                $interest_query = mysqli_query($conn, $interest_sql) or die(mysqli_error($conn) . 'sql ::==' . $interest_sql);
                                ?>
                                <select style="width: 30%;" name="pawn_deal_interest_duration">     
                                    <option value="">-- เลือก --</option>
                                    <?php while ($interest = mysqli_fetch_array($interest_query)) { ?>
                                        <option value="<?= $interest['int_duration'] ?>"><?= $interest['int_duration'] ?></option>
                                    <?php } ?>                                    
                                </select>
                                <label>วัน</label>
                                <button type="button" id="btnCalDeal">คำนวน</button>
                            </td>
                        </tr>
                        <tr  style="background-color: orange">
                            <td><label>อัตราดอกเบี้ย</label></td>
                            <td><input type="text" name="pawn_deal_interest_value"/><label>%</label></td>
                            <td><label>ยอดดอกเบี้ยจากที่ต่อระยะเวลาออกไป</label></td>
                            <td><input type="text" name="pawn_deal_interest"/><label>บาท</label></td>
                        </tr>
                        <tr  style="background-color: orange">
                            <td>ยอดรวม คำนวนรวมดอกเบี้ยใหม่แล้ว</td>
                            <td>
                                <input type="text" name="pawn_deal_total"/><label>บาท</label>
                            </td>
                            <td>กำหนดวันที่สิ้นสุดตั๋วใหม่</td>
                            <td>
                                <input type="text" name="pawn_deal_date"/>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td><input type="submit" id="btnConfirmPrint" value="<?= $form['button'] ?>" /></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </form>
</fieldset>
<?php if (!empty($_GET['mem_id'])) { ?>
    <?php include './inc_pawn_list.php'; ?>
<?php } ?>

<script type="text/javascript">
    $(function () {
        //#Id = document.getElementById('btnFindCustomer')
        $('#btnFindCustomer').on('click', function () {
            var data = $('input[name="searchValue"]').val();
            windonOpenPopup('./pawn-find-customer.php?data=' + data, 'ค้นหาลูกค้า', 700, 500);
        });
        $('#btnFindPawn').on('click', function () {
            var data = $('input[name="searchValue"]').val();            
            windonOpenPopup('./pawn-find-pawn.php?data=' + data, 'ค้นหารายการจำนำ', 1200, 500);            
        });

        // การสร้างจำนำ
        $('form[name="pawn-get"]').submit(function () {
            return confirm('ยืนยันการบันทึกข้อมูลการจำนำเข้าระบบ ใช่[ตกลง] || ไม่ใช่[ยกเลิก]');
        });
        
        $('#btnCalDeal').on('click', function () {
            var value = $('select[name="pawn_deal_interest_duration"]').val();
            var product_price = $('input[name="product_price"]').val();
            var int_cal = $('input[name="int_cal"]').val();
            var pawn_pay = $('input[name="pawn_pay"]').val();
            if (value != '') {
                $.post('pawn-get-deal.php', {int_duration: value, pawn_price: product_price}, function (interest) {
                    if (interest == null) {
                        setData({});
                        alert('ไม่พบข้อมูลดอกเบี้ยที่ตั้งค่าใว้ในระบบ กรุณาเพิ่มอัตราดอกเบี้ยสำหรับเงินต้นนี้');
                        return false;
                    }
                    setData(interest);
                }, 'json');
            } else {
                setData({});
            }
            function setData(interest) {
                var totalAfterDeal = '';
                if (interest.int_cal != undefined) {
                    var interestPay = (parseInt(int_cal) - parseInt(pawn_pay) + parseInt(product_price));
                    totalAfterDeal = parseInt(interestPay) + parseInt(interest.int_cal);
                }
                $('input[name="pawn_deal_total"]').val(totalAfterDeal);
                $('input[name="pawn_deal_interest"]').val(interest.int_cal);
                $('input[name="pawn_deal_date"]').val(interest.pawn_date_end);
                $('input[name="pawn_deal_interest_value"]').val(interest.int_value);
            }
        });

        // การไถถ่อนจำนำ
        $('form[name="pawn-return"]').submit(function () { // การไถถ่อนจำนำ
            var message = '';
            var product_price = parseInt($('input[name="product_price"]').val());
            var pawn_pay = parseInt($('input[name="pawn_pay"]').val());
            var pawn_total = parseInt($('input[name="pawn_total"]').val());
            var int_cal = parseInt($('input[name="int_cal"]').val());
            if (pawn_pay >= pawn_total) { // แสดงว่าไถ่ถอนหมด
                message = 'คุณกำลังไถ่ถอนทรัพย์สินเต็มจำนวนเงิน';
                $(this).attr('action', 'pawn-return-save.php');
            } else {
                $(this).attr('action', 'pawn_deal_save.php');
                var interest = $('select[name="pawn_deal_interest_duration"]').val();
                if (pawn_pay <= int_cal) { // แสดงว่าลดดอก
                    message = 'คุณกำลังขยายระยะเวลาการไถ่ถอนออกไป';
                } else {
                    message = 'คุณกำลังชำระเงินในรูปแบบของการลดราคาจำนำระบบถือเป็นการขยายระยะเวลาการไถ่ถอนออกไป';
                }
                //console.log('interest ::==' + interest + ' pawn_pay ::== ' + pawn_pay + ' pawn_total ::==' + pawn_total + ' int_cal ::==' + int_cal);
                if (interest == '') {
                    alert(message + '\nคุณยังไม่ได้เลือกระยะเวลาที่ขยายออก กรุณาเลือกระยะเวลาขยายสัญญาด้วย\n');
                    return false;
                }
            }
            return confirm(message + ' ยืนยันการทำรายการหรือไม่');
        });
        $('select[name="type_id"]').on('change', function () {
            var name = $(this).find('option:selected').attr('data-name');
            $('input[name="type_name"]').val(name);
        });
        $('input[name="pawn_reduce"]').focusout(function () {
            var result = 0;
            var reduce = $(this).val();
            if (reduce !== '') {
                var total = $('input[name="pawn_total"]').val();
                result = parseInt(total) - parseInt(reduce);
            } else {
                result = 0;
            }
            $('input[name="pawn_result"]').val(result);
        });

        // กรอกเงินและคำนวนดอกเบี้ย
        $('#btnCalInterest').on('click', function () {
            var data = $('input[name="product_price"]').val();
            if (parseInt(data) <= 0) {
                setData({});
                alert('กรุณากรอกจำนวนเงินมากกว่า 0 บาท');
            } else {
                $.post('pawn-get-calculator.php', {pawn_price: data}, function (interest) {
                    if (interest === null) {
                        setData({});
                        alert('ไม่พบข้อมูลดอกเบี้ยที่ตั้งค่าใว้ในระบบ กรุณาเพิ่มอัตราดอกเบี้ยสำหรับเงินต้นนี้');
                    } else {
                        setData(interest);
                        alert('ระยะเวลาไถ่ถอนทรัพย์สินของท่านคือสิ้นสุดในวันที่ ' + interest.pawn_date_end);
                    }
                }, 'json');
            }
            function setData(interest) {
                $('input[name="int_id"]').val(interest.int_id);
                $('input[name="int_value"]').val(interest.int_value);
                $('input[name="pawn_total"]').val(interest.pawn_total);
                $('input[name="int_duration"]').val(interest.int_duration);
                $('[name="pawn_date_end"]').val(interest.pawn_date_end);
                $('[name="int_cal"]').val(interest.int_cal);
            }
        });
    });
</script>
<?php include '../include/inc_footer.php'; ?>