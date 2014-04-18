<?php
	$MOODLE = "http://cloud.c3lab.tk.jku.at/moodle/";
	$WS = "webservice/rest/server.php";
	$CONTENT = "webservice/pluginfile.php/";


	/**
	 * Improved version of the transform script that directly retrieves content from moodle
	 */
	error_reporting(E_ALL);
	header('Content-type: application/json; charset=utf-8');

	$token = $_POST['token'];
	$courseid = $_POST['courseid'];


	function fetchContent($url, $token) {
		$fetchurl = $url . "&token=" . $token;
		return file_get_contents($fetchurl);
	}

	function replace_files($content, $files) {
		foreach($files as $f) {
			$content = str_replace($f['filename'], $f['content'], $content);
		}
		return $content;
	}
	
	if (isset($_POST['token']) && isset($_POST['courseid']) ) {	
		$xml = new DOMDocument;
		$courseid = intval($_POST['courseid']);
		
		$xml->load("http://cloud.c3lab.tk.jku.at/moodle/webservice/rest/server.php?wstoken=".$_POST['token']."&wsfunction=core_course_get_contents&courseid=" . $courseid);
		$xsl = new DOMDocument;
		$xsl->load("transform3.xsl");
		
		// configure the transformer
		$proc = new XSLTProcessor;
		$proc->importStyleSheet($xsl);
		$new_xml = $proc->transformToXML($xml);

		/* Access the transformed XML for JSON conversion */
		$xml2 = new SimpleXMLElement($new_xml);
		
		$current = 0;
		$topics_list = array();
		
		// put the xml values into multidimensional array
		foreach($xml2->children() as $data) {
			$topics_list[$current]['id'] = (string) $data->id;
			$topics_list[$current]['chapter'] = (string) $data->chapter;
			$topics_list[$current]['title'] = (string) $data->title;
			$topics_list[$current]['description'] = (string) $data->description;

			$topics_list[$current]['content'] = null;
			if($data->urls && $data->urls->filename) {
				$len = count($data->urls->filename);
				$content = false;
				$embedded = array();
				for($i=0;$i<$len;$i++) {
					$filename = $data->urls->filename[$i];
					$url = $data->urls->url[$i];
					if($filename == 'index.html') {
						$content = fetchContent($url, $token);
					}else{
						$orig_content = fetchContent($url, $token);
						$base64_content = base64_encode($orig_content);
						$type = substr($filename, -3);
						$base64_img = 'data:image/' . $type . ';base64,' . $base64_content;
						array_push($embedded, array('filename'=>$filename, 'content'=>$base64_img));
					}
				}
				if($content) {
					$content = replace_files($content, $embedded);
					$topics_list[$current]['content'] = $content;	
				}
			}
			$current++;
		}
		// convert to JSON
		$json = json_encode($topics_list);
		echo $json;
	} else {
		echo "Error: can not identify the user token.";
	}
?>

