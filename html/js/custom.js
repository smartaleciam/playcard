// <script type="text/javascript">
//  $(function() {  $('#datetimepicker').datetimepicker();  });
//  $(function() {  $('number').keyboard();  });
//  $(function() {  $('#calendar').calendar(options);  });
//</script>
<script type="text/javascript">

//function Credit_Topup() {
//    var x = 0;
//    x = document.getElementById("CreditTopup").elements.namedItem("amount").value;
//    $.ajax({
//    url: "-CreditTopup.php",
//    data: {credit: x},
//    type: "POST",
//    success: function(result) { alert(result); },
//    beforeSend: function() { $(".loading").show(); },
//    complete: function() { $(".loading").hide();  document.getElementById('CreditTopup').submit();  }
//    });
//};

//function Credit_Check() {
//  $.ajax({
//    url: "-CreditCheck.php",
//    success: function(result) { document.getElementById('CreditInfo').innerHTML=result; },
//    beforeSend: function() { $(".loading").show(); },
//    complete: function() { $(".loading").hide();  }
//  });
//};


//function Delete_User(id) {
//    alert("Are you sure?");
//    $.ajax({
//    url: "-DeleteUser.php",
//    data: {value: id},
//    type: "POST",
//    success: function(result) { alert(result); $users = $database->select("users", ['id','name','mobile','email','address','address2','birthdate','credit','rfid_uid']);  }
//    beforeSend: function() { $(".loading").show(); },
//    complete: function() { $(".loading").hide(); }
//  });
//};

function ClearLcd1(){
alert('clear lcd');
  $('#container').load("-clear_lcd.php");
  console.log();
alert('completed task');
};


//function Scan_DHCP() {
//    $.ajax({
//    url: "-ScanDHCP.php",
//    success: function(result) { document.getElementById('ViewDHCP').innerHTML = result; },
//    beforeSend: function() { $(".loading").show();  document.getElementById('ViewDHCP').style.display = 'inline'; },
//    complete: function() { $(".loading").hide(); }
//  });
//};

function LcdBacklight() {
  var x = document.getElementById("lcdbacklight");
  if (x.innerHTML === "LCD ON") {  x.innerHTML = "LCD OFF";  BL = 1;  } else {  x.innerHTML = "LCD ON";  BL = 0;   }
    $.ajax({
    url: "-LcdBacklight.php",
    data: {value: BL},
    type: "POST",
    success: function(result) { },
    beforeSend: function() { $(".loading").show(); },
    complete: function() { $(".loading").hide(); }
  });
};

//function Admin_Buttons($val) {
//    var x = document.getElementById($val).style.display;
//    if (x === 'none') {   document.getElementById($val).style.display = 'inline';   } else { document.getElementById($val).style.display = 'none';    }
//};

//function Add_DHCP(mac) {
//  $.ajax({
//    url: "-InsertDHCP.php",
//    data: {
//      mac_address: mac,
//      machine_name: document.getElementById('mac_add').elements.namedItem('machine_name').value,
//      machine_value: document.getElementById('mac_add').elements.namedItem('machine_value').value
//      },
//    type: "POST",
//    success: function(result) { alert("Added"); },
//    complete: function() { document.getElementById('mac_add').submit(); }
//  });
//};


