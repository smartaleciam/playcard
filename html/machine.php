<?php
require 'common.php';

//Grab all the users from our database
$machines = $database->select("machine", ['id','machine_mac','machine_name','machine_value']);

?>
<body>
    <nav class="navbar navbar-dark bg-dark">
    <?php   echo "<a class='navbar-brand' href='.'>$Title</a>"; ?>
        <ul class="nav nav-pills">
            <li class="nav-item"> <a href="attendance.php" class="nav-link">Attendance Reports</a> </li>
            <li class="nav-item"> <a href="machine.php" class="nav-link active">Current Machine Activity</a> </li>
            <li class="nav-item"> <a href="users.php" class="nav-link">Current User Activity</a> </li>
            <li class="nav-item"> <a href="admin.php" class="nav-link">Admin Settings</a> </li>
        </ul>
    </nav>

    <div class="container">
        <div class="row">
            <h2>Machines</h2>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Machine Name</th>
                    <th scope="col">Mac Address</th>
		    <th scope="col">Online polling</th>
		    <th scope="col">Activity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //Loop through and list all the information of each user including their RFID UID
                foreach($machines as $machine) {
                    echo '<tr>';
                    echo '<td scope="row">' . $machine['machine_name'] . '</td>';
                    echo '<td>' . $machine['machine_mac'] . '</td>';
                    echo '<td>-???-line-</td>';
		    echo '<td>? Days ago</td>';
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