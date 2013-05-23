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
	
	if ( isset($_POST['username']) && isset($_POST['password']) ){
		
		$json1 = file_get_contents("http://localhost/moodle-2.5dev/login/token.php?username=".$_POST['username']."&password=".$_POST['password']."&service=my_service2");
		$data1 = json_decode($json1);
		
		$token = $data1->{"token"};
				
		// checking the user data in 'middleware system'
		$query = "SELECT `login`, `password`, `token` FROM `accounts` WHERE `login`='".$_POST['username']."'";
		$result = mysql_query($query) or die("<b>Query to Middleware System DB failed:</b> " . mysql_error());
		
		$row = mysql_fetch_assoc($result);
		
		// check if our mysql query is empty
		if ($row == false){
			// get user firstname and user id from moodle using 'core_webservice_get_site_info'
			$xml_obj = simplexml_load_file("http://localhost/moodle-2.5dev/webservice/rest/server.php?wstoken=".$token."&wsfunction=core_webservice_get_site_info");
			
			// retrieve firstname and user id
			$firstname = $xml_obj->SINGLE->KEY[2]->VALUE;
			$user_id = $xml_obj->SINGLE->KEY[6]->VALUE;
			
			//echo $firstname, $user_id; 
						
			// insert the data of new user 
			$insert = "INSERT INTO `accounts` VALUES ('".$user_id."', '".$_POST['username']."', '".$_POST['password']."', '".$firstname."', '".$token."', 'NULL', 'NULL')";
			$ins_result = mysql_query($insert) or die("<b>Insert of new User Data into Middleware System DB failed:</b> " . mysql_error());	
		}
		
		// checking 'password' and 'token' of the user
		if($row['password'] != $_POST['password'] || $row['token'] != $token){
			// update the user data: password and token in 'middleware system'
			$update = "UPDATE `accounts` SET password='".$_POST['password']."', token='".$token."' WHERE login='".$_POST['username']."'";
			$upd_result = mysql_query($update) or die ("<b>Update of User Data into Middleware System DB failed:</b> " . mysql_error());
		}
		
		echo $json1;
		
	}
	
	/* Free of resultsets */
	//mysql_free_result($result);
	//mysql_free_result($ins_result);
	//mysql_free_result($upd_result);
	
	/* Closing DB connection */
	mysql_close($dbcnx);

?>
