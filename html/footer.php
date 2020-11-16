<script type="text/javascript">
function AddPrice() {
    $Username=document.getElementById('Username').value;
    $Amount=document.getElementById('amount').value;
    $Qty="1";
    $Sub=$Amount*$Qty;
     document.getElementById('Admin_Image').style.display = 'none';
     document.getElementById('paynow').style.display = 'inline';
    $(".header_tbl tbody").prepend("<tr><td>New MemberShip :- "+$Username+"</td><td class='product_price'>"+$Amount+"</td><td><input type='text' name='qty' class='product_qty' value='"+$Qty+"'></td><td class='amount_sub total'>"+$Sub+"</td><td class='admin'><a href='#' class='delete'>x</a></td></tr>");
};
function Bookings() {
if ( document.getElementById('Bookings').style.display == 'none') {
        document.getElementById('Big_Image').style.display = 'none';
	document.getElementById('Bookings').style.display = 'inline';
    } else {
        if (document.getElementById('paynow').style.display === 'none') { document.getElementById('Big_Image').style.display = 'inline';  }
	document.getElementById('Bookings').style.display = 'none';
    };
};

function Credit_Topup() {
    var x = 0;
    x = document.getElementById("CreditTopup").elements.namedItem("amount").value;
    $.ajax({
    url: "-CreditTopup.php",
    data: {credit: x},
    type: "POST",
    success: function(result) {
        document.getElementById("CreditTopup").elements.namedItem("amount").value='';
        document.getElementById('Big_Image').style.display = 'none';
	document.getElementById('paynow').style.display = 'inline';
        $(".header_tbl tbody").prepend(result);
    },
    beforeSend: function() { $(".loading").show(); },
    complete: function() { $(".loading").hide();  $('#MemberCredit').modal('toggle');  }
    });
};


function Timed_Play() {
    var x = 0;
    x = document.getElementById("THour").value;
    $.ajax({
    url: "-TimedPlay.php",
    data: {Ttime: x},
    type: "POST",
    success: function(result) {
        document.getElementById("THour").value='0';
        document.getElementById('Big_Image').style.display = 'none';
	document.getElementById('paynow').style.display = 'inline';
        $(".header_tbl tbody").prepend(result);
	//Ttal_Update();
    },
    beforeSend: function() { $(".loading").show(); },
    complete: function() { $(".loading").hide();  $('#TimedPlay').modal('toggle');  }
    });
};

function startwebcam(){
    Webcam.set({ width: 200, height: 160, image_format: 'jpeg', jpeg_guality: 90 });
    Webcam.attach( '#webcam' );
    };

function captureimage(){
	Webcam.snap( function(data_url) {
	    Webcam.upload( data_url, 'saveimage.php', function(code, text) {
		document.getElementById('filename').value = text;
		document.getElementById('results').innerHTML =
		'<img src="uploads/'+text+'"/>';
	    } );
	}  );
    };
</script>

    <nav class="navbar fixed-bottom navbar-light bg-dark">
	<div class="row">
            <div class="col-md">  <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#AddMember" onClick="startwebcam()">Add New Member</button>  </div>
            <div class="col-md">  <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#SearchMember">Search Members</button>  </div>
            <div class="col-md">  <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#MemberCredit">TopUp Member $</button>  </div>
            <div class="col-md">  <button type="button" class="btn btn-primary bg-primary" data-toggle="modal" data-target="#MemberCreditCheck">Check Member $</button>  </div>
	    &nbsp; &nbsp; &nbsp; &nbsp;
            <div class="col-md">  <button type="button" class="btn btn-primary bg-info" data-toggle="modal" data-target="#TimedPlay">&nbsp;&nbsp;&nbsp;  Timed &nbsp;&nbsp;&nbsp;  <br> Play</button>  </div>
            <div class="col-md">  <button type="button" class="btn btn-primary bg-success" data-toggle="modal" data-target="#GpPlay"> &nbsp;&nbsp;&nbsp;  Group &nbsp;&nbsp;&nbsp;  <br> Play</button>  </div>
				  <button type="button" onClick="Bookings()">Book</button>
	</div>
    </nav>

<!-- Modal Popup - Add New Member -->
<div class="modal" id="AddMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-warning">
	<h2 class="modal-title" id="exampleModalLabel">Enter New Member Details</h2>
	<button type="button"  class="close" data-dismiss="modal"  onClick="Webcam.reset()" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
      <div class="modal-body">
	<table><tr><td>
	<div id="webcam"></div></td><td>
	<div id="results"></div></td>
	</tr></table>
	<script type="text/javaScript" src="js/webcam.min.js"></script>
        <input type=button value="Take Snapshot" onClick="captureimage()">


     <form class="form-inline" method="post" id="addmember">
<?php echo "<input type='hidden' id='Data_Source' name='Data_Source' value='AddMember'>"; ?>
<?php echo "<input type='hidden' id='filename' name='filename' value=''>"; ?>
	  <p>
	  <div class="input-group">User Name -
	    <input id="Username" type="text" class="form-control" name="Username" placeholder="UserName">
	  </div>
	  <div class="input-group">Mobile Number -
	    <input id="mobile_number" type="text" class="form-control" name="mobile_number" placeholder="0000-000-000">
	  </div>
	  <div class="input-group">Email Address -
	    <input id="email_address" type="text" class="form-control" name="email_address" placeholder="user@myisp.com">
	  </div>
	  <div class="input-group">Mailing address -
	    <input id="h_address" type="text" class="form-control" name="h_address" placeholder="Street Number/Address">
	  </div>
	  <div class="input-group">Town/Suburb -
	    <input id="t_address" type="text" class="form-control" name="t_address" placeholder="Town/Suburb">
	  </div>
	  <div class="input-group">Birthdate -
	<?php
	  echo '<select id="day" name="day" class="form-control input-sm"><option>Day</option>';
	    for($i =1; $i <= 31; $i++){  $i =str_pad($i, 2, 0, STR_PAD_LEFT); echo "<option value='$i'>$i</option>";  }
	  echo '</select> - ';
	  echo '<select id="month" name="month" class="form-control input-sm"><option>Month</option>';
	    $n = array("Null","January","February","March","April","May","June","July","August","September","October","November","December");
	    for($i = 1; $i <= 12; $i++){  echo "<option value='$i'>$n[$i]</option>";  }
	  echo '</select> - ';
	  echo '<select id="year" name="year" class="form-control input-sm"><option>Year</option>';
	    for($i = date('Y'); $i >= date('Y', strtotime('-100 years')); $i--){  echo "<option value='$i'>$i</option>";  }
	  echo '</select>';
	?>
	  </div>
	  <div class="input-group">Credit Amount -
	    <input id="amount" type="text" class="form-control" name="amount" placeholder="$ 0">
	  </div>
	Then Scan Membership Card to Apply</p>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="Webcam.reset()">Cancel</button>
	<button type="submit" class="btn btn-primary" onClick="Webcam.reset()  Add_Price()" >Scan Membership Card</button>
      </div>
     </form>
    </div>
  </div>
</div>

<!-- Modal Popup - Member Search -->
<div class="modal" id="SearchMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-warning">
	<h2 class="modal-title" id="exampleModalLabel">Search for Member</h2>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
      <div class="modal-body">
	<div class-"input-group">Search -
	  <input id="Username" type="text" class="form-control" name="Username" placeholder="Enter Name to search for">
	</div>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	<button type="button" class="btn btn-primary">Scan Database</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Popup - Member Credit Topup -->
<div class="modal" id="MemberCredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-warning">
	<h2 class="modal-title" id="exampleModalLabel">Member Credit Topup</h2>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
     <form class="form-inline" method="post" id="CreditTopup">
      <div class="modal-body">
	<p>Enter Credit TopUp amount
	  <div class="input-group">
	    <input id="amount" type="tel" class="keboard form-control" name="amount" placeholder="$ 0">
	  </div>
	Then Scan Membership Card to Apply</p>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	<button type="button" class="btn btn-primary" onClick="Credit_Topup()">Scan Membership Card</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal Popup - Member Credit Check -->
<div class="modal" id="MemberCreditCheck" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-warning">
	<h2 class="modal-title" id="exampleModalLabel">Membership Credit Check</h2>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
      <div id="CreditInfo" class="modal-body">
	<p>Please Scan Membership Card</p>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary" onclick="Credit_Check()">Scan Membership Card</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Popup - Timed Play -->
<div class="modal" id="TimedPlay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-body">
	<h2 class="modal-title" id="exampleModalLabel">Timed - Unlimited Gaming</h2>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
      <div class="modal-body">
	<p>Purchased Time Bank
	<select id="THour" class="selectpicker">
	  <option value="0" >0hr </option>
<?php
	echo "<option value='60'>1hrs</option>";
	echo "<option value='120'>2hrs</option>";
	echo "<option value='180'>3hrs</option>";
	echo "<option value='240'>4hrs</option>";
	echo "<option value='300'>5hrs</option>";
	echo "<option value='360'>6hrs</option>";
	echo "<option value='420'>7hrs</option>";
	echo "<option value='480'>8hrs</option>";
	echo "<option value='540'>9hrs</option>";
?>
	</select>
	of Timed Unlimited Gaming</p>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	<button type="button" class="btn btn-primary" onClick="Timed_Play()">Scan Tag</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Popup - Group Play -->
<div class="modal" id="GpPlay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary text-body">
	<h2 class="modal-title" id="exampleModalLabel">Scan Group Play Cards</h2>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
      <div class="modal-body">
<?php
	echo '<button type="button" class="btn btn-primary" id="BookScan">Booking for [Name] at [Time] -<font color="Yellow"> PreScan Tags</font></button>';
	echo '<br><br>';
	echo '<button type="button" class="btn btn-primary" id="NightScan">OverNight Lock In -<font color="Yellow"> Scan Tags</font></button>';
//	echo "<p>Scan Tags to Enable then for [time] hours</p>";
 ?>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Finish Scanning</button>
<!--	<button type="button" class="btn btn-primary" disabled > Enable Scanning</button> -->
      </div>
    </div>
  </div>
</div>


<!-- Modal Popup - Calculator / Checkout -->
<div class="modal fade" id="CalCheck" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-warning">
	<h2 class="modal-title" id="exampleModalLabel">Calculator / Checkout Payment</h2>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
      </div>
      <div class="modal-body">
	<div class-"input-group">Search -
	  <input id="Username" type="text" class="form-control" name="Username" placeholder="Enter Name to search for">
	</div>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	<button type="button" class="btn btn-primary">Pay Bill Total</button>
      </div>
    </div>
  </div>
</div>

<style>
.modal-dialog2 {
    position: absolute;
    top: 10px;
    right: 100px;
    bottom: 0;
    left: 0;
    z-index: 10040;
    overflow: auto;
    overflow-y: auto;
}
</style>
