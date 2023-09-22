<?php

if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}

require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

if(isset($_GET['id'])){
    $id = $_GET['id'];
    try {
        $empdel = $db->query("DELETE FROM employee WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        $edudel = $db->query("DELETE FROM education WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        $famdel = $db->query("DELETE FROM familydetails WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        $expdel = $db->query("DELETE FROM experience WHERE Employee_ID = :id", [':id' => $_GET['id']]);
        
        if ($empdel && $edudel && $famdel && $expdel) {
            header("Location: /?status=success");
            exit;
        } else {
            header("Location: /?status=error");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


}