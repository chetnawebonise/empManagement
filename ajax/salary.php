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
$salaryCls = new Salary($dbConn);
echo $salaryCls->deleteSalary(array('id' => $id));