<?php 
require 'db.php';
    $TtimeUP=0;
if (!empty($_POST['Ttime'])) { $TtimeUp = $_POST['Ttime']; };
    $command = escapeshellcmd('sudo python3 /var/www/html/scripts/update_card.py');
    $output = shell_exec($command);
    $ot=trim($output);
$cnfigs = $database->select("config",['THour1','THour2','THour3','THour4','THour5','THour6','THour7','THour8','THour9','NameType']);
foreach($cnfigs as $cnfig) {
    $THour1 = $cnfig['THour1'];
    $THour2 = $cnfig['THour2'];
    $THour3 = $cnfig['THour3'];
    $THour4 = $cnfig['THour4'];
    $THour5 = $cnfig['THour5'];
    $THour6 = $cnfig['THour6'];
    $THour7 = $cnfig['THour7'];
    $THour8 = $cnfig['THour8'];
    $THour9 = $cnfig['THour9'];
    $NameType = $cnfig['NameType'];
}
switch ($TtimeUp/60) {
    case 0:
	$sbtotal='0.00';	break;
    case 1:
	$sbtotal=$THour1;	break;
    case 2:
	$sbtotal=$THour2;	break;
    case 3:
	$sbtotal=$THour3;	break;
    case 4:
	$sbtotal=$THour4;	break;
    case 5:
	$sbtotal=$THour5;	break;
    case 6:
	$sbtotal=$THour6;	break;
    case 7:
	$sbtotal=$THour7;	break;
    case 8:
	$sbtotal=$THour8;	break;
    case 9:
	$sbtotal=$THour9;	break;
}
$Namedfile = file_get_contents("names.txt");
$json = json_decode($Namedfile, true);
//fclose($Namedfile);
if (!empty($NamedType)) {
    $length = count($json[$NamedType]);
    $i=rand(0,$length); $nam=$json[$NameType][$i];
  } else { $nam=""; };
echo "<tr><td>Timed Play :- <b>".($TtimeUp/60)."</b> hours</td><td class='product_price'>".$sbtotal."</td><td><input type='text' name='qty' class='product_qty' value='1'></td><td class='amount_sub total'>".$sbtotal."</td><td class='admin'><a href='#' class='delete'>x</a></td></tr>";
$cheks = $database->select("Tags", ['id'] , ['rfid_uid'==$ot]);

//echo $cheks->rowCount();

foreach($cheks as $chek) {
  $delid = $chek['id'];
    };
if (!empty($delid)) { $database->delete("Tags",["AND"=>["id"=>$delid]]);  };

$database->insert("Tags", ["TimeGot"=>$TtimeUp, "rfid_uid"=>$ot, "name"=>$nam]);
?>
