<?php require "Database.php" ?>

<?php
session_start();
if (!isset($_SESSION['user'])==='admin@gmail.com') {
    header("Location: /");
    exit();
}
require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

$result=$db->query("select * from employee");

// dd($notes);


include "admin/empdetails.php";







