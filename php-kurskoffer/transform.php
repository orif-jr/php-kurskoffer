<?php
	error_reporting(E_ALL);
	/* Connect to the database */
	include_once ("dbsettings.php");
	
	header('Content-type: application/json; charset=utf-8');
// 	header('Content-type: application/xml; charset=utf-8');
// 	header('Content-type: text/html; charset=utf-8');
	
	if ( isset($_POST['token']) && isset($_POST['courseid']) ) {	
		error_log('token ' . $_POST['token'] . ' was set .. accessing moodle');	
		
		$xml = new DOMDocument;
		$courseid = intval($_POST['courseid']);
		switch ($courseid) {
			case 1:
				// Rettung
				$courseid = 4;
				break;
			case 3:
				// Armenian
				$courseid = 3;
				break;
		}
		
		$xml->load("http://cloud.c3lab.tk.jku.at/moodle/webservice/rest/server.php?wstoken=".$_POST['token']."&wsfunction=core_course_get_contents&courseid=" . $courseid);
		error_log('xml content loaded');
		
		$xsl = new DOMDocument;
		$xsl->load("transform.xsl");
		error_log('xsl loaded');
		
		// configure the transformer
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl);
		
// 		echo $proc->transformToXML($xml);
		$new_xml = $proc->transformToXML($xml);
		
		/* Push the new formed XML document into JSON format */
		$xml2 = new SimpleXMLElement($new_xml);
		
		$current = 0;
		$topics_list = array();
		
		// put the xml values into multidimensional array
		
		foreach($xml2->children() as $data) {
			$topics_list[$current]['chapter'] = (string) $data->chapter;
			$topics_list[$current]['title'] = (string) $data->title;
			$topics_list[$current]['content'] = (string) $data->content;
			$current++;
		}
// 		print_r($topics_list);
		
		// convert to the JSON format
		$json = json_encode($topics_list);
		error_log($json);
		
		// now try to store the topic count to the database
		$sql = "select tcount from topics where courseid = " . $courseid;
		error_log($sql);
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		$tcount = $current;
		if($row) {
			// update progress
			$sql = "update topics set tcount = " . $tcount . " where courseid = " . $courseid;
			mysql_query($sql);
		}else{
			// insert progress
			$sql = "insert into topics (courseid, tcount) values (" . $courseid . ", " . $tcount . ")";
			mysql_query($sql);
		}
		
		echo $json;
	} else {
		echo "Error: can not identify the user token.";
	}
?>
