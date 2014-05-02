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
                <table width="100%" class="table-condensed">
                    <thead>
                        <td colspan="2"><h6>ADD Job Title</h6></td>
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
                        <td>Title:</td>
                        <td><input type="text" value="" id="txtJobTitle" name="txtJobTitle" maxlength="100" class="input-large"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" value="" id="hdnJobTitle" name="hdnJobTitle" maxlength="100">
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
                    <th>Name</th>
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
                        <td><?php echo utf8toHtml($row['title']);?></td>
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
            window.location.href = 'index.php?module=jobTitle';
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