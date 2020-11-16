<script>
function Admin_Buttons($val) {
    var x = document.getElementById($val).style.display;
    if (x === 'none') {  document.getElementById($val).style.display = 'inline';  } else { document.getElementsById($val).sytle.display = 'none';  }
};

function Credit_Check() {
  $.ajax({
    url: "-CreditCheck.php",
    success: function(result) { document.getElementById('CreditInfo').innerHTML=result; },
    beforeSend: function() { $(".loading").show(); },
    complete: function() { $(".loading").hide();  }
  });
};

function Delete_User(id) {
    alert("Are you sure?");
    $.ajax({
    url: "-DeleteUser.php",
    data: {value: id},
    type: "POST",
    success: function(result) { alert(result); $users = $database->select("users", ['id','filename','name','mobile','email','address2','birthdate','credit','rfid_uid']);  }
    beforeSend: function() { $(".loading").show;  },
    complete: function() { $(".loading").hide();  }
  });
};

function Scan_DHCP() {
    $.ajax({
    url: "-ScanDHCP.php",
    success: function(result) {document.getElementById('ViewDHCP').innerHTML = result; },
    beforeSend: function() { $(".loading").show();  document.getElementById('ViewDHCP').style.display = 'inline'; },
    complete: function() { $(".loading").hide(); }
  });
};

function Add_DHCP(mac) {
  $.ajax({
    url: "-InsertDHCP.php",
    data: {
      mac_address: mac,
      machine_name: document.getElementById('mac_add').elements.namedItem('machine_name').value,
      machine_value: document.getElementById('mac_add').elements.namedItem('machine_value').value
      },
    type: "POST",
    success: function(result) { alert("Added"); },
    complete: function() { document.getElementById('mac_add').submit(); }
  });
};

//function Find_DHCP(mac) {
// alert("Machine lit up");
//  $.ajax({
//    url: "-FindDHCP.php",
//    data: {  mac_address: mac  },
//    type: "POST",
//    success: function(result) { alert("Machine lit up"); },
//    complete: function() {  }
//  });
//};

</script>


<!--
//<script>
//$(document).ready(function() {
//$("input[name='SitebtnSubmit']").on("click", SetAdmin());
//};
//$(document).ready(function() { $('input[type="checkbox"]').click(function() {

//function SetAdmin() {
//alert("helloo");
//    $.ajax({
//    url: "-SaveSettings.php",
//    success: function(result) { alert(result); },
//    beforeSend: function() { $(".loading").show(); },
//    complete: function() { $(".loading").hide(); }
//    });
//};
//</script>
-->
    <div id="MachineStats" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'MachineStats\').style.display=\'none\'">Machine Stats</h4></div>';
	  foreach($machines as $machine) {
	    echo '<div class="navbar navbar-light" style="background-color: #e3f2fd;">';
	    echo '<a class="navbar-brand navbar-toggler toggler-example" data-toggle="collapse" data-target="#navbarSupportedContent'.$machine['id'].'">Name - '.$machine['machine_name'].'</a>';
	    echo '<button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent'.$machine['id'].'" aria-controls="navbarSupportedContent'.$machine['id'].'" aria-expanded="false" aria-label="Toggle navigation">';
	    echo '<span class="dark-blue-text">+</span></button>';
    	    echo '<div class="collapse navbar-collapse" id="navbarSupportedContent'.$machine['id'].'">';
	    echo '<ul class="navbar-nav mr-auto">';
    	    echo '<li class="nav-item" onchange="">Sys ID - <b>'. $machine['id'].'</b></li>';
    	    echo '<li class="nav-item">Name - <b>'. $machine['machine_name'].'</b></li>';
    	    echo '<li class="nav-item">Mac Address - <b>'. $machine['machine_mac'].'</b></li>';
    	    echo '<li class="nav-item">Machine Cost - <b>'. $machine['machine_value'].'</b></li>';
    	    echo '<li class="nav-item">Added - <b>'. $machine['created'].'</b></li>';
	    echo '<button class="nav-item" type="button" onclick="Delete_Machine('.$machine['id'].')"><font color="red">-Delete-Machine-</font></button>';
	    echo '</ui></div>';
	    echo '</div>';
        }
?>
    </div>

    <div id="EditMachines" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'EditMachines\').style.display=\'none\'">Edit Machines</h4></div>'; ?>
    </div>


    <div id="CalabrateMachines" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'CalabrateMachines\').style.display=\'none\'">Calabrate Machines</h4></div>'; ?>
    </div>

    <div id="MembershipEdit" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'MembershipEdit\').style.display=\'none\'">Edit Memberships</h4></div>'; ?>
    </div>


    <div id="BrowseMembers" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'BrowseMembers\').style.display=\'none\'">Browse Memberships</h4></div>'; ?>
    </div>

    <div id="MembershipCredits" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'MembershipCredits\').style.display=\'none\'">View Membership Credits</h4></div>'; ?>
    </div>

    <div id="PHPmyAdmin" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'PHPmyAdmin\').style.display=\'none\'">PHPmyAdmin</h4></div>'; ?>
    <iframe id="PhAdm" src="/" style="border:3px solid black; width:100%; height:600px; background-image:url('/images/loading.gif'); background-repeat:no-repeat; background-position:top center; "></iframe>
    </div>

    <div id="WIFIaccessPOINT" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick=\'getElementById(\"WIFIaccessPOINT\").style.display=\"none\"\'>Wifi Access Point</h4></div>'; ?>
    <iframe id="WifiAP" src="/" style="border:3px solid black; width:100%; height:600px; background-image:url('/images/loading.gif'); background-repeat:no-repeat; background-position:top center; "></iframe>
    </div>

<!-- Modal Popup - About Credits -->
<div class="modal" id="About" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<div class="modal-header bg-danger text-body" style="height: 65px;">
	    <h2 class="modal-title" id="exampleModalLabel">Credits</h2>
	    <button type="button" class="close" data-dismiss="modal"caria-label="Close">
	    <span aria-hidden="true">&times;</span>
	    </button>
	</div>
	<h4>Goes to the Great SmartAlec</h4>
	<a href="https://github.com/MrVamos/Countdown_timer" target="_blank">Countdown Timer Display Script</a>
	<a href="https://github.com/jhuckaby/webcamjs" target="_blank">Webcam Capture Script</a>
	<a href="http://hasseb.fi/bookingcalendar" target="_blank">Booking System Script</a>
    </div>
  </div>
</div>

    <div id="IncomeReports" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'IncomeReports\').style.display=\'none\'">View Income Reports</h4></div>'; ?>
        <table class="table table-striped">
        <tbody>
        <?php
            foreach($users as $user) {
            echo '<tr>';
            echo '<td scope="row">'.$user["id"].'</td>';
            echo '<td>'.$user["name"].'</td>';
            echo '</tr>';
            }
        ?>
        </tbody>
        </table>
    </div>

    <div id="ViewUsers" style="display: none;">
    <?php echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'ViewUsers\').style.display=\'none\'">View all Users</h4></div>';
	  foreach($users as $user) {
	    echo '<div class="navbar navbar-light" style="background-color: #e3f2fd;">';
	    echo '<a class="navbar-brand navbar-toggler toggler-example" data-toggle="collapse" data-target="#navbarSupportedContent'.$user['id'].'">Name - '.$user['name'].'</a>';
	    echo '<button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent'.$user['id'].'" aria-controls="navbarSupportedContent'.$user['id'].'" aria-expanded="false" aria-label="Toggle navigation">';
	    echo '<span class="dark-blue-text">+</span></button>';

    	    echo '<div class="collapse navbar-collapse" id="navbarSupportedContent'.$user['id'].'">';
	    echo '<ul class="navbar-nav mr-auto">';
echo '<table class="table table-bordered><tr><td width="80%">&nbsp</td>';
echo '<td rowspan="7"><img width="200" height="200" src="user_images/'. $user['image'].'">';
echo '</td></tr><tr><td>';
    	    echo '<li class="nav-item">Name - <b>'. $user['name'].'</b></li>';
//    	    echo '<li class="nav-item" onchange="">Sys ID - <b>'. $user['id'].'</b></li>';
echo '</td><td>&nbsp</td></tr><tr><td>';
//    	    echo '<li class="nav-item">Name - <b>'. $user['name'].'</b></li>';
//echo '</td><td></td></tr><tr><td>';
    	    echo '<li class="nav-item">Email Address - <b>'. $user['email'].'</b></li>';
echo '</td><td>&nbsp</td></tr><tr><td>';
    	    echo '<li class="nav-item">Mailing Address - <b>'. $user['address'].'</b></li>';
echo '</td><td>&nbsp</td></tr><tr><td>';
    	    echo '<li class="nav-item">Town/Suburb - <b>'. $user['address2'].'</b></li>';
echo '</td><td>&nbsp</td></tr><tr><td>';
    	    echo '<li class="nav-item">Birthdate - <b>'. $user['birthdate'].'</b></li>';
echo '</td><td>&nbsp</td></tr><tr><td>';
    	    echo '<li class="nav-item">Credit Amount - <b>$'. $user['credit'].'</b></li>';
//echo '</td></tr><tr><td>';
//    	    echo '<li class="nav-item">RFID - '. $user['rfid_uid'].'</li>';
//echo '</td></tr><tr><td>';
echo '</td><td>&nbsp</td></tr></table>';
	    echo '<button class="nav-item" type="button" onclick="Delete_User('.$user['id'].')"><font color="red">-Delete-User-</font></button>';
	    echo '</ui></div>';
	    echo '</div>';
        }
    ?>
    </div>

    <div id="ViewDHCP" style="display: none;">
    </div>

<!-- Modal Popup - Site Settings -->
<div class="modal" id="SiteSettings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<div class="modal-header bg-danger text-body" style="height: 65px;">
	    <h3 class="modal-title" id="exampleModalLabel">System Settings</h3>
	</div>
	<form method="post" id="sitesettings" enctype="multipart/form-data">
	<div class="modal-body">

	  <ul class="nav nav-tabs">
	    <li class="active"><a data-toggle="tab" href="#SitSet"><font size="4" color="Blue">&nbsp  Site Settings  &nbsp| </font></a></li>
	    <li><a data-toggle="tab" href="#EspSet"><font size="4" color="Blue">&nbsp  ESP Reciever  &nbsp|</font></a></li>
	    <li><a data-toggle="tab" href="#MonSet"><font size="4" color="Blue">&nbsp  Cost Settings</font></a></li>
	  </ul>

	    <div class="tab-content">
		<div id="SitSet" class="tab-pane active">
		    <div class="modal-header  bg-warning text-body" style="height: 50px;">
			<h5>Change Website Settings</h5>
		    </div>

		    <?php echo "<input type='hidden' id='Data_Source' name='Data_Source' value='SiteSettings'>"; ?>
		    <?php   echo "<div class='input-group'>Site Title -&nbsp<input id='SiteTitle' type='text' class='form-control w-50' name='SiteTitle' placeholder='$Title'></div>"; ?>
		    <?php   echo "<div class='input-group'>Group Play Hours -&nbsp<input id='GroupPlay' type='text' class='form-control w-50' name='GroupPlay' placeholder='$GroupPlayHours'></div>"; ?>
		    <?php   echo "<div class='input-group'>Bonus Birthday Credits -&nbsp<input id='BBCredit' type='text' class='form-control w-50' name='BBCredit' placeholder='$BBCredit'></div>"; ?>
		    <?php   echo "<div class='input-group'>Background Picture -&nbsp<input id='BgPicture' type='text' class='form-control w-50' name='BgPicture' placeholder='$BgImage'></div>"; ?>
<script>
function TimDat() {
    var selectBox = document.getElementById("TimDat");
    var selectedValue = selectBox.options[TimDat.selectedIndex].value;
}
</script>
		    <div class='input-group'>Time Format -&nbsp
		        <select id="TimDat" name="TimDat" class="form-control w-50 input-sm" onchange="TimDat()">
			    <option value='TD'>Time-Date</option>
			    <option value='T'>Time Only</option>
			    <option value='D'>Date Only</option>
		        </select>
		    </div>
<script>
    $(document).ready(function() {
       $('input[name="Tgst"]').click(function() {
	    var inputValue = $(this).attr("value");
	    $("." + inputValue).toggle();
	});
       $('input[name="T_Bonus"]').click(function() {
	    var inputValue = $(this).attr("value");
	    $("." + inputValue).toggle();
	});
    });
</script>
		    <div class='input-group'>Apply GST&nbsp
			<?php echo '<div><input type="checkbox" name="Tgst" value=check '; if ($T_GST =="check"){ echo"checked"; }; echo'></div>'; ?>
		        <div class="check"><?php echo '<input type="text" class="form-control w-3" name="gst" maxlength="3" size="3" value="'.$GST.'">%'; ?></div>
		    </div>
		    <div class='input-group'>Apply % Discount at $$ Spent&nbsp
			<?php echo '<div><input type="checkbox" name="T_Bonus" value="'.$T_Bonus.'" checked></div>'; ?>
			<div class="checked"><?php echo '<input type="text" class="form-control w-3" name="Bonus" maxlength="3" size="3" value='.$Bonus.'>'; ?> % at </div>
			<div class="checked"><?php echo '<input type="text" class="form-control w-3" name="BAmount" maxlength="3" size="3" value='.$BAmount.'>'; ?></div>
		    </div>
		    <div class='input-group'>Random Timed Names Format -&nbsp
		        <select id="NameType" name="NameType" class="form-control w-50 input-sm">
			    <option value=''>Blank Names</option>
<?php foreach($json as $key=>$value){ if ($key==$NameType) { $sel="selected"; } else { $sel=""; }; echo "<option $sel &nbsp value=$key>$key</option>"; }; ?>
		        </select>
		    </div>
	        </div>

	        <div id="EspSet" class="tab-pane">
		    <div class="modal-header bg-warning text-body" style="height: 50px;">
			<h5>Change Esp Reciever Settings</h5>
		    </div>
		    <table align="center">
		        <tr><td>Colour 1</td><td>Colour 2</td><td>Colour 3</td><td>Colour 4</td></tr>
<script>
function WC1() {
var selectBox = document.getElementById("Wheel1");
var selectedValue = selectBox.options[Wheel1.selectedIndex].value;
selectBox.style.background=selectedValue;
}
function WC2() {
var selectBox = document.getElementById("Wheel2");
var selectedValue = selectBox.options[Wheel2.selectedIndex].value;
selectBox.style.background=selectedValue;
}
function WC3() {
var selectBox = document.getElementById("Wheel3");
var selectedValue = selectBox.options[Wheel3.selectedIndex].value;
selectBox.style.background=selectedValue;
}
function WC4() {
var selectBox = document.getElementById("Wheel4");
var selectedValue = selectBox.options[Wheel4.selectedIndex].value;
selectBox.style.background=selectedValue;
}
</script>
			<tr><td>
		            <select id="Wheel1" name="Wheel1" class="form-control input-sm" onchange="WC1();">
			    <?php for($i = 0; $i <= 6; $i++){
				 if ($WheelC1==$WheelColour[$i]){ $wh="selected"; }else{ $wh=""; };
				    echo "<option value='$WheelColour[$i]' $wh>$WheelColour[$i]</option>"; };  ?>
			    </select></td>
		        <td>
			    <select id="Wheel2" name="Wheel2" class="form-control input-sm" onchange="WC2();">
			    <?php for($i = 0; $i <= 6; $i++){
			         if ($WheelC2==$WheelColour[$i]){ $wh="selected"; }else{ $wh=""; };
				     echo "<option value='$WheelColour[$i]' $wh>$WheelColour[$i]</option>"; };  ?>
			    </select></td>
		        <td>
			    <select id="Wheel3" name="Wheel3" class="form-control input-sm" onchange="WC3();">
			    <?php for($i = 0; $i <= 6; $i++){
			         if ($WheelC3==$WheelColour[$i]){ $wh="selected"; }else{ $wh=""; };
				     echo "<option value='$WheelColour[$i]' $wh>$WheelColour[$i]</option>"; };  ?>
			    </select></td>
		        <td>
			    <select id="Wheel4" name="Wheel4" class="form-control input-sm" onchange="WC4();">
			    <?php for($i = 0; $i <= 6; $i++){
			         if ($WheelC4==$WheelColour[$i]){ $wh="selected"; }else{ $wh=""; };
				     echo "<option value='$WheelColour[$i]' $wh>$WheelColour[$i]</option>"; };  ?>
			    </select></td>
			</tr>
		    </table>
		    <div class="d-flex justify-content-center my-4">Led Brightness &nbsp
			<div class="range-field w-50">
		    	    <?php echo "<input id='customRange11' name='Brightness' class='custom-range' type='range' min='0' max='100' value=$Brightness>"; ?>
			</div>
			<span class="font-weight-bold text-primary ml-2 mt-1 valueSpan2"></span>
		    </div>
<script>
$(document).ready(function() {
const $valueSpan = $('.valueSpan2');
const $value = $('#customRange11');
$valueSpan.html($value.val());
$value.on('input change', () => {    $valueSpan.html($value.val());    });
});
</script>

	            <div class="custom-file mb-3">
		        <input type="file" class="custom-file-input" id="customFile" name="filename">
		        <label class="custom-file-label" for="customFile">Choose OTA Update file</label>
	    	    </div>
<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
		</div>
	        <div id="MonSet" class="tab-pane">
		    <div class="modal-header bg-warning text-body" style="height: 50px;">
			<h5>Charge at Hourly Rate</h5>
		    </div>
<?php
		    echo "<table>";
		    echo "<tr><td><div class='input-group'>1st Hour -&nbsp<input id='THour1' type='text' class='form-control w-5' name='THour1' placeholder='$THour1'></div>";
		    echo "</td><td><div class='input-group'>2nd Hour -&nbsp<input id='THour2' type='text' class='form-control w-5' name='THour2' placeholder='$THour2'></div>";
		    echo "</td><td><div class='input-group'>3rd Hour -&nbsp<input id='THour3' type='text' class='form-control w-5' name='THour3' placeholder='$THour3'></div>";
		    echo "</td></tr>";
		    echo "<tr><td><div class='input-group'>4th Hour -&nbsp<input id='THour4' type='text' class='form-control w-5' name='THour4' placeholder='$THour4'></div>";
		    echo "</td><td><div class='input-group'>5th Hour -&nbsp<input id='THour5' type='text' class='form-control w-5' name='THour5' placeholder='$THour5'></div>";
		    echo "</td><td><div class='input-group'>6th Hour -&nbsp<input id='THour6' type='text' class='form-control w-5' name='THour6' placeholder='$THour6'></div>";
		    echo "</td></tr>";
		    echo "<tr><td><div class='input-group'>7th Hour -&nbsp<input id='THour7' type='text' class='form-control w-5' name='THour7' placeholder='$THour7'></div>";
		    echo "</td><td><div class='input-group'>8th Hour -&nbsp<input id='THour8' type='text' class='form-control w-5' name='THour8' placeholder='$THour8'></div>";
		    echo "</td><td><div class='input-group'>9th Hour -&nbsp<input id='THour9' type='text' class='form-control w-5' name='THour9' placeholder='$THour9'></div>";
		    echo "</td></tr>";
		    echo "</table>";
?>
		    <br>

		</div>
	    </div>
	  </div>
	  <div class="modal-footer">
	    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	    <button type="submit" name"SitebtnSubmit" class="btn btn-primary">Submit Changes</button>
	  </div>
	</form>
	</div>
  </div>
</div>
