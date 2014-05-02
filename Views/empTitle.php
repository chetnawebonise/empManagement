<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;
$empTitleCls = new EmpTitle($dbConn);

if(isset($_POST) && $_POST)
{
    $emp = $_POST['slctEmp'];
    $title = $_POST['slctTitle'];
    $fromDate = date('Y-m-d', (strtotime($_POST['txtFrom'])));
    $toDate = date('Y-m-d', (strtotime($_POST['txtTo'])));
    $action = $_POST['action'];

    if($emp != '' && $title != '')
    {
        if($action == 'add')
            $count = $empTitleCls->addEmpTitle(array('jobTitleId' => $title, 'empId' => $emp, 'fromDate' => $fromDate, 'toDate' => $toDate));
        else
        {
            $count = $empTitleCls->editEmpTitle(array('jobTitleId' => $title, 'empId' => $emp, 'fromDate' => $fromDate, 'toDate' => $toDate), 'id = ' . $_POST['hdnEmpTitle']);
        }
    }
}

$result = $empTitleCls->viewEmpTitle();

$jobTitle = new JobTitle($dbConn);
$titleList = $jobTitle->viewJobTitle();

$emp = new Emp($dbConn);
$empList = $emp->viewEmp();

?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmEmpTitle" name="frmEmpTitle" method="post">
                <table width="100%" class="table-condensed">
                <thead>
                    <td colspan="2"><h6>ADD Employee Title</h6></td>
                </thead>
                <?php
                if($count)
                {
                    ?>
                    <tr>
                        <td colspan="2" class="text-success">1 row affected</td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td>Employee:</td>
                    <td>
                        <select id="slctEmp" name="slctEmp" class="dropdown">
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
                    <td>Job Title:</td>
                    <td>
                        <select id="slctTitle" name="slctTitle" class="dropdown">
                            <option value="">--Select Job Title--</option>
                            <?php
                            foreach($titleList as $row)
                            {
                            ?>
                                <option value="<?php echo $row['id'];?>"><?php echo utf8toHtml($row['title']);?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>From:</td>
                    <td><input type="text" value="" id="txtFrom" name="txtFrom" maxlength="10" class="input-large"></td>
                </tr>
                <tr>
                    <td>To:</td>
                    <td><input type="text" value="" id="txtTo" name="txtTo" maxlength="10" class="input-large"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" value="" id="hdnEmpTitle" name="hdnEmpTitle" maxlength="100">
                        <input type="hidden" value="add" id="action" name="action" maxlength="100">
                        <input type="submit" value="Save" id="btnSubmit" class="btn btn-primary">&nbsp;&nbsp;
                        <input type="reset" value="Cancel" id="btnCancel" class="btn">
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
        <table width="100%" class="table-hover table">
            <thead>
            <th>Sr. No.</th>
            <th>Employee</th>
            <th>Job Title</th>
            <th>Actions</th>
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
                    <td><?php echo utf8toHtml($row['title']);?></td>
                    <td><a href="#" class="editEmpTitle" data-deptId="<?php echo $row['id'];?>">Edit</a> | <a href="#" class="deleteEmpTitle" data-deptId="<?php echo $row['id'];?>">Delete</a></td>
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

    $('.editEmpTitle').click(onCLickEditEmpTitle);
    function onCLickEditEmpTitle()
    {
        var id = $(this).data('deptid');
        var dept = resultSet[id];
        $('#slctEmp').val(dept['empId']);
        $('#slctTitle').val(dept['titleId']);
        $('#txtFrom').datepicker('setDate', new Date(dept['fromDate']));
        $('#txtTo').datepicker('setDate', new Date(dept['toDate']));
        $('#hdnEmpTitle').val(id);
        $('#action').val('edit');
    }

    $('.deleteEmpTitle').click(onCLickDeleteEmpTitle);
    function onCLickDeleteEmpTitle()
    {
        var id = $(this).data('deptid');
        var options = {
            url : 'ajax/EmpTitle.php',
            data : {id: id},
            success :function(response)
            {
                window.location.href = 'index.php?module=empTitle';
            }
        };
        callServer(options);
    }

    $('#btnCancel').click(function()
            {
                document.getElementById("frmEmpTitle").reset();
            }
    );
</script>