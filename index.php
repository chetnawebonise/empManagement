<?php

ob_start();
error_reporting(E_ALL);

$baseUrl = $_SERVER['HTTP_HOST'];

function __autoload($class_name) {
    include_once 'classes/' . $class_name . '.php';
}

$dbConn = new Db();

include_once 'Views/default.php';

$dbConn = null;

?>