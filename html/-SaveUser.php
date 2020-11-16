<?php 
require 'db.php';

    $Username = $_GET['Username'];
    $Image = $_GET['filename'];
    $mobile = $_GET['mobile_number'];
    $email = $_GET['email_address'];
    $h_address = $_GET['h_address'];
    $t_address = $_GET['t_address'];
    $day = $_GET['day'];
    $month = $_GET['month'];
    $year = $_GET['year'];
    $birthdate = $year.'-'.$month.'-'.$day;
    $credit = $_GET['amount'];

    $command = escapeshellcmd('sudo python3 /var/www/html/scripts/save_card.py');
    $output = shell_exec($command);

    $comm = escapeshellcmd('sudo mv uploads/'.$Image.' user_images/'.$Image);
    $out = shell_exec($comm);

$database->insert("users", ["name"=>$Username, "mobile"=>$mobile, "email"=>$email, "address"=>$h_address, "address2"=>$t_address, "birthdate"=>$birthdate, "credit"=>$credit, "rfid_uid"=>$output]);
header("location: https://smartlink");
?>
