<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 23/4/14
 * Time: 5:27 PM
 * To change this template use File | Settings | File Templates.
 */

$count = 0;
$jobTitleCls = new JobTitle($dbConn);

if(isset($_POST) && $_POST)
{
    $jobTitle = $_POST['txtJobTitle'];
    $action = $_POST['action'];

    if($jobTitle != '')
    {
        if($action == 'add')
            $count = $jobTitleCls->addJobTitle(array('title' => $jobTitle));
        else
        {
            $count = $jobTitleCls->editJobTitle(array('title' => $jobTitle), 'id = ' . $_POST['hdnJobTitle']);
        }
    }
}

$result = $jobTitleCls->viewJobTitle();

?>

<script type="text/javascript">
    var resultSet = {};
</script>

<table width="100%" align="center" style="padding: 100px 0;">
    <tr>
        <td>
            <form action="#" id="frmJobTitle" name="frmJobTitle" method="post">
                <table width="100%"" style="padding-bottom:50px;">
                    <tr>
                        <td colspan="2">ADD Job Title</td>
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
                        <td>Title:</td>
                        <td><input type="text" value="" id="txtJobTitle" name="txtJobTitle" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" value="" id="hdnJobTitle" name="hdnJobTitle" maxlength="100">
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
                        <td><?php echo $row['title'];?></td>
                        <td><a href="#" class="editJobTitle" data-jobTitleId="<?php echo $row['id'];?>">Edit</a> | <a href="#" class="deleteJobTitle" data-jobTitleId="<?php echo $row['id'];?>">Delete</a></td>
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

$('.editJobTitle').click(onCLickEditJobTitle);
function onCLickEditJobTitle()
{
    var id = $(this).data('jobtitleid');
    var jobTitle = resultSet[id];
    $('#txtJobTitle').val(jobTitle['title']);
    $('#hdnJobTitle').val(id);
    $('#action').val('edit');
}

$('.deleteJobTitle').click(onCLickDeleteJobTitle);
function onCLickDeleteJobTitle()
{
    var id = $(this).data('jobtitleid');
    var options = {
        url : 'ajax/jobTitle.php',
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
            document.getElementById("frmJobTitle").reset();
        }
);
</script>