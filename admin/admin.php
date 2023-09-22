<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}
require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

$result=$db->query("select * from employee");

// dd($notes);


include "admin/empdetails.php";







