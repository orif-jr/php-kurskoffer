<?php
	
	function readChapters($reader) {
		while($reader->read()) {
			if($reader->name === "KEY" && $reader->getAttribute("name") === "name" && $reader->nodeType == XMLReader::ELEMENT) {				
				print readValue($reader). "<br />";
			}
			if($reader->name === "MULTIPLE" && $reader->nodeType == XMLReader::ELEMENT) {
				print readModules($reader). "<br />";
			}
			if($reader->name === "SINGLE" && $reader->nodeType == XMLReader::END_ELEMENT) {
				return;
			}
		}
	}
	
	function readModules($reader) {
		while($reader->read()) {
			if($reader->name === "SINGLE") {
				print readModule($reader). "<br />";
			}
			if($reader->name === "MULTIPLE" && $reader->nodeType == XMLReader::END_ELEMENT) {
				return;
			}
		}
	}
	
	function readModule($reader) {
		while($reader->read()) {
			if($reader->name === "KEY" && $reader->nodeType == XMLReader::ELEMENT && $reader->getAttribute("name") === "name") {
				print readValue($reader). "<br />";
			}
			if($reader->name === "KEY" && $reader->nodeType == XMLReader::ELEMENT && $reader->getAttribute("name") === "description") {
				print readValue($reader). "<br />";
			}
// 			if($reader->name === "SINGLE" && $reader->nodeType == XMLReader::END_ELEMENT) {
// 				return;
// 			}
		}
	}
	
	function readValue($reader) {
		while($reader->read()) {
			if($reader->name === "VALUE" && $reader->nodeType == XMLReader::ELEMENT) {
				return $reader->readInnerXML();
			}
		}
	}
	
	
	
	error_reporting(E_ALL);
	
	/* Connect to the database */
	//include_once ("dbsettings.php");
	
	//header('Content-type: application/json; charset=utf-8');
	//header('Content-type: application/xml; charset=utf-8');
	header('Content-type: text/html; charset=utf-8');
		
	if (isset($_POST['token'])) {
		$reader = new XMLReader();
		$reader->open('http://localhost/moodle/webservice/rest/server.php?wstoken='.$_POST['token'].'&wsfunction=core_course_get_contents&courseid=2');
		
		$current = 0;
		$topics_list = array();
		
		while($reader->read()) {
			if($reader->name === "SINGLE" && $reader->nodeType == XMLReader::ELEMENT) {
				readChapters($reader);
			}
// 			$topics_list[$current] = array();
// 			$topics_list[$current]['chapter'] = readChapters($reader);
// 			$topics_list[$current]['topic'] = readModule($reader);
// 			$topics_list[$current]['content'] = readModule($reader);
		}
		$reader->close();
	} else{
		echo "Can not identify the user!";
	}
	
	/* Closing DB connection */
	//mysql_close($dbcnx);

?>
