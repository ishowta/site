<?php
include($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/lib/utils.php');

if(is_string($key = filter_input(INPUT_GET, 'key'))){
	$dbh = openDB();
	// keyが存在するかどうかチェック
	$stmt = $dbh->prepare('SELECT * FROM users WHERE register_string = :key');
	$stmt->bindParam(':key',$key);
	$stmt->execute();
	$match_db_count = $stmt->rowCount();
	if($match_db_count !== 1){
		echo '存在しないキーです。管理者に問い合わせてください。';
		exit();
	}
	if(is_string(filter_input(INPUT_POST, 'check'))){
		// 本登録(同時にキーの削除を行う)
		$stmt = $dbh->prepare('UPDATE users SET isactive=1, register_string=null WHERE register_string = :key');
		$stmt->bindParam(':key',$key);
		$stmt->execute();
		// メッセージ
		echo '登録が完了しました！<br>';
		echo '<a href="'.$_SERVER['DOCUMENT_ROOT'].'/">ログインページ</a>';
		exit();
	}else{
		$userdata = $stmt->fetch(PDO::FETCH_ASSOC);
		$username = $userdata['username'];
	}
}
?>
あなたは<?=$username?>でよろしいですか？
<form action="<?=$_SERVER["REQUEST_URI"]?>" method="post" accept-charset="utf-8">
<input type="hidden" name="check" value="ok">
<button>確認</button>
</form>
