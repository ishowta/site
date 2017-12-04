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
<a href="http://twitter.com/ishowta">Twitter</a><br>
<a href="https://github.com/kinironote">Github</a><br>
<a href="https://qiita.com/ishowta">Qiita</a><br>
<a href="https://www.flickr.com/photos/114770536@N05/">Flicker</a><br>
<a href="http://www.pixiv.net/member_illust.php?id=4706956">Pixiv</a><br>
Mail:ishowta@gmail.com<br>
<!--
<div class=app>
<img src="onlytweets.png"><br>
<a target="_blank" href="http://ux.getuploader.com/ishowta/download/1/onlytweets.zip">ツイートのみのTwitterクライアント</a><br>
</div>
-->
</body>
</html>
<!--
<style>
.app{
	border: 1px #000000 solid;
}
</style>
