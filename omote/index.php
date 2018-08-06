<?php
// phpMyAdminから飛んできたら戻す
if(isset($_COOKIE['pmaAuth-1'])){
        header('Location: /phpMyAdmin/');
        exit();
}
?>

<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<div class=header>
	<a href="ura/">ura saito</a>
</div>
<a href="http://twitter.com/ishowta">Twitter</a><br>
<a href="https://github.com/kinironote">Github</a><br>
<a href="https://qiita.com/ishowta">Qiita</a><br>
<a href="https://www.flickr.com/photos/114770536@N05/">Flicker</a><br>
<a href="http://www.pixiv.net/member_illust.php?id=4706956">Pixiv</a><br>
<a href="mailto:ishowta@gmail.com">Mail</a><br>
<br>
<div class=app>
作ったアプリ：
<!--
<img src="onlytweets.png"><br>
<a target="_blank" href="http://ux.getuploader.com/ishowta/download/1/onlytweets.zip">ツイートのみのTwitterクライアント</a><br>
-->
</div>

</body>
</html>
<style>
.header{
	text-align: right;
	background-color: #333;
}
.header a:link, .header a:visited{
	color: #eee;
}
.app{
	border: 1px #000000 solid;
}
</style>
