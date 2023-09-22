<?php

$id=$_GET['id'];
$status=$_GET['status'];

$config = require("config.php");
$db = new Database($config['database']);

$db->query("Update employee set Access= :status where Employee_ID=:id",[':id'=>$id, ':status'=>$status]);

header('location: empdetails');
        exit();

?>