<?php
session_start();
require "Database.php";
require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

$employeeID = null;

// Delete Education Record
if (isset($_GET['educationid'])) {
    $id = $_GET['educationid'];
    try {
        // Retrieve the Employee_ID before deleting the record
        $stmt = $db->query("SELECT Employee_ID FROM empeducation WHERE education_id = :id", [':id' => $id]);
        $result = $stmt->get(PDO::FETCH_ASSOC);
        $result=$result[0];

        if ($result && isset($result['Employee_ID'])) {
            $employeeID = $result['Employee_ID'];
            //dd($employeeID);
        } else {
            dd('No ID retrived from education');
        }

        $edudel = $db->query("DELETE FROM empeducation WHERE education_id = :id", [':id' => $id]);

        if ($edudel) {
            // Return the Employee_ID as a query parameter with the status
            header("Location: /adminViewEdit?id=" . $employeeID . "&status=success");
            exit;
        } else {
            // Return the Employee_ID as a query parameter with the status "error"
            header("Location: /adminViewEdit?id=" . $employeeID . "&status=error");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// Delete Family Record
if (isset($_GET['familyid'])) {
    $id = $_GET['familyid'];
    try {
        // Retrieve the Employee_ID before deleting the record
        $stmt = $db->query("SELECT Employee_ID FROM empfamily WHERE family_id = :id", [':id' => $id]);
        $result = $stmt->get(PDO::FETCH_ASSOC);
        $result = $result[0]; // Get the first row of the result

        if ($result && isset($result['Employee_ID'])) {
            $employeeID = $result['Employee_ID'];
            //dd($employeeID);
        } else {
            dd('No ID retrieved from family ');
        }

        $famdel = $db->query("DELETE FROM empfamily WHERE family_id = :id", [':id' => $id]);

        if ($famdel) {
            // Return the Employee_ID as a query parameter with the status
            header("Location: /adminViewEdit?id=" . $employeeID . "&status=success");
            exit;
        } else {
            // Return the Employee_ID as a query parameter with the status "error"
            header("Location: /adminViewEdit?id=" . $employeeID . "&status=error");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// Delete Experience Record
if (isset($_GET['experienceid'])) {
    $id = $_GET['experienceid'];
    try {
        // Retrieve the Employee_ID before deleting the record
        $stmt = $db->query("SELECT Employee_ID FROM empexperience WHERE experience_id = :id", [':id' => $id]);
        $result = $stmt->get(PDO::FETCH_ASSOC);
        $result = $result[0]; // Get the first row of the result

        if ($result && isset($result['Employee_ID'])) {
            $employeeID = $result['Employee_ID'];
            //dd($employeeID);
        } else {
            dd('No ID retrieved from experience');
        }

        $expdel = $db->query("DELETE FROM empexperience WHERE experience_id = :id", [':id' => $id]);

        if ($expdel) {
            // Return the Employee_ID as a query parameter with the status
            header("Location: /adminViewEdit?id=" . $employeeID . "&status=success");
            exit;
        } else {
            // Return the Employee_ID as a query parameter with the status "error"
            header("Location: /adminViewEdit?id=" . $employeeID . "&status=error");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

