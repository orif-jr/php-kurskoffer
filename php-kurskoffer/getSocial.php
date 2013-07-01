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
			
			// TODO rethink uid != uid.
			$sql = 'select firstname, badge_blue, badge_bronze, badge_silver, badge_gold, badge_green from accounts, badges where accounts.uid = badges.uid and where badges.uid != ' . $uid;
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			$data = array();
			while($row) {
				$current = array('firstname' => $row['firstname'], 'blue' => $row['badge_blue'], 'bronze' => $row['badge_bronze'], 'silver' => $row['badge_silver'], 'gold' => $row['badge_gold'], 'green' => $row['badge_green']);
				$data[] = $current;
				$row = mysql_fetch_assoc($result);
			}
			$json = json_encode($data);
			error_log($json);
			echo $json;
		}
	}
?>