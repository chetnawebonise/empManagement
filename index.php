<?php

ob_start();
error_reporting(E_ALL);

$baseUrl = $_SERVER['HTTP_HOST'];

include_once 'classes/Db.php';
include_once 'classes/Dept.php';
include_once 'classes/DeptEmp.php';
include_once 'classes/DeptManager.php';
include_once 'classes/Emp.php';
include_once 'classes/EmpTitle.php';
include_once 'classes/JobTitle.php';
include_once 'classes/PHPExcel.php';
include_once 'classes/Salary.php';

$dbConn = new Db();

include_once 'Views/default.php';

$dbConn = null;

?>