<?php
	error_reporting(E_ALL);
	/* Connect to the database */
	include_once ("dbsettings.php");

	if ( isset($_POST['username']) && isset($_POST['courseId']) ){
		$sql = "select uid from accounts where login like '" . $_POST['username'] . "'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		if($row) {
			$uid = $row['uid'];
			$courseid = $_POST['courseId'];
			$sql = "select uid, courseid from badges where uid = " . $uid . " and courseid = " . $courseid;
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			if($row) {
				error_log('badges already stored no insert necessary');
			}else{
				$sql = "insert into badges (uid, courseid, badge_blue, badge_bronze, badge_silver, badge_gold, badge_green) values (" . $uid . ", " . $courseid . ", 0, 0, 0, 0, 0)";
				mysql_query($sql);
			}
			$sql = "update badges set badge_blue = " . $_POST['blue'] . ", badge_bronze = " . $_POST['bronze'] . ", badge_silver = " . $_POST['silver'] . ", badge_gold = " . $_POST['gold'] . ", badge_green = " . $_POST['green'] . " where uid = " . $uid . " and courseid = " .$courseid;
			mysql_query($sql);
		}
	}
	
	// no else path ... just ignore irregular posts
?>