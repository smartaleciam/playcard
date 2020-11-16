<style>
table.calendar {
	border-left: 1px solid #999;
	font-family: Arial !important;
}
tr.calendar-row {
}
td.calendar-day {
	min-height: 80px;
	font-size: 11px;
	position: relative;
	vertical-align: top;
}
* html div.calendar-day {
	height: 80px;
}
td.calendar-day:hover {
	background: #eceff5;
}
td.calendar-day-np {
	background: #eee;
	min-height: 80px;
}
* html div.calendar-day-np {
	height: 80px;
}
td.calendar-day-head {
	background: #ccc;
	font-weight: bold;
	text-align: center;
	width: 120px;
	padding: 5px;
	border-bottom: 1px solid #999;
	border-top: 1px solid #999;
	border-right: 1px solid #999;
}
div.day-number {
	background: #999;
	padding: 5px;
	color: #fff;
	font-weight: bold;
	float: right;
	margin: -5px -5px 0 0;
	width: 25px;
	text-align: center;
}
td.calendar-day, td.calendar-day-np {
	width: 120px;
	padding: 5px;
	border-bottom: 1px solid #999;
	border-right: 1px solid #999;
}
</style>
<script>
    $(function() {
	<!--$.datepicker.setDefaults($.datepicker.regional['en']);-->
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
	  regional: "fi",
      changeMonth: true,
      numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
</script>
<div id="Bookings" style="display: none;" class="col-md-auto text-md-left pr-md-5">
  <div class="card">
    <div class="col-md-auto w-70 panel-group">
      <div class="panel panel-primary">
        <table background="images/background-wood.jpg" class="table" width="100%" height="330">
	  <tr><td>

	<div class="container">
	    <ul class="nav nav-pills nav-justified">
	      <button><li class="active"><a data-toggle="tab" href="#V_Book">View Bookings</a></li></button>
	      <button><li><a data-toggle="tab" href="#M_Book">Make Booking</a></li></button>
	      <button><li><a data-toggle="tab" href="#D_Book">Delete Booking</a></li></button>
	    </ui>
	</div>
	  </td></tr>
	  <tr><td>

	    <div class="tab-content">

		<div id="M_Book" class="tab-pane">
		    <h1>Bookings Calendar</h1>
		    <form action="b_book.php" method="post">
			<h3>Group Size</h3>
			<p><input checked="checked" name="item" type="radio" value="Group1-5" />Small(1-5)
			| <input name="item" type="radio" value="Group6-10" />Med(6-10)
			| <input name="item" type="radio" value="Group11-15" />Large(11-15)
			| <input name="item" type="radio" value="Group16-20" />Ex_Large(16-20)
			<input name="item" type="radio" value="Group21+" />Party(21+)</p>
			<table style="width: 70%">
				<tr>
				    <td>Name:</td>
				    <td> <input maxlength="50" name="name" required="" type="text" /></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				</tr>
				<tr>
				    <td>Phone:</td>
				    <td> <input maxlength="20" name="phone" required="" type="text" /></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				</tr>
				<tr>
				    <td>Comments:</td>
				    <td colspan="3"> <input maxlength="255" name="comments" required="" type="text" /></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				</tr>
				<tr>
				    <td>Reservation time:</td>
				    <td> <input id="from" name="start_day" required="" type="text" /></td>
				    <td>-</td>
				    <td><input id="to" name="end_day" required="" type="text" /></td>
				</tr>
				<tr>
				    <td>&nbsp;</td>
				    <td>
				      <select name="start_hour">
					 <option selected="selected">00</option>
					 <?php for ($i = 0; $i <=23; $i++) { echo"<option>$i</option>"; } ?>
				      </select>:<select name="start_minute">
					 <option selected="selected">00</option>
					 <option>30</option>
				      </select></td>
				    <td>&nbsp;</td>
				    <td>
				      <select name="end_hour">
					 <option>00</option>
					 <?php for ($i = 0; $i <=22; $i++) { echo"<option>$i</option>"; } ?>
					 <option selected="selected">23</option>
				      </select>:<select name="end_minute">
					 <option>00</option>
					 <option selected="selected">30</option>
				      </select>
				    </td>
				</tr>
			</table>
			<input name="book" type="submit" value="Book" />
		    </form>
	        </div>

		<div id="D_Book" class="tab-pane">
		<h3>Cancel booking</h3>
		    <form action="b_cancel.php" method="post">
			
			ID: <input name="id" required="" type="text" /><br />
			<p><input name="cancel" type="submit" value="Cancel" /></p>
		    </form>
		</div>


<?php
/* draws a calendar */
function draw_calendar($month,$year){

	include 'b_config.php';

	// Create connection
	$conn = mysqli_connect($servername, $username, $password,  $dbname);

	// Check connection
	if (!$conn) {
    	die("Connection failed: " . mysqli_connect_error());
	}

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			$current_epoch = mktime(0,0,0,$month,$list_day,$year);
			
			$sql = "SELECT * FROM $tablename WHERE $current_epoch BETWEEN start_day AND end_day";
						
			$result = mysqli_query($conn, $sql);
    		
    		if (mysqli_num_rows($result) > 0) {
    			// output data of each row
    			while($row = mysqli_fetch_assoc($result)) {
					if($row["canceled"] == 1) $calendar .= "<font color=\"grey\"><s>";
    				$calendar .= "<b>" . $row["item"] . "</b><br>ID: " . $row["id"] . "<br>" . $row["name"] . "<br>" . $row["phone"] . "<br>";
    				if($current_epoch == $row["start_day"] AND $current_epoch != $row["end_day"]) {
    					$calendar .= "Booking starts: " . sprintf("%02d:%02d", $row["start_time"]/60/60, ($row["start_time"]%(60*60)/60)) . "<br><hr><br>";
    				}
    				if($current_epoch == $row["start_day"] AND $current_epoch == $row["end_day"]) {
    					$calendar .= "Booking starts: " . sprintf("%02d:%02d", $row["start_time"]/60/60, ($row["start_time"]%(60*60)/60)) . "<br>";
    				}
    				if($current_epoch == $row["end_day"]) {
    					$calendar .= "Booking ends: " . sprintf("%02d:%02d", $row["end_time"]/60/60, ($row["end_time"]%(60*60)/60)) . "<br><hr><br>";
    				}
    				if($current_epoch != $row["start_day"] AND $current_epoch != $row["end_day"]) {
	    				$calendar .= "Booking: 24h<br><hr><br>";
	    			}
					if($row["canceled"] == 1) $calendar .= "</s></font>";
    			}
			} else {
    			$calendar .= "No bookings";
			}
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8 AND $days_in_this_week > 1):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	mysqli_close($conn);
	
	/* all done, return result */
	return $calendar;
}
?>

		<div id="V_Book" class="tab-pane active">
		    <?php include 'b_config.php';
		    $d = new DateTime(date("Y-m-d"));
		       $thismonth=$months[$d->format('n')-1];
		    $d->modify( 'first day of next month' );
		       $nextmonth=$months[$d->format('n')-1];
		    $d->modify( 'first day of next month' );
		       $next3month=$months[$d->format('n')-1];

		    echo "<ul class='nav nav-pills'>";
		      echo "<button><li class='active'><a data-toggle='tab' href='#".$thismonth."'> ".$thismonth."</a></li></button>";
		        $d->modify( 'first day of next month' );
		      echo "<button><li class='active'><a data-toggle='tab' href='#".$nextmonth."'> ".$nextmonth."</a></li></button>";
		        $d->modify( 'first day of next month' );
		      echo "<button><li class='active'><a data-toggle='tab' href='#".$next3month."'> ".$next3month."</a></li></button>";
		    echo"</ul>";

		    echo "<div class='tab-content'>";
			echo "<div id='$thismonth' class='tab-pane active'>";
			$d = new DateTime(date("Y-m-d"));
			echo '<h3>' . $thismonth . ' ' . $d->format('Y') . '</h3>';
			echo draw_calendar($d->format('m'),$d->format('Y'));
		    echo "</div>";

			echo "<div id='$nextmonth' class='tab-pane'>";
			    $d->modify( 'first day of next month' );
			    echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
			    echo draw_calendar($d->format('m'),$d->format('Y'));
			echo "</div>";

			echo "<div id='$next3month' class='tab-pane'>";
			    $d->modify( 'first day of next month' );
			    echo '<h3>' . $months[$d->format('n')-1] . ' ' . $d->format('Y') . '</h3>';
			    echo draw_calendar($d->format('m'),$d->format('Y'));
			echo "</div>";
?>
		    </div>
		</div>

	    </div>

	</td></tr>
	</table>

      </div>
    </div>
  </div>
</div>

