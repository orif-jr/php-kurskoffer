<?php
	error_reporting(E_ALL);
	
	/* Connect to the database */
	//include_once ("dbsettings.php");
	
	header('Content-type: application/json; charset=utf-8');
// 	header('Content-type: application/xml; charset=utf-8');
// 	header('Content-type: text/html; charset=utf-8');
	
	if ( isset($_POST['token']) ){
		
		// SimpleXML call by url with user token
		$xml_url = simplexml_load_file("http://localhost/moodle/webservice/rest/server.php?wstoken=".$_POST['token']."&wsfunction=core_course_get_contents&courseid=2");
		 
		//$xml_elem_attr = 'MULTIPLE/SINGLE/KEY[@name="name"]';
		$data = $xml_url->xpath('MULTIPLE/SINGLE/KEY');
// 		foreach($chapters as $chap_name) {
// 			printf("%s \n", $chap_name->VALUE);
// 		}
		
		$current = 0;
		$topics_list = array();
				
		//display list of 'chapters'
		foreach($data as $chap_name) {
			if ($chap_name['name'] == 'name') {
 				echo $chap_name->VALUE . '<br />';
				$topics_list[$current]['chapter'] = (string) $chap_name->VALUE;
			}
		}
		
		$data2 = $xml_url->xpath('MULTIPLE/SINGLE/KEY[@name="modules"]/MULTIPLE/SINGLE/KEY');
		
		//display list of 'topics' & 'contents'
		foreach($data2 as $topic_name) {
			if ($topic_name['name'] == 'name') {
// 				echo $topic_name->VALUE . '<br />';
				$topics_list[$current]['topic'] = (string) $topic_name->VALUE;
			}
			if ($topic_name['name'] == 'description') {
// 				echo $topic_name->VALUE . '<br />';
				$topics_list[$current]['content'] = (string) $topic_name->VALUE;
				$current ++;
			}
		}		
// 		print_r($xml_url);
		print_r($topics_list);
		
		//convert to the json format
// 		$json = json_encode($topics_list);
// 		echo $json;
	} else {
		echo "Error: could not retrieve list of 'topic names'";
	}
	
	/* Closing DB connection */
	//mysql_close($dbcnx);
	
?>





$xml = new DOMDocument;
$xml->load(get_bloginfo('template_directory') . '/rentals/works.xml');

$xsl = new DOMDocument;
$xsl->load(get_bloginfo('template_directory') . '/rentals/works.xsl');

$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl);

echo $proc->transformToXML($xml);