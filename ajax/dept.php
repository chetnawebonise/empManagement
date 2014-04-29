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

$id = $_REQUEST['deptId'];
$dbConn = new Db();
$deptCls = new Dept($dbConn);
echo $deptCls->deleteDept(array('id' => $id));