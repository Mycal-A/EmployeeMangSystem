<?php require "partials/nav.php" ?>

<?php
// Check if 'admin@gmail.com' is in the array
if (!in_array('admin@gmail.com', $_SESSION['user'])) {
    //dd($_SESSION['user']);
    header("Location: /");
    exit();
}
?>
<?php

    $userUpdateStatus=$_GET['updateStatus'] ?? '';
    if ($userUpdateStatus==='success') {
        echo '<p style="color: green;">Employee Updated successfully!</p>';
    }elseif($userUpdateStatus==='error'){
        echo '<p style="color: green;">Employee Creation Error!</p>';
    }
?>
<?php
        // Check if the createstatus parameter exists in the POST request
        if (isset($_GET['createstatus'])) {
            $createStatus = $_GET['createstatus'];
        
            if ($createStatus === 'success') {
                echo '<p style="color: green;">Employee Created successfully!</p>';
            } elseif ($createStatus === 'error') {
                echo '<p style="color: red;">Employee Creation Unsuccessful.</p>';
            }
        }
        
?>

<main>
    <div class="float-right">
        <a href="/createUserView" class="text-blue-500 underline btn btn-primary">Add User</a><br>
    </div>
    <table class="table table-bordered table table-hover">
        <tr class="table-dark">
            <td> Employee ID </td>
            <td> Name </td>
            <td> Email </td>
            <td> Password </td>
            <td> Location </td>
            <td> Salary </td>
            <td> Role </td>
            <td> View Details </td>
            <!-- <td> Edit </td> -->
            <td> Delete </td>
            <td> Access </td>
        </tr>
        <tr>
            <?php

                                while ($row = $result->find(PDO::FETCH_ASSOC)) {
                                    
        
                            ?>
            <td><?= $row['Employee_ID'] ?></td>
            <td><?= $row['Name'] ?></td>
            <td><?= $row['Email'] ?></td>
            <td><?= $row['Password'] ?></td>
            <td><?= $row['Location'] ?></td>
            <td><?= $row['Salary'] ?></td>
            <td><?= $row['Role'] ?></td>
            <td><a href="/adminViewEdit?id=<?= $row['Employee_ID'] ?>" class="btn btn-info">View and Edit</a></td>
            <!-- <td><a href="/update?id=<?= $row['Employee_ID'] ?>" class="btn btn-primary">Edit</a></td> -->
            <td><a href="/delete?id=<?= $row['Employee_ID'] ?>" class="btn btn-danger">Delete</a></td>
            <td>
                <?php if ($row['Access']==1) {
                                        echo '<a href="/access?id='.$row['Employee_ID'].'&status=0" class="btn btn-success">Enabled</a>';}
                                        else {
                                        echo '<a href="/access?id='.$row['Employee_ID'].'& status=1" class="btn btn-secondary">Disabled</a>';
                                    }
                                
                ?>

            </td>
        </tr>
        <?php
                                }
                            ?>

        </tr>
    </table>
    <?php
                                // Check the status parameter in the URL
                                $status = $_GET['status'] ?? '';

                                // Display a success or error message based on the status
                                if ($status === 'success') {
                                    echo '<p style="color: green;">Record deleted successfully!</p>';
                                } elseif ($status === 'error') {
                                    echo '<p style="color: red;">Error deleting the record.</p>';
                                }
                                ?>


    <!-- <a href="/education" class="text-blue-500 underline btn btn-outline-primary">Education-></a> -->

</main>


<?php require "partials/footer.php" ?>