<?php
require "functions.php";
require "Database.php";
require "config.php";
$config = require("config.php");
$db = new Database($config['database']);

$allQueriesSuccessful = true;
$emailAlreadyRegistered = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the email already exists in the database
    $existingEmail = $db->query('SELECT Email FROM employee WHERE Email = :email', [
        'email' => $_POST['email']
    ])->find();

    if ($existingEmail) {
        // Email is already registered, set the flag to true
        $emailAlreadyRegistered = true;
        header('location: /createUserView?emailExists=true');
        exit;
    }
}

if ($emailAlreadyRegistered) {
  header('location: /createUserView?emailExists=true');
  exit;
}

try {
    // Begin a transaction
    $db->connection->beginTransaction();

    // Insert data into the 'employee' table
    $stmtEmployee = $db->connection->prepare("INSERT INTO employee (Name, Email, Password, Location, Role, Salary) VALUES (:name, :email, :password, :location, :role, :salary)");

    // Bind parameters for employee details
    $stmtEmployee->bindParam(':name', $_POST['name']);
    $stmtEmployee->bindParam(':email', $_POST['email']);
    $stmtEmployee->bindParam(':password', $_POST['password']);
    $stmtEmployee->bindParam(':location', $_POST['location']);
    $stmtEmployee->bindParam(':role', $_POST['role']);
    $stmtEmployee->bindParam(':salary', $_POST['salary']);

    // Execute the statement for employee details
    $stmtEmployee->execute();

    $employeeID = $db->lastInsertId(); // Get the ID of the newly inserted employee



    $existingEducationQuery = "SELECT * FROM empeducation WHERE Employee_ID = :employeeID";
$existingEducationParams = [':employeeID' => $employeeID];
$existingEducationDetails = $db->query($existingEducationQuery, $existingEducationParams)->get();

    // Prepare the SQL INSERT query for Education
    $stmtEducation = $db->connection->prepare("INSERT INTO empeducation (Employee_ID, Course, Institution, CGPA, Graduation_Year) VALUES (:employeeID, :course, :institution, :cgpa, :graduationYear)");

    // Loop through the education details and execute the prepared statement for each
    foreach ($_POST['education'] as $education) {
        $course = $education['name'];
        $institution = $education['institution'];
        $cgpa = $education['cgpa'];
        $graduationYear = $education['gradyear'];

        // Bind parameters for education
        $stmtEducation->bindParam(':employeeID', $employeeID);
        $stmtEducation->bindParam(':course', $course);
        $stmtEducation->bindParam(':institution', $institution);
        $stmtEducation->bindParam(':cgpa', $cgpa);
        $stmtEducation->bindParam(':graduationYear', $graduationYear);

        // Execute the statement for this education detail
        $stmtEducation->execute();
    }

    // Prepare the SQL INSERT query for Family Details
    $stmtFamily = $db->connection->prepare("INSERT INTO empfamily (Employee_ID, Name, Relationship, DOB) VALUES (:employeeID, :name, :relationship, :dobValue)");

    // Loop through the family details and execute the prepared statement for each
    foreach ($_POST['family'] as $family) {
        $name = $family['name'];
        $relationship = $family['relationship'];
        $dobValue = $family['dob'];

        // Check if the name already exists in empfamily
        $existingName = $db->query("SELECT Name FROM empfamily WHERE Name = :name AND Employee_ID = :employeeID", [
            'name' => $name,
            'employeeID' => $employeeID
        ])->find();

        if (!$existingName) {
            // Name doesn't exist, insert it
            $stmtFamily->bindParam(':employeeID', $employeeID);
            $stmtFamily->bindParam(':name', $name);
            $stmtFamily->bindParam(':relationship', $relationship);
            $stmtFamily->bindParam(':dobValue', $dobValue);

            // Execute the statement for this family detail
            $stmtFamily->execute();
        }
    }

    // Prepare the SQL INSERT query for Experience
    $stmtExperience = $db->connection->prepare("INSERT INTO empexperience (Employee_ID, Company, Role, YearOfExperience) VALUES (:employeeID, :company, :role, :yearOfExperience)");

    // Loop through the experience details and execute the prepared statement for each
    foreach ($_POST['company'] as $company) {
        $companyName = $company['name'];
        $role = $company['role'];
        $yearOfExperience = $company['year'];

        // Bind parameters for experience
        $stmtExperience->bindParam(':employeeID', $employeeID);
        $stmtExperience->bindParam(':company', $companyName);
        $stmtExperience->bindParam(':role', $role);
        $stmtExperience->bindParam(':yearOfExperience', $yearOfExperience);

        // Execute the statement for this experience detail
        $stmtExperience->execute();
    }

    // Commit the transaction
    $db->connection->commit();

    // Insertion successful
    echo "Employee, Education, Family Details, and Experience details inserted successfully.";
} catch (PDOException $e) {
    // Handle any database errors and roll back the transaction
    $db->connection->rollBack();
    $allQueriesSuccessful = false;
}


if ($allQueriesSuccessful) {
    // All queries executed successfully
    header('location: /empdetails?createstatus=success');
    exit;
} else {
    // At least one query failed
    header('location: /empdetails?createstatus=error');
    exit;
}

?>