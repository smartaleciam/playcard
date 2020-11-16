<?php
  require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
    <!--	<link rel="stylesheet" href="css/jqbtk.min.css">  -->
    <!--	<link rel="stylesheet" href="css/calendar.css">  -->
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/webcam.min.js"></script>
<script src="js/countdown.js"></script>
    <!--	<script src="js/jqbtk.min.js"></script> --> <!-- load onscreen keyboard -->
    <!--	<script src="js/calendar.js"></script> --> <!-- load calendar module -->

<style>
body {
  background-image: url('/images/background.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: 100% 100%;
  background-position: center;
}
</style>

<?php

$users = $database->select("users",['id','name','image','mobile','email','address','address2','birthdate','credit','rfid_uid']);
$machines = $database->select("machine",['id','machine_mac','machine_name','machine_value','created']);
$settings = $database->select("config",['id','SiteTitle','GamePlay','BirthdayBonus','BackPic','TimeFormat','T_GST','GST','T_Bonus','Bonus','BAmount','WheelC1','WheelC2','WheelC3','WheelC4','LedBright','OTAUpdate','THour1','THour2','THour3','THour4','THour5','THour6','THour7','THour8','THour9','NameType']);
foreach($settings as $setting){
    $Title = $setting['SiteTitle'];
    $GroupPlayHours = $setting['GamePlay'];
    $BBCredit = $setting['BirthdayBonus'];
    $BgImage = $setting['BackPic'];
    $TF = $setting['TimeFormat'];
    $T_GST = $setting['T_GST'];
    $GST = $setting['GST'];
    $T_Bonus = $setting['T_Bonus'];
    $Bonus = $setting['Bonus'];
    $BAmount = $setting['BAmount'];
    $WheelC1 = $setting['WheelC1'];
    $WheelC2 = $setting['WheelC2'];
    $WheelC3 = $setting['WheelC3'];
    $WheelC4 = $setting['WheelC4'];
    $Brightness = $setting['LedBright'];
    $OTA_File = $setting['OTAUpdate'];
    $THour1 = $setting['THour1'];
    $THour2 = $setting['THour2'];
    $THour3 = $setting['THour3'];
    $THour4 = $setting['THour4'];
    $THour5 = $setting['THour5'];
    $THour6 = $setting['THour6'];
    $THour7 = $setting['THour7'];
    $THour8 = $setting['THour8'];
    $THour9 = $setting['THour9'];
    $NameType = $setting['NameType'];  // title setting for NameTypes
};
$NamedFile = file_get_contents("names.txt");  // load random names file
$json = json_decode($NamedFile, true);
$length = count($json[$NameType]);  // find number of names for selected settings type (enables random name selector)
//$i=rand(0,$length); print($json[$NameType][$i]);  //get a random name from the list 

//fclose($NamedFile);

//    for ($i=0; $i < $length; $i++) {  print( $i.$json[$NameType][$i]."<hr>" );  } // goes an prints out names for settings type
//$lngth = count($json);  // find number of nametypes (enables multi groupd random name selector)
//    foreach($json as $key=>$value){    print_r($key);  }  //finds the different names anprints them out

?>

<?php   echo "<title>$Title</title>"; ?>
</head>
<body>
<script src="js/custom.js"></script>

<?php
if (!empty($_POST)) {
    if ($_POST['Data_Source']=="Admin_Login") {
	$Admin_Uname = $_POST['Admin_Uname'];
	$Admin_Pass = $_POST['Admin_Pass'];
//    $uname = mysqli_real_escape_string($con,$_POST['Admin_Uname']);
//    $password = mysqli_real_escape_string($con,$_POST['Admin_Pass']);

//    if ($uname != "" && $password != ""){
//        $sql_query = "select count(*) as cntUser from users where username='".$uname."' and password='".$password."'";
//        $result = mysqli_query($con,$sql_query);
//        $row = mysqli_fetch_array($result);

//        $count = $row['cntUser'];
//        if($count > 0){
//            $_SESSION['uname'] = $uname;
////            header('Location: home.php');
//        ad_lock = 'inline';
//        document.getElementById('Admin_Image').src = "/images/un-locked.png";
//        document.getElementById('admin_menu').style.display = 'inline';
//        }else{
//            echo "Invalid username and password";
//        ad_lock = 'none'
//        document.getElementById('Admin_Image').src = "/images/locked.png";
//        document.getElementById('admin_menu').style.display = 'none';
//    session_destroy();
//        }
//     }
   };

   if ($_POST['Data_Source']=="SiteSettings") {
//	print_r($_POST);
	if (!empty($_POST['SiteTitle'])) { $AA=$_POST["SiteTitle"]; }else{ $AA=$Title; };
	if (!empty($_POST['GroupPlay'])) { $AB=$_POST["GroupPlay"]; }else{ $AB=$GroupPlayHours; };
	if (!empty($_POST['BBCredit'])) { $AC=$_POST["BBCredit"]; }else{ $AC=$BBCredit; };
	if (!empty($_POST['BgPicture'])) { $AD=$_POST["BgPicture"]; }else{ $AD=$BgImage; };
	if (!empty($_POST['TimDat'])) { $AE=$_POST["TimDat"]; }else{ $AE=$TF; };
	if (!empty($_POST['Tgst'])) { $AF=$_POST["Tgst"]; }else{ $AF=$T_GST; };
	if (!empty($_POST['gst'])) { $AG=$_POST["gst"]; }else{ $AG=$GST; };
	if (!empty($_POST['T_Bonus'])) { $AH=$_POST["T_Bonus"]; }else{ $AH=$T_Bonus; };
	if (!empty($_POST['Bonus'])) { $AI=$_POST["Bonus"]; }else{ $AI=$Bonus; };
	if (!empty($_POST['BAmount'])) { $AJ=$_POST["BAmount"]; }else{ $AJ=$BAmount; };
	if (!empty($_POST['Wheel1'])) { $AK=$_POST["Wheel1"]; }else{ $AK=$WheelC1; };
	if (!empty($_POST['Wheel2'])) { $AL=$_POST["Wheel2"]; }else{ $AL=$WheelC2; };
	if (!empty($_POST['Wheel3'])) { $AM=$_POST["Wheel3"]; }else{ $AM=$WheelC3; };
	if (!empty($_POST['Wheel4'])) { $AN=$_POST["Wheel4"]; }else{ $AN=$WheelC4; };
	if (!empty($_POST['Brightness'])) { $AO=$_POST["Brightness"]; }else{ $AO=$Brightness; };
	if (!empty($_FILES['filename']['name'])) {     // OTA Data File Update Detected
	    $uploadedFile ='';
	    $fileName = basename($_FILES['filename']['name']);
	    $targetFilePath = "update/".$fileName;
	    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
	    $allowTypes = array('bin','php');
	    if(in_array($fileType, $allowTypes)){    // start uploading file
		if(move_uploaded_file($_FILES['filename']['tmp_name'], $targetFilePath)){    $uploadedFile = $fileName;
		$database->update("config", ['OTAUpdate'=>$fileName]);
		} else {    echo '<script> alert("OTA Status :- File Upload Error"); </script>';  }
	    }else{   echo '<script> alert("OTA Status :- Not a .bin file type"); </script>';   }
	 };  // --- OTA UPDATE End
	if (!empty($_POST['THour1'])) { $THour1=$_POST["THour1"]; };
	if (!empty($_POST['THour2'])) { $THour2=$_POST["THour2"]; };
	if (!empty($_POST['THour3'])) { $THour3=$_POST["THour3"]; };
	if (!empty($_POST['THour4'])) { $THour4=$_POST["THour4"]; };
	if (!empty($_POST['THour5'])) { $THour5=$_POST["THour5"]; };
	if (!empty($_POST['THour6'])) { $THour6=$_POST["THour6"]; };
	if (!empty($_POST['THour7'])) { $THour7=$_POST["THour7"]; };
	if (!empty($_POST['THour8'])) { $THour8=$_POST["THour8"]; };
	if (!empty($_POST['THour9'])) { $THour9=$_POST["THour9"]; };
	if (!empty($_POST['NameType'])) { $NameType=$_POST["NameType"]; };

	$database->update("config", ['SiteTitle'=>$AA,'GamePlay'=>$AB,'BirthdayBonus'=>$AC,'BackPic'=>$AD,'TimeFormat'=>$AE,'T_GST'=>$AF,'GST'=>$AG,'T_Bonus'=>$AH,'Bonus'=>$AI,'BAmount'=>$AJ,'WheelC1'=>$AK,'WheelC2'=>$AL,'WheelC3'=>$AM,'WheelC4'=>$AN,'LedBright'=>$AO,'THour1'=>$THour1,'THour2'=>$THour2,'THour3'=>$THour3,'THour4'=>$THour4,'THour5'=>$THour5,'THour6'=>$THour6,'THour7'=>$THour7,'THour8'=>$THour8,'THour9'=>$THour9,'NameType'=>$NameType]);
	// ------ After Updating Config Settings, Then Reload them -----
	$settings = $database->select("config",['id','SiteTitle','GamePlay','BirthdayBonus','BackPic','TimeFormat','T_GST','GST','T_Bonus','Bonus','BAmount','WheelC1','WheelC2','WheelC3','WheelC4','LedBright']);
	foreach($settings as $setting){
            $Title = $setting['SiteTitle'];
	    $GroupPlayHours = $setting['GamePlay'];
	    $BBCredit = $setting['BirthdayBonus'];
	    $BgImage = $setting['BackPic'];
	    $TF = $setting['TimeFormat'];
	    $T_GST = $setting['T_GST'];
	    $GST = $setting['GST'];
	    $T_Bonus = $setting['T_Bonus'];
	    $Bonus = $setting['Bonus'];
	    $BAmount = $setting['BAmount'];
	    $WheelC1 = $setting['WheelC1'];
	    $WheelC2 = $setting['WheelC2'];
	    $WheelC3 = $setting['WheelC3'];
	    $WheelC4 = $setting['WheelC4'];
	    $Brightness = $setting['LedBright'];
	};
    };

    if ($_POST['Data_Source']=="AddMember") {
	$image = $_POST['filename'];
	$Username = $_POST['Username'];
	$mobile = $_POST['mobile_number'];
	$email = $_POST['email_address'];
	$h_address = $_POST['h_address'];
	$t_address = $_POST['t_address'];
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$birthdate = $year.'-'.$month.'-'.$day;
	$credit= $_POST['amount'];

	$command = escapeshellcmd('sudo python3 /var/www/html/scripts/save_card.py');
	$output = shell_exec($command);
	$database->insert("users", ['name'=>$Username, 'image'=>$image, 'mobile'=>$mobile, 'email'=>$email, 'address'=>$h_address, 'address2'=>$t_address, 'birthdate'=>$birthdate, 'credit'=>$credit, 'rfid_uid'=>$output]);

//var_dump($database->error());
	// ----- Submit Data to database then reload the database ------
	$users = $database->select("users",['id','name','image','mobile','email','address','address2','birthdate','credit','rfid_uid']);
//----   add membership cost to the account tab ---
    };

//    echo '<script> alert("Unknown Incomming Data"); </script>';
//echo "<pre>";
//    print_r($_POST);
//echo "</pre>";
};

?>
<div class="rfid">
  <div id="rfid-img"></div>
</div>

<?php
 $BgColours = array('bg-primary','bg-secondary','bg-success','bg-danger','bg-warning','bg-info','bg-light','bg-dark','bg-white');
$BgColours1 = array('Blue','Grey','Green','Red','Yellow','Crayon','Dusk','Black','White');

$WheelColour = array("Black","Yellow","Purple","Red","Green","Blue","White");
