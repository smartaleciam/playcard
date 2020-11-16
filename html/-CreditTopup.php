<?php 
require 'db.php';
    $name=""; $new_credit=0;
    $topup = $_POST['credit'];
    $command = escapeshellcmd('sudo python3 /var/www/html/scripts/update_card.py');
    $output = shell_exec($command);
 $ot=trim($output);
$users = $database->select("users",["name","credit"],["rfid_uid"=>$ot]);
foreach($users as $user) {
    $name = $user['name'];
    $new_credit = $user['credit'] + $topup;
}
echo "<tr><td>Credit Topup :- ".$name."</td><td class='product_price'>".$topup."</td><td><input type='text' name='qty' class='product_qty' value='1'></td><td class='amount_sub total'>".$topup."</td><td class='admin'><a href='#' class='delete'>x</a></td></tr>";
$database->update("users", array("credit"=>$new_credit), array("rfid_uid"=>$output));
?>
