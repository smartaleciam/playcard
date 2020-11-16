<?php
$mac = $_POST['mac_address'];
//echo $mac;
//$mac = "84:F3:EB:0F:52:7F";
//echo $mac;
//$statusmsg = "";

    publish_message('{"Opp":"Wheel","Cw1":"White","Cw2":"Red","Cw3":"White","Cw4":"Red","LB":"100"}', $mac, "192.168.10.1", 1883, 5);

function publish_message($msg, $topic, $server, $port, $keepalive) {
	
	$client = new Mosquitto\Client();
	$client->setCredentials("smartlink", "smartalec");
//	$client->onConnect('connect');
//	$client->onDisconnect('disconnect');
	$client->onPublish('publish');
	$client->connect($server, $port, $keepalive);
	
	try {
		$client->loop();
		$mid = $client->publish($topic, $msg);
		$client->loop();
		}catch(Mosquitto\Exception $e){
//			echo 'Exception';          
			return;
			}
    $client->disconnect();
	unset($client);	
}

/*****************************************************************
 * Call back functions for MQTT library
 * ***************************************************************/					
function connect($r) {
		if($r == 0) echo "{$r}-CONX-OK|";
		if($r == 1) echo "{$r}-Connection refused (unacceptable protocol version)|";
		if($r == 2) echo "{$r}-Connection refused (identifier rejected)|";
		if($r == 3) echo "{$r}-Connection refused (broker unavailable )|";        
}
 
function publish() {
        global $client;
//        echo "Mesage published:";
}

function disconnect() {
        echo "Disconnected|";
}

function message($message) {
	    //**Store the status to a global variable - debug purposes
		$GLOBALS['statusmsg']  = "RX-OK|";
		
		//**Store the received message to a global variable
		$GLOBALS['rcv_message'] =  $message->payload;
}

?>
