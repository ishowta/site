<?php
	ini_set("user_agent", "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
	$url = 'http://itori.animenfo.com:443/';
	$html = file_get_contents($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$title = $dom->getElementsByTagName('b')->item(11)->nodeValue;
	echo $title;
?>