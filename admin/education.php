<?php
session_start();
require "functions.php";

$config = require("config.php");
$db = new Database($config['database']);

$result=$db->query("select * from empeducation");
?>

<?php require "partials/nav.php" ?>

<br>
<br>
<main>
    <table class="table table-bordered table table-hover">
        <tr class="table-dark">
            <td> Employee ID </td>
            <td> Education ID </td>
            <td> Course </td>
            <td> College </td>
            <td> CGPA </td>
            <td> Graduation Year </td>

        </tr>
        <tr>
            <?php

                while ($row = $result->find(PDO::FETCH_ASSOC)) {
        
            ?>
            <td><?= $row['Employee_ID'] ?></td>
            <td><?= $row['education_id'] ?></td>
            <td><?= $row['Course'] ?></td>
            <td><?= $row['Institution'] ?></td>
            <td><?= $row['CGPA'] ?></td>
            <td><?= $row['Graduation_Year'] ?></td>

        </tr>
        <?php
                 }
                            ?>

        </tr>
    </table>

    <a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary">
        <---Go Back...</a> <a href="/familyDetails" class="text-blue-500 underline btn btn-outline-primary">Family
            Details--->
    </a>

</main>


<?php require "partials/footer.php" ?>