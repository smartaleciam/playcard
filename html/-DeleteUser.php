<?php 
require 'db.php';

    $id = $_POST['value'];

$database->delete("users",['id' => $id]);
echo "user ".$id." is Deleted";

header("location: https://smartlink");
?>
