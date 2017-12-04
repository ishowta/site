<?php
if(isset($_POST['username1']) && isset($_POST['username2']) &&
	$_POST['username1'] === $_POST['username2']){
	$raw_username = $_POST['username1'];
	if(preg_match('/^[a-z0-9](?:[a-z0-9-]{0,37}[a-z0-9])?\b$/i', $raw_username)){
		exec('curl -i -u "kinironote:godisdeadat0202" -X PUT -d \'\' \'https://api.github.com/repos/kinironote/8oti/collaborators/'.$raw_username.'\'');
		echo "okです。リンクに入ると404が出ますがそのままログインすればいけます";
		echo "<br><a href=\"https://github.com/kinironote/8oti\">github</a><br>";
	}else{
		echo "名前がおかしいです";
	}
}else{
?>

<font color="red">入力したアカウントがコラボレーターに追加されます。他人の名前をいれないように。</font>
<form action="./forkmeongithub.php" method="post">
	<input type="text" name="username1" placeholder="あなたのアカウント名"><br>
	<input type="text" name="username2" placeholder="あなたのアカウント名(確認)"><br>
	<button type="submit">参加</button>
</form>

<?php } ?>