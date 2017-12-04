<?php
function fetchAndDispRSS($RSSpath){
	$XML = simplexml_load_file ( $RSSpath );
	foreach ( $XML->channel->item as $entry ) {
		$title = $entry->title;
		$pubDate = $entry->pubDate;
		$pubDate = strftime("%Y-%m-%d %H:%M:%S", strtotime($pubDate));
		$link = $entry->link;
		echo "<li><a href=\"$link\" target=\"_blank\">$title</a></li>";
	}
}
?>

<script>
	//Tabの切り替え
	function ChangeTab(tabname) {
		// 全部消す
		documents = document.getElementsByClassName('tab');
		for(var i=0,len=documents.length;i<len;i++){
			documents[i].style.display = 'none';
		}
		// 指定箇所のみ表示
		document.getElementById(tabname).style.display = 'block';
	}
</script>

<div id="navi">
	<ul>
		<li><a onclick="ChangeTab('codezine');">CodeZine</a></li>
	</ul>
</div>
<ol class="rectangle-list">
	<div id="page">
		<div id="codezine" class="tab">
			<?php fetchAndDispRSS("http://rss.rssad.jp/rss/codezine/new/20/index.xml"); ?>
		</div>
	</div>
</ol>

<script>
ChangeTab('codezine');
</script>

<style type="text/css">
#navi ul {
	width: 100%;
	display: table;
	table-layout: fixed;
	text-align: center;
	cursor: default;
}

#navi li {
	display: table-cell;
	list-style: none;
	border-top: #FFF 1px solid;
	border-left: #FFF 1px solid;
	border-right: #CCC 1px solid;
	border-bottom: #CCC 1px solid;
}

#navi li a {
	display: block;
	font-size: 20px;
	line-height: 50px;
	text-align: center;
	text-decoration: none;
	background-color: #dcdcdc;
}

#navi li a:hover {
	background: white;
}

ol {
	counter-reset: li; /* Initiate a counter */
	list-style: none; /* Remove default numbering */
	*list-style: decimal; /* Keep using default numbering for IE6/7 */
	font: 15px 'trebuchet MS', 'lucida sans';
	padding: 0;
	margin-bottom: 4em;
	text-shadow: 0 1px 0 rgba(255,255,255,.5);
}

ol ol {
	margin: 0 0 0 2em; /* Add some left margin for inner lists */
}
.rectangle-list a{
	position: relative;
	display: block;
	padding: .4em .4em .4em .8em;
	*padding: .4em;
	margin: .5em 0 .5em 2.5em;
	background: #ddd;
	color: #444;
	text-decoration: none;
	transition: all .3s ease-out;
}

.rectangle-list a:hover{
	background: #eee;
}

.rectangle-list a:link:before{
	content: counter(li);
	counter-increment: li;
	position: absolute; 
	left: -2.5em;
	top: 50%;
	margin-top: -1em;
	background: #ffa500;
	height: 2em;
	width: 2em;
	line-height: 2em;
	text-align: center;
	font-weight: bold;
}


.rectangle-list a:visited:before{
	content: counter(li);
	counter-increment: li;
	position: absolute; 
	left: -2.5em;
	top: 50%;
	margin-top: -1em;
	background: #eee;
	height: 2em;
	width: 2em;
	line-height: 2em;
	text-align: center;
	font-weight: bold;
}

</style>
