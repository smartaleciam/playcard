<?php 
//    print_r($_POST);

    $value = $_POST['value'];
    $command = escapeshellcmd('sudo python3 /var/www/html/scripts/backlight.py '.$value);
    $output = shell_exec($command);
    echo $output;
?>
