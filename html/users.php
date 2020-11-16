<?php
require 'common.php';

//Grab all the users from our database
$users = $database->select("users", ['id','name','credit','rfid_uid']);

?>

    <nav class="navbar navbar-dark bg-dark">
    <?php   echo "<a class='navbar-brand' href='.'>$Title</a>";  ?>
        <ul class="nav nav-pills">
            <li class="nav-item">  <a href="attendance.php" class="nav-link">Attendance Reports</a>  </li>
            <li class="nav-item">  <a href="machine.php" class="nav-link">Current Machine Activity</a>  </li>
            <li class="nav-item">  <a href="users.php" class="nav-link active">Current User Activity</a>  </li>
            <li class="nav-item">  <a href="admin.php" class="nav-link">Admin Settings</a>  </li>
        </ul>
    </nav>

    <div class="container">
        <div class="row">
            <h2>Users</h2>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">RFID UID</th>
                    <th scope="col">Credit Amount</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Loop through and list all the information of each user including their RFID UID
                foreach($users as $user) {
                    echo '<tr>';
                    echo '<td scope="row">' . $user['id'] . '</td>';
                    echo '<td>' . $user['name'] . '</td>';
                    echo '<td>' . $user['rfid_uid'] . '</td>';
                    echo '<td>' . $user['credit'] . '</td>';
                    echo '<td><input type="checkbox"></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
include "footer.php";
?>
</html>