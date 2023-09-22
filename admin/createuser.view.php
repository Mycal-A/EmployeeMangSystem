<?php

require "partials/nav.php";

?>

<main>
  </div>
  <br>
  <a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary">Go Back...</a>
    <H3 class="text-center">Employee Details</H1>
<div class="container">
<form class="row g-3" action="createUser" method="post">
    <input type="hidden" name="id" value="<?= isset($emprow['Employee_ID']) ? $emprow['Employee_ID'] : '' ?>">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" placeholder="Enter Name">
  </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" placeholder=" Enter Email">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" placeholder=" Enter Password">
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Location</label>
    <input type="text" name="location" class="form-control" placeholder="Enter Location">
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Role</label>
    <input type="text" name="role" class="form-control" placeholder="Enter Role">
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Salary</label>
    <input type="text" name="salary" class="form-control" placeholder="Enter Salary">
  </div>
</div>
<hr>

<h3 class="text-center">Education</h3><br>
<div class="container row g-3 mx-auto">
    <div class="col-md-4">
    <label for="inputAddress" class="form-label">Education 1</label>
    <input type="text" name="Education_1"  class="form-control" placeholder="Enter Education 1">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">College 1</label>
    <input type="text" name="College_1" class="form-control" placeholder="Enter College Name">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">CGPA</label>
    <input type="text" name="CGPA_1" class="form-control"  placeholder="Enter CGPA">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">Education 2</label>
    <input type="text" name="Education_2"  class="form-control"  placeholder="Enter Education 1">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">College 2</label>
    <input type="text" name="College_2" class="form-control" placeholder="Enter College Name">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">CGPA</label>
    <input type="text" name="CGPA_2" class="form-control" placeholder="Enter CGPA">
  </div>
</div>

<hr>
<h3 class="text-center">Family Details</h3><br>
<div class="container row g-3 mx-auto">
    <div class="col-md-4">
    <label for="inputAddress" class="form-label">Father Name</label>
    <input type="text" name="Father_Name" class="form-control" placeholder="Enter Father Name">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">Mother Name</label>
    <input type="text" name="Mother_Name" class="form-control" placeholder="Enter Mother Name">
  </div>
  <div class="col-md-4">
    <label for="inputAddress" class="form-label">Siblings Names</label>
    <input type="text" name="Siblings_Names" class="form-control" placeholder="Enter Siblings names">
  </div>
</div>

<hr>
<h3 class="text-center">Experience</h3><br>
<div class="container row g-3 mx-auto">
    <div class="col-md-6">
    <label for="inputAddress" class="form-label">Company Name</label>
    <input type="text" name="Company_1" class="form-control" placeholder="Enter Company Name">
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Year OF Experience</label>
    <input type="text" name="YearOfExperience_1" class="form-control" placeholder="Enter Year OF Experience">
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Comapany 2</label>
    <input type="text" name="Company_2" class="form-control" placeholder="Enter Comapany 2">
  </div>
  <div class="col-md-6">
    <label for="inputAddress" class="form-label">Year Of Experience</label>
    <input type="text" name="YearOfExperience_2" class="form-control" placeholder="Enter Year Of Experience">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>

    </form>
</div>
</main>

<?= require "partials/footer.php" ?>