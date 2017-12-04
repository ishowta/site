<?php
	ini_set("user_agent", "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
	$url = 'https://www.animenfo.com/radio/nowplaying.php';
	$options['ssl']['verify_peer']=false;
	$options['ssl']['verify_peer_name']=false;
	$html = file_get_contents($url, false, stream_context_create($options));
	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);
	$jacket_url = $xpath->query('//img[@class="art200"]')->item(0)->getAttribute('src');
	echo $jacket_url;
?>
