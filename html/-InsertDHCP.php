<?php 
require 'db.php';
    $mac = $_POST['mac_address'];
    $name = $_POST['machine_name'];
    $value = $_POST['machine_value'];
$database->insert("machine", ["machine_mac"=>$mac, "machine_name"=>$name, "machine_value"=>$value]);
?>
