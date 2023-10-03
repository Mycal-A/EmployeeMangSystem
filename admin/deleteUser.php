<?php

require "functions.php";
require "Database.php";
$config = require("config.php");
$db = new Database($config['database']);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    try {
        $empdel = $db->query("DELETE FROM employee WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        $edudel = $db->query("DELETE FROM empeducation WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        $famdel = $db->query("DELETE FROM empfamily WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        $expdel = $db->query("DELETE FROM empexperience WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        
        if ($empdel && $edudel && $famdel && $expdel) {
            header("Location: /adminHome?status=success");
            exit;
        } else {
            header("Location: /adminHome?status=error");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


}