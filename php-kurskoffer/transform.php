<?php
	error_reporting(E_ALL);
	
	header('Content-type: application/json; charset=utf-8');
// 	header('Content-type: application/xml; charset=utf-8');
// 	header('Content-type: text/html; charset=utf-8');
	
	if ( isset($_POST['token']) ) {		
		
		$xml = new DOMDocument;
		$xml->load("http://localhost/moodle-2.5dev/webservice/rest/server.php?wstoken=".$_POST['token']."&wsfunction=core_course_get_contents&courseid=2");
		
		$xsl = new DOMDocument;
		$xsl->load("transform.xsl");
		
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
		echo $json;
		
	} else {
		echo "Error: can not identify the user token.";
	}
	
?>
