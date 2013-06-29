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
			$sql = 'select count(*) scount from progress where uid = ' . $uid . ' and courseid = ' . $_POST['courseId'];
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			if($row) {
				$scount = $row['scount'];
				$sql = 'select tcount from topics where courseid = ' . $_POST['courseId'];
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row) {
					$topicCount = $row['tcount'];
				}else{
					// actually a bad error if the script reaches this state
					$topicCount = 100;
				}
				
				$sql = 'select uid, count(*) ocount from progress where uid != ' . $uid . ' and courseid = ' . $_POST['courseId'] . ' group by uid';
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				$countHigher = 0;
				$countLower = 0;
				$countSame = 0;
				while($row) {
					$ocount = intval($row['ocount']);
					if($ocount < $scount) {
						$countLower ++;
					}else if($ocount > $scount) {
						$countHigher ++;
					}else{
						$countSame ++;
					}
					$row = mysql_fetch_assoc($result);
				}
				
				$progress = array('readTopics' => $scount, 'topicCount' => $topicCount, 'countLower' => $countLower, 'countHigher' => $countHigher, 'countSame' => $countSame);
				$json = json_encode($progress);
				error_log($json);
				echo $json;
			}
		}
	}
?>