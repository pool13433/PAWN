<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pawn Shop Management System Store Aransound Case Study</title>
        <link href="../css/jquery-ui.css" type="text/css" rel="stylesheet"/>
        <link href="../css/pawn-style.css" type="text/css" rel="stylesheet"/>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/printThis.js"></script>
        <script type="text/javascript" src="../js/pawn-script.js"></script>
        <script type="text/javascript">
            $(function () {
                $('.datepicker').datepicker({
                    appendText: "(วัน-เดือน-ปี)",
                    dateFormat: "dd-mm-yy"
                });
            });
        </script>
    </head>
    <body style="margin: 0px 100px 0px 100px;background-color: #F2F2F2">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan="2" style="background-image: url('../images/img-header.png');height: 180px;"></td>
                </tr>
                <tr>
                    <td style="width: 23%;vertical-align: top;">

                        <?php if (empty($_SESSION['member'])) { ?>
                            <fieldset style="background-color: #FCF4D9">
                                <legend><img src="../images/menus/genaral-title.png"/></legend>
                                <a href="login.php"><img src="../images/menus/login.png"/></a>
                            </fieldset>
                            <fieldset style="background-color: #FCF4D9">
                                <legend><img src="../images/menus/news-title.png"/></legend>
                                <a href="news-list.php"><img src="../images/menus/news-product-expire.png"/></a>                                
                            </fieldset>
                            <fieldset style="background-color: #FCF4D9">
                                <legend><img src="../images/menus/expire-title.png"/></legend>
                                <a href="pawn-sale-list.php?scope=today"><img src="../images/menus/expire-today.png"/></a>
                                <a href="pawn-sale-list.php?scope=all"><img src="../images/menus/expire-all.png"/></a>
                            </fieldset>
                        <?php } else { ?>
                            <?php $member = $_SESSION['member']; ?>
                            <?php if ($member['mem_status'] == 'admin') { ?>
                                <fieldset style="background-color: #FCF4D9">
                                    <legend><img src="../images/menus/admin-title.png"/></legend>
                                    <a href="index.php"><img src="../images/menus/dashboard.png"/></a>       
                                    <hr/>
                                    <a href="pawn-form.php?case=create&href=pawn-form.php?case=create"><img src="../images/menus/pawn-get.png"/></a>                                    
                                    <a href="pawn-form.php?case=return&href=pawn-form.php?case=return"><img src="../images/menus/pawn-return.png"/></a>                                    
                                    <!--<a href="pawn-list.php?case=reduce"><img src="../images/menus/pawn-reduce.png"/></a>                                    
                                    <a href="pawn-list.php?case=expire"><img src="../images/menus/pawn-expire.png"/></a> -->
                                    <a href="pawn-list.php?case=finish"><img src="../images/menus/pawn-finish.png"/></a>     
                                    <a href="pawn-list.php?case=sale"><img src="../images/menus/pawn-sale.png"/></a>     
                                    <hr/>
                                    <a href="interest-list.php"><img src="../images/menus/crud-interest.png"/></a>
                                    <a href="pawn-status-list.php"><img src="../images/menus/crud-status.png"/></a>
                                    <a href="product-type-list.php"><img src="../images/menus/crud-type.png"/></a>
                                    <a href="news-list.php"><img src="../images/menus/crud-news.png"/></a>
                                    <a href="member-list.php"><img src="../images/menus/crud-member.png"/></a>
                                    <hr/>
                                    <a href="report-pawn-get.php"><img src="../images/menus/report-pawn.png"/></a>
                                    <a href="report-pawn-expire.php"><img src="../images/menus/report-expire.png"/></a>
                                    <a href="report-pawn-return.php"><img src="../images/menus/report-return.png"/></a>
                                    <a href="report-pawn-product.php"><img src="../images/menus/report-product.png"/></a>
                                </fieldset>
                            <?php } else { ?>
                                <fieldset style="background-color: #FCF4D9">
                                    <legend><img src="../images/menus/customer-title.png"/></legend>
                                    <a href="index.php"><img src="../images/menus/dashboard.png"/></a>
                                    <a href="pawn-list.php"><img src="../images/menus/customer-pawn.png"/></a>
                                    <a href="change-password.php"><img src="../images/menus/change-password.png"/></a>
                                    <a href="change-profile.php"><img src="../images/menus/change-profile.png"/></a>           
                                </fieldset>
                                <fieldset style="background-color: #FCF4D9">
                                    <legend><img src="../images/menus/expire-title.png"/></legend>
                                    <a href="pawn-sale-list.php?scope=today"><img src="../images/menus/expire-today.png"/></a>
                                    <a href="pawn-sale-list.php?scope=all"><img src="../images/menus/expire-all.png"/></a>
                                </fieldset>
                            <?php } ?>
                            <hr/>
                            <div align='center'>
                                <a href="../include/logout.php" onclick="return confirm('ยืนยันออกจากระบบ')"><img src="../images/menus/logout.png"/></a>
                            </div>
                        <?php } ?>

                    </td>
                    <td style="width: 77%;vertical-align: top;">



