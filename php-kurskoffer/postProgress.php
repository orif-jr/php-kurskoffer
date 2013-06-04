<?php
	error_reporting(E_ALL);
	/* Connect to the database */
	include_once ("dbsettings.php");

	if ( isset($_POST['username']) && isset($_POST['chapter']) ){
		$sql = "select uid from accounts where login like '" . $_POST['username'] . "'";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		if($row) {
			$uid = $row['uid'];
			$sql = "select uid, chapter, pcount from progress where uid = " . $uid . " and chapter = " . $_POST['chapter'];
			error_log($sql);
			error_log(mysql_error());
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			if($row) {
				// update progress
				$pcount = $row['pcount'] + 1;
				$sql = "update progress set pcount = " . $pcount . " where uid = " . $uid . " and chapter = " . $_POST['chapter'];
				mysql_query($sql);
			}else{
				// insert progress
				$sql = "insert into progress (uid, chapter, pcount) values (" . $uid . ", " . $_POST['chapter'] . ", 1)";
				mysql_query($sql);
			}
		}
	}
	
	// no else path ... just ignore irregular posts
?>