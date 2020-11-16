<?php 
require 'db.php';

    $command = escapeshellcmd('sudo python3 /var/www/html/scripts/update_card.py');
    $output = shell_exec($command);

$users = $database->select("users", ["name", "mobile", "email", "credit", "rfid_uid"],["rfid_uid"=>"(hex($output)[2:10])"]);
foreach($users as $user){  $layuser = "<table class='table' border='1'><thead class='thead-dark'><tr><th>Name</th><th>Mobile</th><th>Email</th><th>Credit</th></tr></thead></tbody><tr><td>".$user['name']."</td><td>".$user['mobile']."</td><td>".$user['email']."</td><td>$".$user["credit"]."</td></tr></tbody></table>";  }

echo $layuser;
?>
