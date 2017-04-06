<?php include '../include/inc_header.php'; ?>
<div>
    <fieldset>
        <legend><img src="../images/menus/genaral-title.png"/></legend>        
        <form action="login-check.php" method="post" name="login" style="margin: 10px 200px 0px 200px;">
            <table border="0" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;"><label>Username</label></td>
                        <td style="width: 70%;"><input type="text" name="username" /></td>
                    </tr>
                    <tr>
                        <td><label>Username</label></td>
                        <td><input type="password" name="password"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="เข้าสู่ระบบ" />
                            <input type="reset" value="ล้างค่า" />
                        </td>
                    </tr>
                </tbody>
            </table>

        </form>
    </fieldset>
</div>
<?php include '../include/inc_footer.php'; ?>