<?php
    require "common.php";
?>

<script>

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

function Find_DHCP(mac) {
  $.ajax({
    url: "-FindDHCP.php",
    data: {  mac_address: mac  },
    type: "POST",
    success: function(result) { alert("Turned On White Ring"); },
    complete: function() {// document.getElementById('mac_find').submit();
	 }
  });
};

</script>

<?php 

$command = escapeshellcmd('sudo python3 /var/www/html/scripts/dhcp_check.py');
$output = shell_exec($command);
$test = json_decode($output, true);
$tag=0;
echo '<div class="navbar navbar-dark bg-primary"><h4 onclick="getElementById(\'ViewDHCP\').style.display=\'none\'">Active Scan/Add MAC Address</h4></div>';
  for ($i = 0; $i < count($test); $i++ ) {

$users = $database->select("machine", ["machine_mac","machine_name"],["machine_mac"=>($test[$i]['mac_address'])]);

foreach($users as $user) {  $tag=1;  echo '<div class="navbar navbar-light" style="background-color: #04f2fd;">';  echo $user['machine_name'];  }

if ($tag !=1) {  echo '<div class="navbar navbar-light" style="background-color: #eef2fd;">'; }
$tag=0;
    echo '<a class="navbar-brand navbar-toggler toggler-example" data-toggle="collapse" data-target="#navbarSupportedContent'.$i.'">Mac - '.$test[$i]['mac_address'].'</a>';

    echo '<button type="button" onclick="Find_DHCP(\''.$test[$i]['mac_address'].'\')"><font color="red">- Find Machine -</font></button>';

    echo '<button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent'.$i.'" aria-controls="navbarSupportedContent'.$i.'" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="dark-blue-text">+</span></button>';

    echo '<div class="collapse navbar-collapse" id="navbarSupportedContent'.$i.'">';
    echo '<ul class="navbar-nav mr-auto">';
    echo '<li class="nav-item">IP Address - <b>'. $test[$i]['ip_address'].'</b></li>';
    echo '<li class="nav-item">Mac Address - <b>'. $test[$i]['mac_address'].'</b></li>';
    echo '<li class="nav-item">Expires - <b>'. $test[$i]['Expires'].'</b></li>';
    echo '<li class="nav-item">Client Name - <b>'. $test[$i]['Client_Name'].'</b></li>';
    echo '<form id="mac_add" method="post">';
    echo '<div class="input-group mb-3">';
    echo '<input id="machine_name" class="form-control" type="text" name="machine_name" placeholder="Enter Machine Name">';
    echo '<input id="machine_value" class="form-control" type="text" name="machine_value" placeholder="$ per play">';
    echo '<button class="nav-item" type="button" onclick="Add_DHCP(\''.$test[$i]['mac_address'].'\')"><font color="red">- Add MAC Address to Database -</font></button>';
    echo '</div></form></ui></div>';
  echo '</div>';
  }
echo '</div>';

?>

