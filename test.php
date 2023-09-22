<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


</head>
<body>
<td>
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="accessToggle<?= $row['Employee_ID'] ?>" <?= $row['Access'] ? 'checked' : '' ?>>
        <label class="custom-control-label" for="accessToggle<?= $row['Employee_ID'] ?>"></label>
    </div>
</td>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Add a change event handler to each toggle switch
        $(".custom-control-input").change(function () {
            var employeeID = $(this).attr('id').replace('accessToggle', '');

            // Send an AJAX request to update the "Access" field in the database
            $.ajax({
                type: "POST",
                url: "/update-access.php", // Replace with the actual URL for updating the "Access" field
                data: {
                    employeeID: employeeID,
                    access: this.checked ? '1' : '0' // Set the value to 1 (true) or 0 (false) based on the checkbox state
                },
                success: function (response) {
                    // Handle success, if needed
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Handle errors, if needed
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
    
</script>
</body>
</html>

