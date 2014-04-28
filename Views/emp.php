<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;

$empCls = new Emp($dbConn);
$result = $empCls->viewEmp();

$deptCls = new Dept($dbConn);
$dept = $deptCls->viewDept();

$jobTitleCls = new JobTitle($dbConn);
$jobTitle = $jobTitleCls->viewJobTitle();

if(isset($_POST) && $_POST)
{
    $params = array(
        'empName' => $_POST['txtName'],
        'dob' => date('Y-m-d', (strtotime($_POST['txtDob']))),
        'gender' => $_POST['rdGender'],
        'hireDate' => date('Y-m-d', (strtotime($_POST['txtHireDate'])))
    );
    $managerId = $_POST['slctEmpManager'];
    if($managerId != '')
        $params['managerId'] = $managerId;

    $action = $_POST['action'];

    if(count($params) > 0)
    {
        if($action == 'add')
        {
            $empId = $empCls->addEmp($params);
//            if($empId > 0)
//            {
//                $params = array(
//                    'empId' => $empId,
//                    'departmentId' => $_POST['slctDept'],
//                    'fromDate' => date('Y-m-d', (strtotime($_POST['txtFrom']))),
//                    'toDate' => date('Y-m-d', (strtotime($_POST['txtTo'])))
//                );
//                $success = $empCls->addDeptEmp($params);
//
//                $params = array(
//                    'departmentId' => $_POST['slctDept'],
//                    'fromDate' => date('Y-m-d', (strtotime($_POST['txtManagerFrom']))),
//                    'toDate' => date('Y-m-d', (strtotime($_POST['txtManagerTo'])))
//                );
//                if(($_POST['slctManager'] !=''))
//                    $params['managerId'] = $_POST['slctManager'];
//                $success = $empCls->addDeptManager($params);
//
//                $params = array(
//                    'empId' => $empId,
//                    'jobTitleId' => $_POST['slctJobTitle'],
//                    'fromDate' => date('Y-m-d', (strtotime($_POST['txtJobFrom']))),
//                    'toDate' => date('Y-m-d', (strtotime($_POST['txtJobTo'])))
//                );
//                $success = $empCls->addEmpJobTitle($params);
//
//                $params = array(
//                    'empId' => $empId,
//                    'salary' => $_POST['txtSal'],
//                    'fromDate' => date('Y-m-d', (strtotime($_POST['txtSalFrom']))),
//                    'toDate' => date('Y-m-d', (strtotime($_POST['txtSalTo'])))
//                );
//                $success = $empCls->addSalaries($params);
//            }
        }
        else
        {
            $count = $empCls->editEmp($params, 'id = ' . $_POST['hdnEmp']);
        }
    }
}
?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmEmp" name="frmEmp" method="post">
                <table width="100%"" style="padding-bottom:50px;">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">ADD Employee</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight: bold;">&nbsp;</td>
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
                        <td><input type="text" value="" id="txtName" name="txtName" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td>Manager:</td>
                        <td>
                            <select id="slctEmpManager" name="slctEmpManager">
                                <option value="">--Select--</option>
                                <?php
                                foreach($result as $row)
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
                        <td>Dob:</td>
                        <td><input type="text" value="" id="txtDob" name="txtDob" maxlength="10"></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>
                            <input type="radio" value="M" id="rdMale" name="rdGender" maxlength="10" class="rdGender"> Male
                            <input type="radio" value="F" id="rdFemale" name="rdGender" maxlength="10" class="rdGender"> Female
                        </td>
                    </tr>
                    <tr>
                        <td>Hire Date:</td>
                        <td><input type="text" value="" id="txtHireDate" name="txtHireDate" maxlength="10"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="" id="hdnEmp" name="hdnEmp" maxlength="100">
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
                foreach ($result as $empRow)
                {
            ?>
                    <script type="text/javascript">
                        resultSet['<?php echo $empRow['id'];?>'] = <?php echo json_encode($empRow);?>;
                    </script>
                    <tr>
                        <td><?php echo $index;?></td>
                        <td><?php echo $empRow['empName'];?></td>
                        <td><a href="#" class="editEmp" data-empId="<?php echo $empRow['id'];?>">Edit</a> | <a href="#" class="deleteEmp" data-empId="<?php echo $empRow['id'];?>">Delete</a></td>
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

$('#txtDob').datepicker();
$('#txtHireDate').datepicker();
$('#txtFrom').datepicker();
$('#txtTo').datepicker();

$('.editEmp').click(onCLickEditEmp);
function onCLickEditEmp()
{
    var id = $(this).data('empid');
    var emp = resultSet[id];
    $('#txtName').val(emp['empName']);
    $('#slctEmpManager').val(emp['managerId']);
    $('#txtDob').datepicker('setDate', new Date(emp['dob']));
    $('input:radio[name="rdGender"]').filter('[value="' + emp['gender'] + '"]').attr('checked', true);
    $('#txtHireDate').datepicker('setDate', new Date(emp['hireDate']));
    $('#hdnEmp').val(id);
    $('#action').val('edit');
}

$('.deleteEmp').click(onCLickDeleteEmp);
function onCLickDeleteEmp()
{
    var id = $(this).data('empid');
    var options = {
        url : 'ajax/emp.php',
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
            document.getElementById("frmEmp").reset();
        }
);
</script>