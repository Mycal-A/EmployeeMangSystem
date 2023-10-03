<?php
require "partials/nav.php";
require "functions.php";
require "config.php";
$config = require("config.php");
$db = new Database($config['database']);

if(count($_POST)>0){
//Employee Details
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  $location = isset($_POST['location']) ? $_POST['location'] : '';
  $role = isset($_POST['role']) ? $_POST['role'] : '';
  $salary = isset($_POST['salary']) ? $_POST['salary'] : '';

  $db->query("UPDATE employee set Name=:name, Email=:email, Password=:password, 
  Location=:location, Role=:role, Salary=:salary 
  WHERE Employee_ID=:id", [':id' => $_GET['id'], ':name' => $name, ':email' => $email, ':password' => $password, ':location' => $location, ':role' => $role, ':salary' => $salary]);
// Education updation
  $education_1 = isset($_POST['Education_1']) ? $_POST['Education_1'] : '';
  $college_1 = isset($_POST['College_1']) ? $_POST['College_1'] : '';
  $cgpa_1 = isset($_POST['CGPA_1']) ? $_POST['CGPA_1'] : '';
  $education_2 = isset($_POST['Education_2']) ? $_POST['Education_2'] : '';
  $college_2 = isset($_POST['College_2']) ? $_POST['College_2'] : '';
  $cgpa_2 = isset($_POST['CGPA_2']) ? $_POST['CGPA_2'] : '';

  $db->query("UPDATE education set Education_1=:education_1, College_1=:college_1, CGPA_1=:cgpa_1,
  Education_2=:education_2, College_2=:college_2, CGPA_2=:cgpa_2 
  WHERE Employee_ID=:id", [':id' => $_GET['id'], ':education_1' => $education_1, ':college_1' => $college_1, ':cgpa_1' => $cgpa_1, ':education_2' => $education_2, ':college_2' => $college_2, ':cgpa_2' => $cgpa_2]);

//Family Details
  $db->query("UPDATE familydetails 
  SET Father_Name = :fatherName,
      Mother_Name = :motherName,
      Siblings_Names = :siblingsNames
  WHERE Employee_ID = :id",
  [
    ':fatherName' => $_POST['Father_Name'],
    ':motherName' => $_POST['Mother_Name'],
    ':siblingsNames' => $_POST['Siblings_Names'],
    ':id' => $_GET['id']
  ]
  );

//Experience
  $name=$db->query("UPDATE experience SET 
      Company_1 = :company1,
      YearOfExperience_1 = :year1,
      Company_2 = :company2,
      YearOfExperience_2 = :year2
      WHERE Employee_ID = :id",
      [
        ':company1' => $_POST['Company_1'],
        ':year1' => $_POST['YearOfExperience_1'],
        ':company2' => $_POST['Company_2'],
        ':year2' => $_POST['YearOfExperience_2'],
        ':id' => $_GET['id']
    ]
    );
    // dd($name);

  $message = "<p>Updated Successfully</P>";
}

$empupdate = $db->query("SELECT * FROM employee WHERE Employee_ID = :id", [':id' => $_GET['id']]);
$emprow = $empupdate->get(PDO::FETCH_ASSOC);
$emprow = $emprow[0];

$educupdate = $db->query("SELECT * FROM education WHERE Employee_ID = :id", [':id' => $_GET['id']]);
$edurow = $educupdate->get(PDO::FETCH_ASSOC);
$edurow = $edurow[0];
//dd($edurow);

$familyupdate = $db->query("SELECT * FROM familydetails WHERE Employee_ID = :id", [':id' => $_GET['id']]);
$famrow = $familyupdate->get(PDO::FETCH_ASSOC);
$famrow = $famrow[0];
// dd($famrow);

$expupdate = $db->query("SELECT * FROM experience WHERE Employee_ID = :id", [':id' => $_GET['id']]);
$exprow = $expupdate->get(PDO::FETCH_ASSOC);
$exprow =$exprow[0];
// dd($exprow);

?>

<main>
  <br>
  <a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary">Go Back...</a>
  <form class="row g-3" name="empupdate" method="post">
    <h class="text-center">Employee Details</h>
    <div class="container">
      <input type="hidden" name="id" value="<?= isset($emprow['Employee_ID']) ? $emprow['Employee_ID'] : '' ?>">
      <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="inputEmail4"
          value="<?= $emprow['Name'] ? $emprow['Name'] : '' ?>">
      </div>
      <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="inputEmail4"
          value="<?= $emprow['Email'] ? $emprow['Email'] : '' ?>">
      </div>
      <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="inputPassword4"
          value="<?= $emprow['Password'] ? $emprow['Password'] : '' ?>">
      </div>
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Location</label>
        <input type="text" name="location" class="form-control" id="inputAddress" placeholder="Address"
          value="<?= $emprow['Location'] ? $emprow['Location'] : '' ?>">
      </div>
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Role</label>
        <input type="text" name="role" class="form-control" id="inputAddress" placeholder="Enter Role"
          value="<?= $emprow['Role'] ? $emprow['Role'] : '' ?>">
      </div>
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Salary</label>
        <input type="text" name="salary" class="form-control" id="inputAddress" placeholder="Enter Salary"
          value="<?= $emprow['Salary'] ? $emprow['Salary'] : '' ?>">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Save</button>
        <div><?php if(isset($message)){echo $message;} ?></div>
      </div>
    </div>
    <hr>

    <h3 class="text-center">Education</h3><br>
    <div class="container row g-3 mx-auto">
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">Education 1</label>
        <input type="text" name="Education_1" value="<?= $edurow['Education_1'] ? $edurow['Education_1'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter Education 1">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">College 1</label>
        <input type="text" name="College_1" value="<?= $edurow['College_1'] ? $edurow['College_1'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter College Name">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">CGPA</label>
        <input type="text" name="CGPA_1" value="<?= $edurow['CGPA_1'] ? $edurow['CGPA_1'] : '' ?>" class="form-control"
          id="inputAddress" placeholder="Enter CGPA">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">Education 2</label>
        <input type="text" name="Education_2" value="<?= $edurow['Education_2'] ? $edurow['Education_2'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter Education 1">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">College 2</label>
        <input type="text" name="College_2" value="<?= $edurow['College_2'] ? $edurow['College_2'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter College Name">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">CGPA</label>
        <input type="text" name="CGPA_2" value="<?= $edurow['CGPA_2'] ? $edurow['CGPA_2'] : '' ?>" class="form-control"
          id="inputAddress" placeholder="Enter CGPA">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Save</button>
        <div><?php if(isset($message)){echo $message;} ?></div>
      </div>
    </div>
    <hr>

    <h3 class="text-center">Family Details</h3><br>
    <div class="container row g-3 mx-auto">
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">Father Name</label>
        <input type="text" name="Father_Name" value="<?= $famrow['Father_Name'] ? $famrow['Father_Name'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter Father Name">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">Mother Name</label>
        <input type="text" name="Mother_Name" value="<?= $famrow['Mother_Name'] ? $famrow['Mother_Name'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter Mother Name">
      </div>
      <div class="col-md-4">
        <label for="inputAddress" class="form-label">Siblings Names</label>
        <input type="text" name="Siblings_Names"
          value="<?= $famrow['Siblings_Names'] ? $famrow['Siblings_Names'] : '' ?>" class="form-control"
          id="inputAddress" placeholder="Enter Siblings names">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Save</button>
        <div><?php if(isset($message)){echo $message;} ?></div>
      </div>
    </div>

    <hr>
    <h3 class="text-center">Experience</h3><br>
    <div class="container row g-3 mx-auto">
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Company Name</label>
        <input type="text" name="Company_1" value="<?= $exprow['Company_1'] ? $exprow['Company_1'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter Company Name">
      </div>
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Year OF Experience</label>
        <input type="text" name="YearOfExperience_1"
          value="<?= $exprow['YearOfExperience_1'] ? $exprow['YearOfExperience_1'] : '' ?>" class="form-control"
          id="inputAddress" placeholder="Enter Year OF Experience">
      </div>
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Comapany 2</label>
        <input type="text" name="Company_2" value="<?= $exprow['Company_2'] ? $exprow['Company_2'] : '' ?>"
          class="form-control" id="inputAddress" placeholder="Enter Comapany 2">
      </div>
      <div class="col-md-6">
        <label for="inputAddress" class="form-label">Year Of Experience</label>
        <input type="text" name="YearOfExperience_2"
          value="<?= $exprow['YearOfExperience_2'] ? $exprow['YearOfExperience_2'] : '' ?>" class="form-control"
          id="inputAddress" placeholder="Enter Year Of Experience">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Save</button>
        <div><?php if(isset($message)){echo $message;} ?></div>
      </div>

  </form>
</main>

<?= require "partials/footer.php" ?>