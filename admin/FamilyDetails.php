<?php

require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

$result=$db->query("select * from familyDetails");
?>

<?php require "partials/nav.php" ?>

<br>
<br>
<main>
<table class="table table-bordered table table-hover">
                            <tr class="table-dark">
                                <td> Employee ID </td>
                                <td> Father Name </td>
                                <td> Mother Name </td>
                                <td> Siblings Names </td>
                            </tr>
                            <tr>
                            <?php

                                while ($row = $result->find(PDO::FETCH_ASSOC)) {
        
                            ?>
                                <td><?= $row['Employee_ID'] ?></td>
                                <td><?= $row['Father_Name'] ?></td>
                                <td><?= $row['Mother_Name'] ?></td>
                                <td><?= $row['Siblings_Names'] ?></td>


                            </tr>
                            <?php
                                }
                            ?>

                            </tr>
                            </table>

                            <a href="/education" class="text-blue-500 underline btn btn-outline-primary"><---Education</a> 
                            <a href="/experience" class="text-blue-500 underline btn btn-outline-primary">Experience---></a>

</main>


<?php require "partials/footer.php" ?>

