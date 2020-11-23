<nav class="navbar navbar-dark bg-dark">
<?php   echo "<a class='navbar-brand' href=''>$Title</a>"; ?>
<div style="color:#ffffff" align="Right" id="timeClock">Clock</div>
<div style="display: none;" id="butt"></div>
<button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#Admin_Pass"><img src="/images/locked.png" width="25" height="25" id="Admin_Image"></button> 
</nav>

<script>
var myVar = setInterval(myTimer,1000);
function myTimer(){
var $TF="<?php echo $TF ?>";
    var dat = new Date();
    if ($TF=="T") { document.getElementById("timeClock").innerHTML = dat.toLocaleTimeString(); };
    if ($TF=="D") { document.getElementById("timeClock").innerHTML = dat.toLocaleDateString(); };
    if ($TF=="TD") { document.getElementById("timeClock").innerHTML = dat.toLocaleString(); };
};

//$(document).ready(function(){
//    setInterval(function(){ $("#butt").load("read_gpio.php");  // Read GPIO 26 Key Switch
//	var ad_lock = document.getElementById("butt").innerHTML;
//	if ( ad_lock== 1) { document.getElementById('admin_menu').style.display = 'inline'; } else { document.getElementById('admin_menu').style.display = 'none'; }; }, 1000);
//});

function Admin_Login() {
  ad_lock = document.getElementById('admin_menu').style.display;
  if (ad_lock == 'none') {
    document.getElementById('Admin_Image').src = "/images/un-locked.png";
    document.getElementById('admin_menu').style.display = 'inline';
    $('#Admin_Pass').modal('toggle'); 
  }
  if (ad_lock == 'inline') {
    document.getElementById('Admin_Image').src = "/images/locked.png";
    document.getElementById('admin_menu').style.display = 'none';
    $('#Admin_Pass').modal('toggle'); 
  }
};
  
function Admin_Buttons($val) {
  var x =document.getElementById($val).style.display;
  if (x === 'none'){ document.getElementById($val).style.display = 'inline';  } else { document.getElementById($val).style.display = 'none'; }
};

function Scan_DHCP() {
    $.ajax({
    url: "-ScanDHCP.php",
    success: function(result) { document.getElementById('ViewDHCP').innerHTML = result; },
    beforeSend: function() { $(".loading").show();  document.getElementById('ViewDHCP').style.display = 'inline'; },
    complete: function() { $(".loading").hide(); }
  });
};

</script>

<!-- Modal Popup - Admin Login Section -->
<div class="modal" id="Admin_Pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-warning">
	    <h2 class="modal-title" id="exampleModalLabel">Admin Login</h2>
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
	<form method="post" id="Admin_Login" enctype="multipart/form-data">
        <div class="modal-body">
  	      <div class-"input-group">UserName -
	        <input id="Admin_Uname" type="text" class="form-control" name="Admin_Uname" placeholder="Enter UserName">
	      </div>
 	      <div class-"input-group">Password -
	        <input id="Admin_Pass" type="password" class="form-control" name="Admin_Pass" placeholder="Enter Password">
	      </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onClick="Admin_Login()">Log In</button>
        </div>
      </form>
    </div>
  </div>
</div>

    <div id="admin_menu" style="display: none;">
	<div class="navbar navbar-light" style="background-color: #e3f2fd;">
<!--	    <div class="nav-item"> <button type="button" class="btn btn-dark bg-warning" id="lcdbacklight" onclick="LcdBacklight()">LCD ON</button> </div>
-->
	    <div class="dropdown">
	      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMachines" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Machine Options  </button>
	      <div class="dropdown-menu" aria-labelledby="dropdownMachines">
            <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('MachineStats')">Machine Stats</button></center>
            <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('EditMachines')">Edit Machines</button></center>
	        <div class="dropdown-divider"></div>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('CalabrateMachines')">Calabrate Machines</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Scan_DHCP()">Scan for Active DHCP leases</button></center>
	      </div>
	    </div>

	    <div class="dropdown">
	      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMembers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        Members Options  </button>
	      <div class="dropdown-menu" aria-labelledby="dropdownMembers">
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('ViewUsers')">View Users</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('MembershipEdit')">-Edit Members</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('BrowseMembers')">-Browse Members</button></center>
	        <div class="dropdown-divider"></div>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('MembershipCredits')">Total Membership Credits</button></center>
	      </div>
	    </div>

	    <div class="dropdown">
	      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownSettings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        System Settings  </button>
	      <div class="dropdown-menu" aria-labelledby="dropdownSettings">
<!--
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons()">-----</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons()">-----</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons()">-----</button></center>
	        <div class="dropdown-divider"></div>
-->
                <center> <button type="button" class="btn btn-dark bg-warning" data-toggle="modal" data-target="#SiteSettings">Edit Site Settings</button>  </center>
	        <div class="dropdown-divider"></div>
                <center> <button type="button" class="btn btn-dark bg-warning" data-toggle="modal" data-target="#TroubleShoot">TroubleShooting</button>  </center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="document.getElementById('PhAdm').src='https://smartlink/phpmyadmin'; Admin_Buttons('PHPmyAdmin')">PHPmyAdmin</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="document.getElementById('WifiAP').src='http://192.168.10.2'; Admin_Buttons('WIFIaccessPOINT');" title="192.168.10.2">Wifi AP #1</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="document.getElementById('WifiAP').src='http://192.168.10.3'; Admin_Buttons('WIFIaccessPOINT');" title="192.168.10.3">Wifi AP #2</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="document.getElementById('WifiAP').src='http://192.168.10.4'; Admin_Buttons('WIFIaccessPOINT');" title="192.168.10.4">Wifi AP #3</button></center>
	        <center> <button type="button" class="btn btn-dark bg-warning" onclick="document.getElementById('WifiAP').src='http://192.168.10.5'; Admin_Buttons('WIFIaccessPOINT');" title="192.168.10.5">Wifi AP #4</button></center>
<!--
	        <center> <a href="terminal.php" class="btn btn-dark bg-warning">Terminal</a> </center>
-->
	        <center> <button type="button" class="btn btn-dark bg-warning" data-toggle="modal" data-target="#About">About</button></center>
	      </div>
	    </div>

            <div class="nav-item"> <button type="button" class="btn btn-dark bg-warning" onclick="Admin_Buttons('IncomeReports')">Income Reports</button> </div>
	</div>
    </div>
