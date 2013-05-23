<?php
  $dbhost="127.0.0.1";
  $dbusername="root";
  $dbpass="orif29";
  $dbname="kurskoffer";

  $dbcnx=@mysql_connect($dbhost, $dbusername, $dbpass);
  if (!$dbcnx) {
    exit("<p align='center'>Currently <b>Server</b> is not available</p><br><br><br><b>Could not connect to database:</b> " . mysql_error());
  }
  if (!@mysql_select_db($dbname, $dbcnx)) {
    exit("<p align='center'>Currently <b>Database</b> is not available</p>");
  }
  mysql_query('SET CHARSET utf8');
?>
