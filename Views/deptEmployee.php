<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;
$deptEmpCls = new DeptEmp($dbConn);

if(isset($_POST) && $_POST)
{
    $dept = $_POST['slctDept'];
    $emp = $_POST['slctEmp'];
    $action = $_POST['action'];

    if($dept != '')
    {
        if($action == 'add')
            $count = $deptEmpCls->addDeptEmp(array('departmentId' => $dept, 'empId' => $emp));
        else
        {
            $count = $deptEmpCls->editDeptEmp(array('departmentId' => $dept, 'empId' => $emp), 'id = ' . $_POST['hdnDeptEmp']);
        }
    }
}

$result = $deptEmpCls->viewDeptEmp();

$dept = new Dept($dbConn);
$deptList = $dept->viewDept();

$emp = new Emp($dbConn);
$empList = $emp->viewEmp();

?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmDeptEmp" name="frmDeptEmp" method="post">
                <table width="100%"" style="padding-bottom:50px;">
                <tr>
                    <td colspan="2">ADD Department Employee</td>
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
                    <td>Employee:</td>
                    <td>
                        <select id="slctEmp" name="slctEmp">
                            <option value="">--Select Employee--</option>
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
                        <input type="hidden" value="" id="hdnDeptEmp" name="hdnDeptEmp" maxlength="100">
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
            <td>Employee</td>
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
                    <td><a href="#" class="editDeptEmp" data-deptId="<?php echo $row['id'];?>">Edit</a> | <a href="#" class="deleteDeptEmp" data-deptId="<?php echo $row['id'];?>">Delete</a></td>
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

    $('.editDeptEmp').click(onCLickEditDeptEmp);
    function onCLickEditDeptEmp()
    {
        var id = $(this).data('deptid');
        var dept = resultSet[id];
        $('#slctDept').val(dept['deptId']);
        $('#slctEmp').val(dept['empId']);
        $('#hdnDeptEmp').val(id);
        $('#action').val('edit');
    }

    $('.deleteDeptEmp').click(onCLickDeleteDeptEmp);
    function onCLickDeleteDeptEmp()
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
                document.getElementById("frmDeptEmp").reset();
            }
    );
</script>