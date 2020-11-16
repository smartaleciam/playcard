<?php
system("gpio mode 23 out");
system("gpio write 23 1");
delay 500;
system("gpio write 23 0");
?>
