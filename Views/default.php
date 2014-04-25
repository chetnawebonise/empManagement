<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 3:27 PM
 * To change this template use File | Settings | File Templates.
 */

$content = isset($_GET['module']) ? $_GET['module'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Management System</title>
    <meta http-equiv="Content-type" value="text/html; charset=UTF-8" />
</head>
<body>
<script src="jquery-2.1.0.js" type="text/javascript"></script>
<script src="jquery-ui-1.10.4.custom.js" type="text/javascript"></script>
<script type="text/javascript">

    function callServer(options)
    {
        var opts = {
            type: "post"
        };
        opts = $.extend(opts, options);
        $.ajax({
            type:opts['type'],
            url : opts['url'],
            dataType: "json",
            data:opts['data'],
            contentType: "application/json; charset=utf-8",
            success: opts.success
        });
    }
</script>

<table width="80%" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td height="80px" bgcolor="#999999" align="center" colspan="2" style="color: #fff; font-size: 18px;">Employee Management System</td>
    </tr>
    <tr>
        <td width="10%" style="border-right-style: solid;vertical-align: top;">
            <table align="left">
                <tr>
                    <td><a href="?module=home" style="color: blue;">Home</a></td>
                </tr>
                <tr>
                    <td><a href="?module=department" style="color: blue;">Department</a></td>
                </tr>
                <tr>
                    <td><a href="?module=jobTitle" style="color: blue;">Job Titles</a></td>
                </tr>
                <tr>
                    <td><a href="?module=employee"  style="color: blue;">Employee</a></td>
                </tr>
                <tr>
                    <td><a href="?module=deptEmployee"  style="color: blue;">Department Employees</a></td>
                </tr>
                <tr>
                    <td><a href="?module=deptManager"  style="color: blue;">Department Managers</a></td>
                </tr>
                <tr>
                    <td><a href="?module=empTitle"  style="color: blue;">Employee Titles</a></td>
                </tr>
                <tr>
                    <td><a href="?module=empSal"  style="color: blue;">Employee Salary</a></td>
                </tr>
                <tr>
                    <td><a href="?module=export"  style="color: blue;">Employee Data Export</a></td>
                </tr>
            </table>
        </td>
        <td width="90%">
            <?php
            switch($content)
            {
                case 'department':
                    include_once 'department.php';
                    break;
                case 'jobTitle':
                    include_once 'jobTitle.php';
                    break;
                case 'employee':
                    include_once 'emp.php';
                    break;
                case 'deptEmployee':
                    include_once 'deptEmployee.php';
                    break;
                case 'deptManager':
                    include_once 'deptManager.php';
                    break;
                case 'empTitle':
                    include_once 'empTitle.php';
                    break;
                case 'empSal':
                    include_once 'salary.php';
                    break;
                case 'export':
                    include_once 'export.php';
                    break;
                default:
                    include_once 'home.php';
                    break;
            }
            ?>
        </td>
    </tr>
    <tr>
        <td height="50px" bgcolor="#999999" align="center" colspan="2" style="color: #fff; font-size: 18px;">&copy; 2014</td>
    </tr>
</table>
</body>
</html>