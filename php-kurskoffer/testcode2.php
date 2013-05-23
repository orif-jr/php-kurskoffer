<?php
	
	function readChapters($reader, &$topics_list) {
		while($reader->read()) {
			if($reader->name === "KEY" && $reader->getAttribute("name") === "name" && $reader->nodeType == XMLReader::ELEMENT) {
				$chapter = array();
				$chapter['title'] = readValue($reader);
				$topics_list[] = $chapter;
				print_r($topics_list);
				print ($chapter['title']). "<br />";
			}
			if($reader->name === "MULTIPLE" && $reader->nodeType == XMLReader::ELEMENT) {
				print('check');
				readModules($reader, $chapter);
			}
			if($reader->name === "SINGLE" && $reader->nodeType == XMLReader::END_ELEMENT) {
				return;
			}
		}
	}
	
	function readModules($reader, &$chapter) {
		$modules = array();
		while($reader->read()) {
			if($reader->name === "SINGLE") {
				readModule($reader, $modules);
			}
			if($reader->name === "MULTIPLE" && $reader->nodeType == XMLReader::END_ELEMENT) {
				$chapter['modules'] = $modules;
				return;
			}
		}
	}
	
	function readModule($reader, &$modules) {
		$topic = array();
		while($reader->read()) {
			if($reader->name === "KEY" && $reader->nodeType == XMLReader::ELEMENT && $reader->getAttribute("name") === "name") {
				$topic['title'] = readValue($reader);
// 				print ($topic). "<br />";
			}
			if($reader->name === "KEY" && $reader->nodeType == XMLReader::ELEMENT && $reader->getAttribute("name") === "description") {
				$topic['description'] = readValue($reader);
// 				print ($description). "<br />";
			}
// 			if($reader->name === "SINGLE" && $reader->nodeType == XMLReader::END_ELEMENT) {
// 				return;
// 			}
			if(isset($topic['title']) && isset($topic['description'])) {
				$modules[] = $topic;
			}
		}
		return;
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
				readChapters($reader, $topics_list);
				
				
			}
// 			$topics_list[$current] = array();
// 			$topics_list[$current]['chapter'] = readChapters($reader);
// 			$topics_list[$current]['topic'] = readModule($reader);
// 			$topics_list[$current]['content'] = readModule($reader);
		}
		$reader->close();
		print_r($topics_list);
		
// 		$json = json_encode($topics_list);
// 		echo "<br />". $json; 
		
	} else{
		echo "Can not identify the user!";
	}
		
		
	
	/* Closing DB connection */
	//mysql_close($dbcnx);

?>
