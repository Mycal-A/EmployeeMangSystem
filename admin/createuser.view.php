<?php
session_start();
// Check if 'admin@gmail.com' is in the array
if (!in_array('admin@gmail.com', $_SESSION['user'])) {
    //dd($_SESSION['user']);
    header("Location: /");
    exit();
}
require "partials/nav.php";
$emailExists = isset($_GET['emailExists']) && $_GET['emailExists'] === 'true';

?>

<a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary">Go Back...</a>
<?php if ($emailExists): ?>
<!-- Display the warning message if email already exists -->
<div class="alert alert-danger" role="alert">
    Email already exists! Please use a different email.
</div>
<?php endif; ?>

<form class="row g-3" action="/createUser" method="post">
    <h1 class="text-center">Employee Details</h1>
    <div class="container row g-3 mx-auto">
        <input type="hidden" name="id" value="<?= isset($emprow['Employee_ID']) ? $emprow['Employee_ID'] : '' ?>">
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
        </div>
        <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder=" Enter Email" required>
        </div>
        <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder=" Enter Password" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" placeholder="Enter Location" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Role</label>
            <input type="text" name="role" class="form-control" placeholder="Enter Role" required>
        </div>
        <div class="col-md-6">
            <label for="inputAddress" class="form-label">Salary</label>
            <input type="text" name="salary" class="form-control" placeholder="Enter Salary" required>
        </div>
    </div>
    <hr>

    <h3 class="text-center">Education</h3>
    <div class="container row g-3 mx-auto" id="education-details-container">
        <div class="education-details-section">
            <div class="row g-3 mx-auto">
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Course</label>
                    <input type="text" name="education[0][name]" class="form-control" placeholder="Enter Education"  required>
                </div>
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Institution</label>
                    <input type="text" name="education[0][institution]" class="form-control"
                        placeholder="Enter Institute Name"  required>
                </div>
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">CGPA</label>
                    <input type="text" name="education[0][cgpa]" class="form-control" placeholder="Enter CGPA"  required>
                </div>
                <div class="col-md-3">
                    <label for="inputAddress" class="form-label">Graduation Year</label>
                    <input type="text" name="education[0][gradyear]" class="form-control"
                        placeholder="Enter Graduation Year"  required>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger remove-education-details">Remove</button>
        </div>
    </div>
    <button type="button" id="add-education-details" class="btn btn-sm btn-success">Add Education</button>

    <hr>

    <h3 class="text-center">Family Details</h3>
    <div class="container mx-auto text-center" id="family-details-container">
        <!-- Initial Family Details Section -->
        <div class="family-details-section">
            <div class="row g-3 mx-auto">
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Name</label>
                    <input type="text" name="family[0][name]" class="form-control" placeholder="Enter Name"  required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Relationship</label>
                    <input type="text" name="family[0][relationship]" class="form-control"
                        placeholder="Enter Relationship"  required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">DOB</label>
                    <input type="text" name="family[0][dob]" class="form-control" placeholder="YYYY-MM-DD"  required>
                </div>
            </div>
            <!-- Only allow removal if there is more than one set -->
            <button type="button" class="btn btn-sm btn-danger remove-family-details">Remove</button>
        </div>
    </div>
    <button type="button" id="add-family-details" class="btn btn-sm btn-success">Add Memeber</button>

    <hr>

    <h3 class="text-center">Experience</h3>
    <div class="container row g-3 mx-auto" id="experience-details-container">
        <!-- Initial Experience Details Section -->
        <div class="experience-details-section">
            <div class="row g-3 mx-auto">
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Company Name</label>
                    <input type="text" name="company[0][name]" class="form-control" placeholder="Enter Company Name" required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Role</label>
                    <input type="text" name="company[0][role]" class="form-control" placeholder="Enter Role"  required>
                </div>
                <div class="col-md-4">
                    <label for="inputAddress" class="form-label">Year Of Experience</label>
                    <input type="text" name="company[0][year]" class="form-control"
                        placeholder="Enter Year Of Experience"  required>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-danger remove-experience-details">Remove</button>
        </div>
    </div>
    <button type="button" id="add-experience-details" class="btn btn-sm btn-success">Add Experience</button>
    <div class="col-12">
        <input type="submit" name="submit" class="btn btn-primary" value="Save">
    </div>
</form>

<script>
    // Initialize counters
    var experienceCounter = 0;
    var educationCounter = 0;
    var familyCounter = 0;

    // Function to clone and append a new section
    function addSection(container, sectionClass, counter, namePrefix) {
        var $section = $(sectionClass + ":first").clone();
        counter++;
        $section.find("input").val("").each(function () {
            var currentName = $(this).attr("name");
            $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + counter + "]"));
        });
        container.append($section);
    }

    // Function to update the input names and counters
    function updateSectionNames(container, sectionClass) {
        container.find(sectionClass).each(function (index) {
            $(this).find("input").each(function () {
                var currentName = $(this).attr("name");
                $(this).attr("name", currentName.replace(/\[(\d+)\]/, "[" + index + "]"));
            });
        });
    }

    // Add Experience Details Section
    $("#add-experience-details").click(function () {
        addSection($("#experience-details-container"), ".experience-details-section", experienceCounter,
            "company");
    });

    // Remove Experience Details Section
    $(document).on("click", ".remove-experience-details", function () {
        if ($(".experience-details-section").length > 1) {
            $(this).closest(".experience-details-section").remove();
            experienceCounter--;
            updateSectionNames($("#experience-details-container"), ".experience-details-section");
        }
    });

    // Add Education Details Section
    $("#add-education-details").click(function () {
        addSection($("#education-details-container"), ".education-details-section", educationCounter,
            "education");
    });

    // Remove Education Details Section
    $(document).on("click", ".remove-education-details", function () {
        if ($(".education-details-section").length > 1) {
            $(this).closest(".education-details-section").remove();
            educationCounter--;
            updateSectionNames($("#education-details-container"), ".education-details-section");
        }
    });

    // Add Family Details Section
    $("#add-family-details").click(function () {
        addSection($("#family-details-container"), ".family-details-section", familyCounter, "family");
    });

    // Remove Family Details Section
    $(document).on("click", ".remove-family-details", function () {
        if ($(".family-details-section").length > 1) {
            $(this).closest(".family-details-section").remove();
            familyCounter--;
            updateSectionNames($("#family-details-container"), ".family-details-section");
        }
    });
</script>
<?= require "partials/footer.php" ?>