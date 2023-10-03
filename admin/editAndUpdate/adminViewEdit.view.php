<?php
session_start();
require "partials/nav.php";


// Check if 'admin@gmail.com' is in the array
if (!in_array('admin@gmail.com', $_SESSION['user'])) {
    //dd($_SESSION['user']);
    header("Location: /");
    exit();
}


require "functions.php";
require "Database.php";
require "config.php";
$config = require("config.php");
$db = new Database($config['database']);



$employeeID = $_GET['id'] ?? ''; // Replace with the specific Employee_ID you want to display

// Retrieve employee details for the specific Employee_ID
$empupdate = $db->query("SELECT * FROM employee WHERE Employee_ID = :id", [':id' => $employeeID]);
$emprow = $empupdate->get(PDO::FETCH_ASSOC);
$emprow = $emprow[0];

// Retrieve education details for the specific Employee_ID
$educationQuery = "SELECT * FROM empeducation WHERE Employee_ID = :employeeID";
$educationParams = [':employeeID' => $employeeID];
$educationDetails = $db->query($educationQuery, $educationParams)->get();

// Retrieve experience details for the specific Employee_ID
$experienceQuery = "SELECT * FROM empexperience WHERE Employee_ID = :employeeID";
$experienceParams = [':employeeID' => $employeeID];
$experienceDetails = $db->query($experienceQuery, $experienceParams)->get();

// Retrieve family details for the specific Employee_ID
$familyQuery = "SELECT * FROM empfamily WHERE Employee_ID = :employeeID";
$familyParams = [':employeeID' => $employeeID];
$familyDetails = $db->query($familyQuery, $familyParams)->get();


?>

<a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary">Go Back...</a>


<form class="row g-3" action="adminUserUpdate" method="post">
    <!-- Add a hidden input to store the editing state -->
    <input type="hidden" id="editing-state" name="editing" value="0">

    <!-- Modify the button to have two separate buttons for "Edit" and "Save" -->
    <br><br>
    <div class="col-md-12 ">
        <button type="button" id="edit-button" class="btn  btn-primary">Edit</button>
        <button type="submit" id="save-button" class="btn  btn-success" style="display: none;">Save</button>
    </div>


    <h1 class="text-center">Employee Details</h1>
    <div class="container row g-3 mx-auto">
        <input type="hidden" name="empid" value="<?= isset($emprow['Employee_ID']) ? $emprow['Employee_ID'] : '' ?>">
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= $emprow['Name'] ?>" placeholder="Enter Name"
                required>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $emprow['Email'] ?>"
                placeholder=" Enter Email" required>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value="<?= $emprow['Password'] ?>"
                placeholder=" Enter Password" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= $emprow['Location'] ?>"
                placeholder="Enter Location" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Role</label>
            <input type="text" name="role" class="form-control" value="<?= $emprow['Role'] ?>" placeholder="Enter Role"
                required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Salary</label>
            <input type="text" name="salary" class="form-control" value="<?= $emprow['Salary'] ?>"
                placeholder="Enter Salary" required>
        </div>
    </div>
    <hr>

    <h3 class="text-center">Education</h3>
    <div class="container row g-3 mx-auto" id="education-details-container">
        <?php foreach ($educationDetails as $index => $educationDetail): ?>
        <div class="education-details-section" data-index="<?= $index ?>">
            <div class="row g-3 mx-auto">
                    <input type="hidden" name="education[<?= $index ?>][education_id]" class="form-control"
                    value="<?= $educationDetail['education_id'] ?>" placeholder="Enter Education ID">
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Course</label>
                    <input type="text" name="education[<?= $index ?>][name]" class="form-control"
                        value="<?= $educationDetail['Course'] ?>" placeholder="Enter Education" required>
                </div>
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Institution</label>
                    <input type="text" name="education[<?= $index ?>][institution]" class="form-control"
                        value="<?= $educationDetail['Institution'] ?>" placeholder="Enter Institute Name" required>
                </div>
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">CGPA</label>
                    <input type="text" name="education[<?= $index ?>][cgpa]" class="form-control"
                        value="<?= $educationDetail['CGPA'] ?>" placeholder="Enter CGPA" required>
                </div>
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Graduation Year</label>
                    <input type="text" name="education[<?= $index ?>][gradyear]" class="form-control"
                        value="<?= $educationDetail['Graduation_Year'] ?>" placeholder="Enter Graduation Year" required>
                </div>
            </div>
            <a href="/adminDeleteRecord?educationid=<?= $educationDetail['education_id'] ?>"
                class="btn btn-danger remove-education-details">Delete</a>
            <!-- <button type="button" class="btn btn-sm btn-danger remove-education-details">Remove</button> -->
        </div>
        <?php endforeach; ?>
    </div>
    <div class=" col-md-12 text-center">
        <button type="button" id="add-education-details" class="btn btn-sm btn-success">Add Education</button>
    </div>
    <hr>

    <h3 class="text-center">Family Details</h3>
    <div class="container row g-3 mx-auto" id="family-details-container">
        <?php foreach ($familyDetails as $index => $familyDetail): ?>
        <div class="family-details-section" data-index="<?= $index ?>">
            <div class="row g-3 mx-auto">
            <input type="hidden" name="family[<?= $index ?>][family_id]" class="form-control" value="<?= $familyDetail['family_id'] ?>" placeholder="Enter Family ID">
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Name</label>
                    <input type="text" name="family[<?= $index ?>][name]" class="form-control"
                        value="<?= $familyDetail['Name'] ?>" placeholder="Enter Name" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Relationship</label>
                    <input type="text" name="family[<?= $index ?>][relationship]" class="form-control"
                        value="<?= $familyDetail['Relationship'] ?>" placeholder="Enter Relationship" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">DOB</label>
                    <input type="text" name="family[<?= $index ?>][dob]" class="form-control"
                        value="<?= $familyDetail['DOB'] ?>" placeholder="YYYY-MM-DD" required>
                </div>
            </div>
            <div>
                <a href="/adminDeleteRecord?familyid=<?= $familyDetail['family_id'] ?>" class="btn btn-danger remove-family-details ">Delete</a>
            </div>
            <!-- <button type="button" class="btn btn-sm btn-danger remove-family-details ">Remove</button> -->
        </div>
        <?php endforeach; ?>
    </div>
    <div class=" col-md-12 text-center">
        <button type="button" id="add-family-details" class="btn btn-sm btn-success">Add Member</button>
    </div>

    <hr>

    <h3 class="text-center">Experience</h3>
    <div class="container row g-3 mx-auto" id="experience-details-container">
        <?php foreach ($experienceDetails as $index => $experienceDetail): ?>
        <div class="experience-details-section" data-index="<?= $index ?>">
            <div class="row g-3 mx-auto">
                <input type="hidden" name="company[<?= $index ?>][experience_id]" class="form-control"
                    value="<?= $experienceDetail['experience_id'] ?>" placeholder="Enter Education ID">
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Company Name</label>
                    <input type="text" name="company[<?= $index ?>][name]" class="form-control"
                        value="<?= $experienceDetail['Company'] ?>" placeholder="Enter Company Name" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Role</label>
                    <input type="text" name="company[<?= $index ?>][role]" class="form-control"
                        value="<?= $experienceDetail['Role'] ?>" placeholder="Enter Role" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Year Of Experience</label>
                    <input type="text" name="company[<?= $index ?>][year]" class="form-control"
                        value="<?= $experienceDetail['YearOfExperience'] ?>" placeholder="Enter Year Of Experience" required>
                </div>
            </div>
            <a href="/adminDeleteRecord?experienceid=<?= $experienceDetail['experience_id'] ?>"
                class="btn btn-danger remove-experience-details">Delete</a>
            <!-- <button type="button" class="btn btn-sm btn-danger remove-experience-details">Remove</button> -->
         
        </div>
        <?php endforeach; ?>
    </div>
    <div class=" col-md-12 text-center">
        <button type="button" id="add-experience-details" class="btn btn-sm btn-success">Add Experience</button>
    </div>

    <!-- <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary">Save</button></div> -->

</form>

<script>
    var educationCounter = <?= count($educationDetails) ?> ; // Initialize education counter

    function addEducationSection() {
        educationCounter++;
        var $section = $(".education-details-section:first").clone();

        // Remove the 'education_id' from the delete link
        $section.find(".remove-education-details").attr("href", "");

        $section.find("input").val("").each(function () {
            var currentName = $(this).attr("name");
            $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + educationCounter + "]"));
        });

        $section.find(".remove-education-details").show(); // Show the remove button
        $("#education-details-container").append($section);
    }

    $("#add-education-details").click(function () {
        addEducationSection();
    });

    // Remove Education Details Section
    $(document).on("click", ".remove-education-details", function () {
        if ($(".education-details-section").length > 1) {
            var container = $(this).closest(".education-details-section");
            container.remove();
            updateEducationSectionIndexes(); // Update the indexes after removal
        }
    });

    // Function to update the indexes of education sections
    function updateEducationSectionIndexes() {
        $(".education-details-section").each(function (index) {
            $(this).attr("data-index", index);
            $(this).find("input").each(function () {
                var currentName = $(this).attr("name");
                $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + index + "]"));
            });
        });
    }

    //Family

    var familyCounter = <?= count($familyDetails) ?> ; // Initialize family counter

    function addFamilySection() {
        familyCounter++;
        var $section = $(".family-details-section:first").clone();

        // Remove the 'family_id' from the delete link
        $section.find(".remove-family-details").attr("href", " ");

        $section.find("input").val("").each(function () {
            var currentName = $(this).attr("name");
            $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + familyCounter + "]"));
        });

        $section.find(".remove-family-details").show(); // Show the remove button
        $("#family-details-container").append($section);
    }

    $("#add-family-details").click(function () {
        addFamilySection();
    });

    // Remove Family Details Section
    $(document).on("click", ".remove-family-details", function () {
        if ($(".family-details-section").length > 1) {
            var container = $(this).closest(".family-details-section");
            container.remove();
            updateFamilySectionIndexes(); // Update the indexes after removal
        }
    });

    // Function to update the indexes of family sections
    function updateFamilySectionIndexes() {
        $(".family-details-section").each(function (index) {
            $(this).attr("data-index", index);
            $(this).find("input").each(function () {
                var currentName = $(this).attr("name");
                $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + index + "]"));
            });
        });
    }


    //Experience
    var experienceCounter = <?= count($experienceDetails) ?> ; // Initialize experience counter

    function addExperienceSection() {
        experienceCounter++;
        var $section = $(".experience-details-section:first").clone();

        // Remove the 'experience_id' from the delete link
        $section.find(".remove-experience-details").attr("href", "");

        $section.find("input").val("").each(function () {
            var currentName = $(this).attr("name");
            $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + experienceCounter + "]"));
        });

        $section.find(".remove-experience-details").show(); // Show the remove button
        $("#experience-details-container").append($section);
    }

    $("#add-experience-details").click(function () {
        addExperienceSection();
    });

    // Remove Experience Details Section
    $(document).on("click", ".remove-experience-details", function () {
        if ($(".experience-details-section").length > 1) {
            var container = $(this).closest(".experience-details-section");
            container.remove();
            updateExperienceSectionIndexes(); // Update the indexes after removal
        }
    });

    // Function to update the indexes of experience sections
    function updateExperienceSectionIndexes() {
        $(".experience-details-section").each(function (index) {
            $(this).attr("data-index", index);
            $(this).find("input").each(function () {
                var currentName = $(this).attr("name");
                $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + index + "]"));
            });
        });
    }

    // Function to enable editing mode
function enableEditing() {
    $("input").prop("disabled", false);
    $("#edit-button").hide();
    $("#save-button").show();
    $("#editing-state").val("1");
}

// Function to disable editing mode
function disableEditing() {
    $("input").prop("disabled", true);
    $("#edit-button").show();
    $("#save-button").hide();
    $("#editing-state").val("0");
}

// Toggle Edit/Save mode when the "Edit" button is clicked
$("#edit-button").click(function () {
    enableEditing();
});

// Initially disable form fields and show the "Edit" button
disableEditing();


   

</script>


<?= require "partials/footer.php" ?>