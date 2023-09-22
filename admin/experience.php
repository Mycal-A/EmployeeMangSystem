<?php

require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

$result=$db->query("select * from experience");
?>

<?php require "partials/nav.php" ?>

<br>
<br>
<main>

<table class="table table-bordered table table-hover">
                            <tr class="table-dark">
                                <td> Employee ID </td>
                                <td> Company 1 </td>
                                <td> Year OF Experience 1 </td>
                                <td> Company 2 </td>
                                <td> Year OF Experience 2 </td>
                            </tr>
                            <tr>
                            <?php

                                while ($row = $result->find(PDO::FETCH_ASSOC)) {
        
                            ?>
                                <td><?= $row['Employee_ID'] ?></td>
                                <td><?= $row['Company_1'] ?></td>
                                <td><?= $row['YearOfExperience_1'] ?></td>
                                <td><?= $row['Company_2'] ?></td>
                                <td><?= $row['YearOfExperience_2'] ?></td>


                            </tr>
                            <?php
                                }
                            ?>

                            </tr>
                            </table>

                            <a href="/familyDetails" class="text-blue-500 underline btn btn-outline-primary">Go Back...</a>
                            <a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary">Home</a>

</main>


<?php require "partials/footer.php" ?>

