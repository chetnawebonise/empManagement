<?php
/**
 * Created by JetBrains PhpStorm.
 * User: webonise
 * Date: 24/4/14
 * Time: 11:12 AM
 * To change this template use File | Settings | File Templates.
 */
function __autoload($class_name) {
    include_once '../classes/' . $class_name . '.php';
}

$id = $_REQUEST['id'];
$dbConn = new Db();
$deptEmpCls = new DeptEmp($dbConn);
$deptManagerCls = new DeptManager($dbConn);
$empTitleCls = new EmpTitle($dbConn);
$empSalaryCls = new Salary($dbConn);
$empCls = new Emp($dbConn);

$deptEmpResult = $deptEmpCls->deleteDeptEmp(array('empId' => $id));
$deptManagerResult = $deptManagerCls->deleteDeptManager(array('empId' => $id));
$empTitleResult = $empTitleCls->deleteEmpTitle(array('empId' => $id));
$salaryResult = $empSalaryCls->deleteSalary(array('empId' => $id));

//if($deptEmpResult && $deptManagerResult && $empTitleResult && $salaryResult)
    echo $empCls->deleteEmp(array('id' => $id));
//else
//    echo "Cannot be deleted";

//Error handling pending