<?php	
	$notificationFile = '/tmp/updateKurskoffer';
	$handle = fopen($notificationFile, 'w') or die('Cannot open file: ' . $notificationFile);
?>
<html>
	<head>
		<title>Update Status</title>
	</head>
	<body>
		Notification File: <?php echo $notificationFile; ?> was written, will be picked up in a minute.
	</body>
</html>