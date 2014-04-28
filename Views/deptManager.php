<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;
$deptManagerCls = new DeptManager($dbConn);

if(isset($_POST) && $_POST)
{
    $dept = $_POST['slctDept'];
    $emp = $_POST['slctEmp'];
    $action = $_POST['action'];

    if($dept != '')
    {
        if($action == 'add')
            $count = $deptManagerCls->addDeptManager(array('departmentId' => $dept, 'managerId' => $emp));
        else
        {
            $count = $deptManagerCls->editDeptManager(array('departmentId' => $dept, 'managerId' => $emp), 'id = ' . $_POST['hdnDeptManager']);
        }
    }
}

$result = $deptManagerCls->viewDeptManager();

$dept = new Dept($dbConn);
$deptList = $dept->viewDept();

$emp = new Emp($dbConn);
$empList = $emp->viewEmpManager();

?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmDeptManager" name="frmDeptManager" method="post">
                <table width="100%"" style="padding-bottom:50px;">
                <tr>
                    <td colspan="2">ADD Department Manager</td>
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
                    <td>Department:</td>
                    <td>
                        <select id="slctDept" name="slctDept">
                            <option value="">--Select Department--</option>
                            <?php
                            foreach($deptList as $row)
                            {
                            ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['deptName'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Manager:</td>
                    <td>
                        <select id="slctEmp" name="slctEmp">
                            <option value="">--Select Manager--</option>
                            <?php
                            foreach($empList as $row)
                            {
                            ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['empName'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" value="" id="hdnDeptManager" name="hdnDeptManager" maxlength="100">
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
            <td>Department</td>
            <td>Manager</td>
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
                    <td><?php echo $row['deptName'];?></td>
                    <td><?php echo $row['empName'];?></td>
                    <td><a href="#" class="editDeptManager" data-deptId="<?php echo $row['id'];?>">Edit</a> | <a href="#" class="deleteDeptManager" data-deptId="<?php echo $row['id'];?>">Delete</a></td>
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

    $('.editDeptManager').click(onCLickEditDeptManager);
    function onCLickEditDeptManager()
    {
        var id = $(this).data('deptid');
        var dept = resultSet[id];
        $('#slctDept').val(dept['deptId']);
        $('#slctEmp').val(dept['managerId']);
        $('#hdnDeptManager').val(id);
        $('#action').val('edit');
    }

    $('.deleteDeptManager').click(onCLickDeleteDeptManager);
    function onCLickDeleteDeptManager()
    {
        var id = $(this).data('deptid');
        var options = {
            url : 'ajax/deptEmp.php',
            data : {id: id},
            success :function(response)
            {
                console.log(response);
            }
        };
        callServer(options);
    }

    $('#btnCancel').click(function()
            {
                document.getElementById("frmDeptManager").reset();
            }
    );
</script>