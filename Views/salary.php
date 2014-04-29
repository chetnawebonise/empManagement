<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;
$salaryCls = new Salary($dbConn);

if(isset($_POST) && $_POST)
{
    $emp = $_POST['slctEmp'];
    $salary = $_POST['txtSalary'];
    $fromDate = date('Y-m-d', (strtotime($_POST['txtFrom'])));
    $toDate = date('Y-m-d', (strtotime($_POST['txtTo'])));
    $action = $_POST['action'];

    if($emp != '' && $salary != '')
    {
        if($action == 'add')
            $count = $salaryCls->addSalary(array('salary' => $salary, 'empId' => $emp, 'fromDate' => $fromDate, 'toDate' => $toDate));
        else
        {
            $count = $salaryCls->editSalary(array('salary' => $salary, 'empId' => $emp, 'fromDate' => $fromDate, 'toDate' => $toDate), 'id = ' . $_POST['hdnSalary']);
        }
    }
}

$result = $salaryCls->viewSalary();

$emp = new Emp($dbConn);
$empList = $emp->viewEmp();

?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmSalary" name="frmSalary" method="post">
                <table width="100%"" style="padding-bottom:50px;">
                <tr>
                    <td colspan="2">ADD Employee Salaries</td>
                </tr>
                <?php
                if($count)
                {
                    ?>
                    <tr>
                        <td colspan="2">1 row affected</td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td>Employee:</td>
                    <td>
                        <select id="slctEmp" name="slctEmp">
                            <option value="">--Select Employee--</option>
                            <?php
                            foreach($empList as $row)
                            {
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo utf8toHtml($row['empName']);?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Salary:</td>
                    <td><input type="text" id="txtSalary" name="txtSalary" value=""></td>
                </tr>
                <tr>
                    <td>From:</td>
                    <td><input type="text" value="" id="txtFrom" name="txtFrom" maxlength="10"></td>
                </tr>
                <tr>
                    <td>To:</td>
                    <td><input type="text" value="" id="txtTo" name="txtTo" maxlength="10"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" value="" id="hdnSalary" name="hdnSalary" maxlength="100">
                        <input type="hidden" value="add" id="action" name="action" maxlength="100">
                        <input type="submit" value="Save" id="btnSubmit">&nbsp;&nbsp;
                        <input type="button" value="Cancel" id="btnCancel">
                    </td>
                </tr>
                <tr height="50px">
                    <td colspan="2"><hr></td>
                </tr>
</table>
</form>
</td>
</tr>
<tr>
    <td>
        <table width="100%" cellpadding="1" cellspacing="2" border="1">
            <thead>
            <td>Sr. No.</td>
            <td>Employee</td>
            <td>Salary</td>
            <td>Actions</td>
            </thead>
            <?php
            $index = 1;
            foreach ($result as $row)
            {
                ?>
                <script type="text/javascript">
                    resultSet['<?php echo $row['id'];?>'] = <?php echo json_encode($row);?>;
                </script>
                <tr>
                    <td><?php echo $index;?></td>
                    <td><?php echo utf8toHtml($row['empName']);?></td>
                    <td><?php echo utf8toHtml($row['salary']);?></td>
                    <td><a href="#" class="editSalary" data-deptId="<?php echo $row['id'];?>">Edit</a> | <a href="#" class="deleteSalary" data-deptId="<?php echo $row['id'];?>">Delete</a></td>
                </tr>
                <?php
                $index++;
            }
            ?>
        </table>
    </td>
</tr>
</table>

<script type="text/javascript">

    $('#txtFrom').datepicker();
    $('#txtTo').datepicker();

    $('.editSalary').click(onCLickEditSalary);
    function onCLickEditSalary()
    {
        var id = $(this).data('deptid');
        var dept = resultSet[id];
        $('#slctEmp').val(dept['empId']);
        $('#txtSalary').val(dept['salary']);
        $('#txtFrom').datepicker('setDate', new Date(dept['fromDate']));
        $('#txtTo').datepicker('setDate', new Date(dept['toDate']));
        $('#hdnSalary').val(id);
        $('#action').val('edit');
    }

    $('.deleteSalary').click(onCLickDeleteSalary);
    function onCLickDeleteSalary()
    {
        var id = $(this).data('deptid');
        var options = {
            url : 'ajax/salary.php',
            data : {id: id},
            success :function(response)
            {
                window.location.href = 'index.php?module=empSal';
            }
        };
        callServer(options);
    }

    $('#btnCancel').click(function()
            {
                document.getElementById("frmSalary").reset();
            }
    );
</script>