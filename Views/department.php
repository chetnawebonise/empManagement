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
                <table width="100%"" class="table-condensed">
                    <thead>
                        <td colspan="2"><h6>ADD Department</h6></td>
                    </thead>
                    <?php
                    if($count)
                    {
                    ?>
                        <tr>
                            <td colspan="2" class="text-success"><?php echo $count;?> affected</td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td>Name:</td>
                        <td><input type="text" value="" id="txtDept" name="txtDept" maxlength="100" class="input-large"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" value="" id="hdnDept" name="hdnDept" maxlength="100">
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
                    <td width="10%">Sr. No.</td>
                    <td>Name</td>
                    <td width="15%">Actions</td>
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
                        <td><?php echo utf8toHtml($row['deptName']);?></td>
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
        dataType:"json",
        success :function(response)
        {
            window.location.href = 'index.php?module=department';
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