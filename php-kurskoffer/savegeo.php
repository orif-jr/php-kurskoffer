<?php
	error_reporting(E_ALL);
	
	/* Connect to the database */
	include_once ("dbsettings.php");
	
	//header('Content-type: application/json; charset=utf-8');
	//header('Content-type: application/xml; charset=utf-8');
	header('Content-type: text/html; charset=utf-8');
	
/*
	function curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSLCERT, "client.p12");
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, "P12");
		curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "Delimu84");
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	$moodle = "https://cloud.c3lab.tk.jku.at/moodle/login/token.php?username=".$_POST['username']."&password=".$_POST['password']."&service=moodle_mobile_app";
	$result = curl($moodle);
	var_dump($result);
	echo $result->{"token"}; // print the value of 'token'
*/	
	
	if ( isset($_POST['latitude']) && isset($_POST['longtitude']) && isset($_POST['token']) ) {
		// set user location into 'middleware system' database
		$update = "UPDATE `accounts` SET lat='".$_POST['latitude']."', lon='".$_POST['longtitude']."' WHERE token='".$_POST['token']."'";
		$upd_result = mysql_query($update) or die ("<b>Update of Lat & Long into Middleware System DB failed:</b> " . mysql_error());
		
		//procedure for link parsing
		
		$jsonRes = "{\"link\":\"http://blog.roteskreuz.at/helpstarsredaktionsblog/2013/01/21/sprachen-fairness-als-fremdwort/\"}";
		
		echo $jsonRes;
		
	} else {
		echo "Fehler: Bitte probieren Sie noch einmal.";
	}

	
	/* Free of resultsets */
	//mysql_free_result($upd_result);
	
	/* Closing DB connection */
	mysql_close($dbcnx);

?>
