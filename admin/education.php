<?php

require "functions.php";
$config = require("config.php");
$db = new Database($config['database']);

$result=$db->query("select * from education");
?>

<?php require "partials/nav.php" ?>

<br>
<br>
<main>
<table class="table table-bordered table table-hover">
                            <tr class="table-dark">
                                <td> Employee ID </td>
                                <td> Education 1 </td>
                                <td> College 1 </td>
                                <td> CGPA 1 </td>
                                <td> Education 2 </td>
                                <td> College 2 </td>
                                <td> CGPA 2 </td>
                            </tr>
                            <tr>
                            <?php

                                while ($row = $result->find(PDO::FETCH_ASSOC)) {
        
                            ?>
                                <td><?= $row['Employee_ID'] ?></td>
                                <td><?= $row['Education_1'] ?></td>
                                <td><?= $row['College_1'] ?></td>
                                <td><?= $row['CGPA_1'] ?></td>
                                <td><?= $row['Education_2'] ?></td>
                                <td><?= $row['College_2'] ?></td>
                                <td><?= $row['CGPA_2'] ?></td>

                            </tr>
                            <?php
                                }
                            ?>

                            </tr>
                            </table>

                            <a href="/adminHome" class="text-blue-500 underline btn btn-outline-primary"><---Go Back...</a>
                            <a href="/familyDetails" class="text-blue-500 underline btn btn-outline-primary">Family Details---></a>

</main>


<?php require "partials/footer.php" ?>

