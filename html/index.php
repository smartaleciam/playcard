<?php
require "common.php";
require_once "menu.php";
include "admin.php";
include "checkout.php";
?>
<style>
.sidenav {
  border-radius: 25px;
  border: 2px solid #73AD21;
  padding: 2px;
  position: fixed;
  width: 130px;
  height: 80%;
  background-color: #498efc;
}
</style>
  <div class="sidenav" id="countdowns" style="display: inline;">
	<center><h5>Timed Tags</h5></center>
	<div class="countdown-bar" id="CountDownA">  <div>00:00:00:00</div>  <div> </div>  </div>
	<div class="countdown-bar" id="CountDownB">  <div>00:00:00:00</div>  <div> </div>  </div>
	<div class="countdown-bar" id="CountDownC">  <div>00:00:00:00</div>  <div> </div>  </div>
	<div class="countdown-bar" id="CountDownD">  <div>00:00:00:00</div>  <div> </div>  </div>
  </div>
<script>
    $(document).ready(function () {
	countdown('CountDownA', 0, 1, 0, 15);
	countdown('CountDownB', 0, 0, 1, 00);    // countdown( id_name, days, hours, minutes, seconds )
	countdown('CountDownC', 0, 0, 0, 15);
	countdown('CountDownD', 0, 0, 1, 45);
    });
</script>

  <div class="container">
    <div class="loading">
        <div id="loading-img"></div>
    </div>
    <div id="Big_Image" style="display: none;">
        <div class="col-md-auto text-center text-md-left pr-md-5">
        <?php echo "<div class='col-md-auto'><center><img height='300' width='400' src='images/$BgImage' /></center></div>"; ?>
	</div>
    </div>

<script>

function OpenTill() {
   $.ajax({ url: "-OpenTill.php" });
};

function PayCash() {
//	document.getElementById('CheckOut').style.display = 'inline';
	$('#CheckOut').modal('toggle');
};

$(document).ready(function(){
  $("table").filter(function(){
     if($(this).find("tbody").children().length){
	document.getElementById('paynow').style.display = 'none';  // no pay transaction's  so hide that screen it
//	document.getElementById('Big_Image').style.display = 'inline'; // // no pay transaction so display image
     }
  });

  setInterval(function(){
      var ad_lock = document.getElementById("butt").innerHTML;
//      $ad_lock=ad_lock;
	var x=document.getElementsByClassName('admin');
      if ( ad_lock==1) {
	document.getElementById('Big_Image').style.display = 'none'; // hide big image
	var i;
	for (i=0; i<x.length; i++){x[i].style.display = 'inline'; }  //show all things classed as admin
      } else {
	if (document.getElementById('paynow').style.display === 'none' AND document.getElementById('booking').style.display === 'none') {  document.getElementById('Big_Image').style.display = 'inline';  }  // show big image if pay screen not up
	var i;
	for (i=0; i<x.length; i++){x[i].style.display = 'none'; } //hide all things classed as admin
      };
    }, 1000);
});

// Cart Script data starts
$( document ).ready(function() {
    $(document).on("input paste keyup click", ".product_qty", function( event ) {

        var product_quantity = 0;
        var product_price = 0;
        var gst_amount = 0;
        var sub_total = 0;
        var total_qty = 0; 
        var grand_total = 0;

        product_quantity = $(this).val();
        product_price = $(this).parent().prev().html();
        sub_total = product_price * product_quantity;

        $(this).parent().next().html(sub_total);
        $('.product_qty' ).each( function( k, v ) {
            product_quantity = parseInt ( $(this).val() ) ? parseInt ( $(this).val() ) : 0;
            product_price = parseFloat($(this).parent().prev().html())?parseFloat($(this).parent().prev().html()):0;

            console.log(product_quantity);
            console.log(product_price);            

            sub_total = parseFloat ( product_price * product_quantity );
            console.log(sub_total);
            total_qty +=product_quantity;
            grand_total += sub_total;
        });
        if ( grand_total > 0 ){
	    gst= "<?php echo $GST; ?>";
            gst_amount = ( grand_total * gst ) /100;
        }
        $("#total_qty").html(total_qty);        
        $("#total_amount").html(grand_total);        
        grand_total +=gst_amount;
        $("#gst_amount").html(gst_amount);        
        $("#discount_amount").html(discount_amount);        
        $("#grand_total").html(grand_total);  
    });
});

$( document ).ready(function() {
    $(document).on("click", ".delete", function( event ) {
        var cart_item = 0;
        $(this).parent().parent().remove();
        cart_item = $('.product_qty').length;
        if ( cart_item <= 0 ) 
        {
            $("#total_qty").html('0');        
            $("#total_amount").html('0');        
            $("#gst_amount").html('0');        
            $("#discount_amount").html(0);        
            $("#grand_total").html('0');             
        } else {
            $('.product_qty').trigger('keyup');  
        }      
    }); 
});
//};
// Cart Script data ends
</script>

<!--
<style>
    a {
        color:#FFF;
        font-weight: bold;
    }
    table{
        color:#FFF;
        font-weight: bold;
    }
    table input{
        color:#000;
    }
-->
<style>
    .bs-example{
        background: #355979;
        margin: 20px;
    }
    .delete{
        color:#E13D3D;
        font-size: 20px;
        font-weight: bold;
    }
    .checkout{
        background: #FF002A;
    }
    .checkout a{
        color: #FFF;
        font-weight: bold;
    }
</style>

<?php include"bookings.php"; ?>

        <div id="paynow" style="display: none;" class="col-md-auto text-md-left pr-md-5">
	  <div class="card">
	    <div class="col-md-auto w-70 panel-group">
	        <div class="panel panel-primary">
		<table background="images/background-wood.jpg" class="table" width="100%" height="330">
		 <tr><td colspan="4">

		    <div class="bs-example">
		    <div class="table-responsive"> 
	            <table class="header_tbl">
        		<colgroup>
            		    <col class="con1" style="align: center; width: 30%" />
            		    <col class="con1" style="align: center; width: 20%" />
            		    <col class="con0" style="align: center; width: 20%" />
            		    <col class="con1" style="align: center; width: 20%" />
			    <col class="admin" style="align: center; width: 10%" />
        		</colgroup>
        	    <thead>
            		<tr>
                	<th>Product</th>
                	<th>Price</th>
                	<th>Quantity</th>
                	<th>Sub Total</th>
			<th class="admin">&nbsp;</th>
            		</tr>
        	    </thead>
        	    <tbody class="body" style="background: #34baeb">
		    &nbsp;
		    </tbody>
		    <tfoot style="background: #cca300">
            		<tr>
                	<td colspan=2>Sub Totals</td>
                	<td id="total_qty"></td>
                	<td id="total_amount"></td>
			<td class="admin">&nbsp;</td>
            		</tr> 
            <tr class="gst">
	        <?php echo "<td colspan=3>GST @ ".$GST." %</td>"; ?>
            <td id="gst_amount"></td>
		        <td class="admin">&nbsp;</td>
            		</tr> 
            <tr class="discount">
		<?php echo "<td colspan=3>Discount ".$Bonus."% After $".$BAmount."</td>"; ?>
            <td id="discount_amount">&nbsp;</td>
		        <td class="admin">&nbsp;</td>
            		</tr>
	                <tr class="checkout">
    	                <td colspan=3>Total Payment</td>
        	        <td id="grand_total">&nbsp;</td>
			<td class="admin">&nbsp;</td>
            		</tr> 
        	    </foot>
    		    </table>
		    </div>
		    </div>

		 </td><td width="15%">
		    <br>
		    <button type="button" onClick="PayCash()" class="btn btn-primary btn-lg">Pay Cash</button>
		    <br><br>
		    <button type="button" class="btn btn-info btn-lg" disabled>Pay Card</button>
		    <br><br>
		    <button type="button" class="admin btn btn-warning btn-lg">Clear</button>
		</td></tr>
		</table>
		</div>
	    </div>
	  </div>
	</div>

    </div>
<?php
include "footer.php";
?>
</html>
