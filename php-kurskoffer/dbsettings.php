<?php
  $dbhost="127.0.0.1";
  $dbusername="root";
  $dbpass="root";
  $dbname="kurskoffer";

  $dbcnx=@mysql_connect($dbhost, $dbusername, $dbpass);
  if (!$dbcnx) {
  	error_log('could not establish database connection ' . mysql_error());
  }
  if (!@mysql_select_db($dbname, $dbcnx)) {
  	error_log('could not select mysql database ' . $dbname . ' due to ' . mysql_error());  
  }
  mysql_query('SET CHARSET utf8');
?>
