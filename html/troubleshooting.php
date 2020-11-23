<html>
<?php
require_once('troubleshootingCommands.php');
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TroubleShooting Screen</title>
</head>

<body>
<div id="bodyWrapper">
  <div style="margin:0 auto;"> <br />
    <fieldset style="padding: 10px; border: 2px solid #000;">
      <legend>Troubleshooting Commands</legend>
      <div style="overflow: hidden; padding: 10px;">
	<div class="clear"></div>
<?php
foreach ($commands as $title => $command)
{
?>
	<h3><?php echo $title . ':&nbsp;&nbsp;&nbsp;&nbsp;' . $command; ?></h3>
	<pre><?php echo $results[$command]; ?></pre><hr>
<?php
}
?>
      </div>
    </fieldset>
  </div>

</div>
</body>
</html>
