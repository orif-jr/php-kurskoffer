<?php
/*
// 	header('Content-type: application/json; charset=utf-8');
	header('Content-type: application/xml; charset=utf-8');
// 	header('Content-type: text/html; charset=utf-8');
	
	function curl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	$wiki = "http://de.wikipedia.org/w/api.php?action=query&list=allcategories&acprop=size&acprefix=haut&format=xml";
	$result = curl($wiki);
	var_dump($result);
*/
	
	
	

	// load Zend classes
	require_once 'Zend/Loader.php';
	Zend_Loader::loadClass('Zend_Rest_Client');
	
	// define category
	$cat = 'Greek_legendary_creatures';
	
	try {
		// initialize REST client
		$wikipedia = new Zend_Rest_Client('http://de.wikipedia.org/w/api.php');
		
		// set query parameters
		$wikipedia->action('query');
		$wikipedia->list('categorymembers');
		$wikipedia->cmtitle('Kategorie:'.$cat);
		$wikipedia->cmlimit('30');
		$wikipedia->format('xml');
		
		// perform request
		// iterate over XML result set
		$result = $wikipedia->get();
	} catch (Exception $e) {
		die('ERROR: ' . $e->getMessage());
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="format-detection" content="telephone=no" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Themen von Wiki</title>
        
		<link rel="stylesheet" href="kurskoffer.min.css" />
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile.structure-1.2.0.min.css" />
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	</head>
	<body>
		
		<div data-role="page" id="wikiPages" data-theme="a">
			<div data-role="header" data-position="inline">
				<h1>Themen von Wiki</h1>
				<a data-role="none" class="dummyBtn opacity" href="#"></a>
				<a data-role="none" class="aboutBtn opacity" data-transition="slide" href="#aboutPage"></a></div>
			<div data-role="content" data-theme="a">
				<!-- Content -->
				<h2>Suchergebnisse für Seiten in der Kategorie '<?php echo $cat; ?>'</h2>
				<ol>
					<?php foreach ($result->query->categorymembers->cm as $c): ?>
						<li><a href="http://www.wikipedia.org/wiki/
						<?php echo $c['title']; ?>">
						<?php echo $c['title']; ?></a></li>
					<?php endforeach; ?>
				</ol>
				<!-- /Content -->
			</div>
		</div>
		
	</body>
</html>