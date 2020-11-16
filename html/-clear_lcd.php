<?php
    $command = escapeshellcmd('sudo python3 /var/www/html/scripts/clear_lcd.py &');
    $output = shell_exec($command);
    echo $output;
header("location: http://192.168.1.147");
?>