<?php

if (!isset($_SESSION['user'])) {
  header("Location: /");
  exit();
}
require "functions.php";
require "config.php";
$config = require("config.php");
$db = new Database($config['database']);
try {
    // Insert data into the employee table and get the last inserted Employee_ID
$createEmp=$db->query("INSERT INTO employee (Name, Email, Password, Location, Role, Salary)
  VALUES (:name, :email, :password, :location, :role, :salary)",
  [
    ':name' => $_POST['name'],
    ':email' => $_POST['email'],
    ':password' => $_POST['password'],
    ':location' => $_POST['location'],
    ':role' => $_POST['role'],
    ':salary' => $_POST['salary']
  ]
);

// Get the last inserted Employee_ID
$lastEmployeeID = $db->lastInsertId();

// Now, insert data into the education table using the same Employee_ID
$createEdu=$db->query("INSERT INTO education (Employee_ID, Education_1, College_1, CGPA_1, Education_2, College_2, CGPA_2)
  VALUES (:employee_id, :education_1, :college_1, :cgpa_1, :education_2, :college_2, :cgpa_2)",
  [
    ':employee_id' => $lastEmployeeID,
    ':education_1' => $_POST['Education_1'],
    ':college_1' => $_POST['College_1'],
    ':cgpa_1' => $_POST['CGPA_1'],
    ':education_2' => $_POST['Education_2'],
    ':college_2' => $_POST['College_2'],
    ':cgpa_2' => $_POST['CGPA_2']
  ]
);

// Similarly, insert data into the familydetails table using the same Employee_ID
$createFam=$db->query("INSERT INTO familydetails (Employee_ID, Father_Name, Mother_Name, Siblings_Names)
  VALUES (:employee_id, :father_name, :mother_name, :siblings_names)",
  [
    ':employee_id' => $lastEmployeeID,
    ':father_name' => $_POST['Father_Name'],
    ':mother_name' => $_POST['Mother_Name'],
    ':siblings_names' => $_POST['Siblings_Names']
  ]
);

// And finally, insert data into the experience table using the same Employee_ID
$createExp=$db->query("INSERT INTO experience (Employee_ID, Company_1, YearOfExperience_1, Company_2, YearOfExperience_2)
  VALUES (:employee_id, :company_1, :year1, :company_2, :year2)",
  [
    ':employee_id' => $lastEmployeeID,
    ':company_1' => $_POST['Company_1'],
    ':year1' => $_POST['YearOfExperience_1'],
    ':company_2' => $_POST['Company_2'],
    ':year2' => $_POST['YearOfExperience_2']
  ]
);

if ($createEmp && $createEdu && $createFam && $createExp) {
            header("Location: /?createstatus=success");
            exit;
        } else {
            header("Location: /?createstatus=error");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

?>