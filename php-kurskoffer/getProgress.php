<?php
	error_reporting(E_ALL);
	/* Connect to the database */
	include_once ("dbsettings.php");

	if ( isset($_POST['username']) ){
		$sql = "select uid from accounts where login like '" . $_POST['username'] . "'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		if($row) {
			$uid = $row['uid'];
			$sql = 'select count(*) scount from progress where uid = ' . $uid;
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			if($row) {
				$scount = $row['scount'];
				// TODO topic count hard coded!
				$progress = array('readTopics' => $scount, 'topicCount' => 19);
				error_log($progress);
				echo json_encode($progress);
			}
		}
	}
?>