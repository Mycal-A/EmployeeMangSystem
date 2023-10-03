<?php
require "Database.php";
require "functions.php";
// dd($_POST);
require "config.php";
$config = require("config.php");
$db = new Database($config['database']);
$allQueriesSuccessful = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission
    try {
        // Begin a transaction
        $db->connection->beginTransaction();

        // Update employee details
        $stmtEmployeeUpdate = $db->connection->prepare("UPDATE employee SET Name = :name, Email = :email, Password = :password, Location = :location, Role = :role, Salary = :salary WHERE Employee_ID = :employeeID");

        // Bind parameters for employee update
        $stmtEmployeeUpdate->bindParam(':name', $_POST['name']);
        $stmtEmployeeUpdate->bindParam(':email', $_POST['email']);
        $stmtEmployeeUpdate->bindParam(':password', $_POST['password']);
        $stmtEmployeeUpdate->bindParam(':location', $_POST['location']);
        $stmtEmployeeUpdate->bindParam(':role', $_POST['role']);
        $stmtEmployeeUpdate->bindParam(':salary', $_POST['salary']);
        $stmtEmployeeUpdate->bindParam(':employeeID', $_POST['empid']); // Employee_ID from the hidden input

        // Execute the employee update query
        $stmtEmployeeUpdate->execute();

        // Update education details
        // No need to fetch $educationDetails again, as you already have the data
        if (isset($_POST['education'])) {
            foreach ($_POST['education'] as $index => $education) {
                $educationID = $education['education_id'];
                
                // Check if the 'Education_ID' exists in the database
                $checkQuery = "SELECT COUNT(*) FROM empeducation WHERE Education_ID = :educationID";
                $stmtCheck = $db->connection->prepare($checkQuery);
                $stmtCheck->bindParam(':educationID', $educationID);
                $stmtCheck->execute();
                $count = $stmtCheck->fetchColumn();
        
                // Build the upsert query
                $upsertQuery = "
                    INSERT INTO empeducation (Education_ID, Employee_ID, Course, Institution, CGPA, Graduation_Year)
                    VALUES (:educationID, :employeeID, :course, :institution, :cgpa, :graduationYear)
                    ON DUPLICATE KEY UPDATE
                    Course = VALUES(Course),
                    Institution = VALUES(Institution),
                    CGPA = VALUES(CGPA),
                    Graduation_Year = VALUES(Graduation_Year)
                ";
        
                // Prepare the upsert query
                $stmtUpsert = $db->connection->prepare($upsertQuery);
        
                // Bind parameters for the upsert
                $stmtUpsert->bindParam(':educationID', $educationID);
                $stmtUpsert->bindParam(':employeeID', $_POST['empid']); // Use the employee ID from the hidden input
                $stmtUpsert->bindParam(':course', $education['name']);
                $stmtUpsert->bindParam(':institution', $education['institution']);
                $stmtUpsert->bindParam(':cgpa', $education['cgpa']);
                $stmtUpsert->bindParam(':graduationYear', $education['gradyear']);
        
                // Execute the upsert query
                $stmtUpsert->execute();
            }
        }
        

        //Family

        if (isset($_POST['family'])) {
            foreach ($_POST['family'] as $index => $family) {
                $familyID = $family['family_id'];
                
                // Check if the 'Family_ID' exists in the database
                $checkQuery = "SELECT COUNT(*) FROM empfamily WHERE family_id = :familyID";
                $stmtCheck = $db->connection->prepare($checkQuery);
                $stmtCheck->bindParam(':familyID', $familyID);
                $stmtCheck->execute();
                $count = $stmtCheck->fetchColumn();
        
                // Build the upsert query
                $upsertQuery = "
                    INSERT INTO empfamily (family_id, Employee_ID, Name, Relationship, DOB)
                    VALUES (:familyID, :employeeID, :name, :relationship, :dob)
                    ON DUPLICATE KEY UPDATE
                    Name = VALUES(Name),
                    Relationship = VALUES(Relationship),
                    DOB = VALUES(DOB)
                ";
        
                // Prepare the upsert query
                $stmtUpsert = $db->connection->prepare($upsertQuery);
        
                // Bind parameters for the upsert
                $stmtUpsert->bindParam(':familyID', $familyID);
                $stmtUpsert->bindParam(':employeeID', $_POST['empid']); // Use the employee ID from the hidden input
                $stmtUpsert->bindParam(':name', $family['name']);
                $stmtUpsert->bindParam(':relationship', $family['relationship']);
                $stmtUpsert->bindParam(':dob', $family['dob']);
        
                // Execute the upsert query
                $stmtUpsert->execute();
            }
        }
        

        //Experience

        if (isset($_POST['company'])) {
            foreach ($_POST['company'] as $index => $company) {
                $experienceID = $company['experience_id'];
                
                // Check if the 'Experience_ID' exists in the database
                $checkQuery = "SELECT COUNT(*) FROM empexperience WHERE experience_id = :experienceID";
                $stmtCheck = $db->connection->prepare($checkQuery);
                $stmtCheck->bindParam(':experienceID', $experienceID);
                $stmtCheck->execute();
                $count = $stmtCheck->fetchColumn();
        
                // Build the upsert query
                $upsertQuery = "
                    INSERT INTO empexperience (experience_id, Employee_ID, Company, Role, YearOfExperience)
                    VALUES (:experienceID, :employeeID, :companyName, :role, :yearsOfExperience)
                    ON DUPLICATE KEY UPDATE
                    Company = VALUES(Company),
                    Role = VALUES(Role),
                    YearOfExperience = VALUES(YearOfExperience)
                ";
        
                // Prepare the upsert query
                $stmtUpsert = $db->connection->prepare($upsertQuery);
        
                // Bind parameters for the upsert
                $stmtUpsert->bindParam(':experienceID', $experienceID);
                $stmtUpsert->bindParam(':employeeID', $_POST['empid']); // Use the employee ID from the hidden input
                $stmtUpsert->bindParam(':companyName', $company['name']);
                $stmtUpsert->bindParam(':role', $company['role']);
                $stmtUpsert->bindParam(':yearsOfExperience', $company['year']);
        
                // Execute the upsert query
                $stmtUpsert->execute();
            }
        }
        
        
        

        $db->connection->commit();
        
        echo "Employee, Education, Family Details, and Experience details updated successfully.";
    } catch (PDOException $e) {
        // Handle any database errors and roll back the transaction
        $db->connection->rollBack();
        $allQueriesSuccessful = false;
        // You might want to log or display the error here
        echo "Error: " . $e->getMessage();
    }

    if($allQueriesSuccessful = true){
        header('location: /adminHome?updateStatus=success');
        exit;
    }
    else {
        header('location: /adminHome?updateStatus=error');
        exit;
    }
}
