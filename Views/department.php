<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;
$deptCls = new Dept($dbConn);

if(isset($_POST) && $_POST)
{
    $dept = $_POST['txtDept'];
    $action = $_POST['action'];

    if($dept != '')
    {
        if($action == 'add')
            $count = $deptCls->addDept(array('deptName' => $dept));
        else
        {
            $count = $deptCls->editDept(array('deptName' => $dept), 'id = ' . $_POST['hdnDept']);
        }
    }
}

$result = $deptCls->viewDept();

?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmDept" name="frmDept" method="post">
                <table width="100%"" style="padding-bottom:50px;">
                    <tr>
                        <td colspan="2">ADD Department</td>
                    </tr>
                    <?php
                    if($count)
                    {
                    ?>
                        <tr>
                            <td colspan="2"><?php echo $count;?> affected</td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" value="" id="txtDept" name="txtDept" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="" id="hdnDept" name="hdnDept" maxlength="100">
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
            <table width="100%" cellpadding="0" cellspacing="0" border="1">
                <thead>
                    <td>Sr. No.</td>
                    <td>Name</td>
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
                        <td><a href="#" class="editDept" data-deptId="<?php echo $row['id'];?>">Edit</a> | <a href="#" class="deleteDept" data-deptId="<?php echo $row['id'];?>">Delete</a></td>
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

$('.editDept').click(onCLickEditDept);
function onCLickEditDept()
{
    var id = $(this).data('deptid');
    var dept = resultSet[id];
    $('#txtDept').val(dept['deptName']);
    $('#hdnDept').val(id);
    $('#action').val('edit');
}

$('.deleteDept').click(onCLickDeleteDept);
function onCLickDeleteDept()
{
    var deptId = $(this).data('deptid');
    var options = {
        url : 'ajax/dept.php',
        data : {deptId: deptId},
        success :function(response)
        {
            console.log(response);
        }
    };
    callServer(options);
}

$('#btnCancel').click(function()
        {
            document.getElementById("frmDept").reset();
        }
);
</script>