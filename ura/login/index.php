<?php
// phpMyAdminから飛んできたら戻す
if(isset($_COOKIE['pmaAuth-1'])){
	header('Location: /phpMyAdmin/');
	exit();
}

require_once($_SERVER['DOCUMENT_ROOT'].'/lib/PHPMailer/PHPMailerAutoload.php');
include($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/lib/utils.php');

function send_mail_by_gmail($to, $subject, $body){
	include($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
	$smtp_user = $config['gmail']['smtp_user'];
	$smtp_password = $config['gmail']['smtp_password'];
	$sitename = $config['system']['sitename'];

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;
	$mail->CharSet = 'utf-8';
	$mail->SMTPSecure = 'tls';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->IsHTML(false);
	$mail->Username = $smtp_user;
	$mail->Password = $smtp_password;
	$mail->setFrom($smtp_user,$sitename);
	//$mail->From     = $fromaddress;
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);

	if( !$mail -> Send() ){
	    return 0;
	} else {
	    return 1;
	}
}

function validate_username($username){
	if(preg_match('/^[a-zA-Z0-9-_]{2,16}$/', $username)){
		return true;
	}else{
		return false;
	}
}

function validate_password($password){
	if(preg_match('/\A[a-z\d]{64,64}+\z/i', $password)){
		return true;
	}else{
		return false;
	}
}

function validate_email($email){
	$email = (string)$email;
	if(filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
		return true;
	}else{
		return false;
	}
}

function is_valid_post($key){
	return is_string(filter_input(INPUT_POST, $key));
}

//*****************************************************
$is_signin =	is_valid_post('type') &&
				filter_input(INPUT_POST, 'type') === 'signin' &&
				is_valid_post('username') &&
				is_valid_post('password');
$is_signup =	is_valid_post('type') &&
				filter_input(INPUT_POST, 'type') === 'signup' &&
				is_valid_post('username') &&
				is_valid_post('password') &&
				is_valid_post('email') &&
				is_valid_post('repassword');
$referer = (string)filter_input(INPUT_POST, 'referer');
if($is_signin){
	//*************************************************
	// Check input
	//
	// get input
	$input_username = filter_input(INPUT_POST, 'username');
	$input_password = filter_input(INPUT_POST, 'password');
	// verify
	$dbh = openDB();
	$stmt = $dbh->prepare('SELECT * FROM users WHERE username = :username AND isactive = 1');
	$stmt->bindParam(':username',$input_username);
	$stmt->execute();
	$verify_userdata = $stmt->fetch(PDO::FETCH_ASSOC);
	$db_provided_userid = $verify_userdata['id'];
	$db_provided_password = $verify_userdata['password'];
	if(!password_verify($input_password, $db_provided_password)){
		echo 'ログインに失敗しました。ユーザー名またはパスワードが間違っています。';
		exit();
	}
	// セッション用データの生成
	$sid = random_str(32);
	$session_db = array();
	$session_db['userid'] = $db_provided_userid;
	$session_db['username'] = $input_username;
	// セッション登録
	setcookie('sid', $sid,2147483647,'/');
	$memcached = new Memcached();
	$memcached->addServer('memcached',11211);
	$memcached->set($sid,json_encode($session_db));
	header('Location: '.htmlspecialchars($referer));
}elseif($is_signup){
	//**************************************************
	// Check input
	//
	// get input
	$raw_username = filter_input(INPUT_POST, 'username');
	$raw_password = filter_input(INPUT_POST, 'password');
	$raw_email = filter_input(INPUT_POST, 'email');
	$raw_repassword = filter_input(INPUT_POST, 'repassword');
	// validate
	if($raw_password !== $raw_repassword){
		echo '1つ目のパスワードと2つ目のパスワードが違います';
		exit();
	}
	if(!validate_username($raw_username)){
		echo 'ユーザー名に使用できるのは2文字以上16文字以内の英数字、「-」、「_」のみです。';
		exit();
	}
	if(!validate_password($raw_password)){
		echo 'パスワードが不正です。';
		exit();
	}
	if(!validate_email($raw_email)){
		echo '正しいメールアドレスを入力してください';
		exit();
	}
	// ホワイトリストにメールアドレスが存在するかチェック
	//$whitelist = file($_SERVER['DOCUMENT_ROOT'].'/config/email_whitelist.txt', FILE_IGNORE_NEW_LINES);
	//$isWhitelisted = false;
	//foreach ($whitelist as $white_email) {
	//	if($raw_email === $white_email) $isWhitelisted = true;
	//}
	//if(!$isWhitelisted){
	//	echo 'このメールアドレスはホワイトリストに登録されていません。指定されたメールアドレスを入力してください。';
	//	exit();
	//}
	// check username duplicate
	$dbh = openDB();
	$stmt = $dbh->prepare('SELECT * FROM users WHERE username=:username');
	$stmt->bindParam(':username',$raw_username);
	$stmt->execute();
	$match_db_count = $stmt->rowCount();
	if($match_db_count !== 0){
		echo 'そのユーザー名は既に使用されています。';
		exit();
	}
	// hashed password
	$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
	//***************************************************
	// Register
	//
	$username = $raw_username;
	$display_username = htmlspecialchars($username);
	$password = $hashed_password;
	$email = $raw_email;
	$register_string = random_str(32);
	$register_url = 'https://'.$config['system']['sitename'].'/login/register.php?key='.$register_string;
	// insert into DB
	$dbh = openDB();
	$stmt = $dbh->prepare('INSERT INTO users (username,email,password,register_string) VALUES (:username, :email, :password, :register_string)');
	$stmt->bindParam(':username',$username);
	$stmt->bindParam(':email',$email);
	$stmt->bindParam(':password',$password);
	$stmt->bindParam(':register_string',$register_string);
	$stmt->execute();

	// send e-mail
	if(!send_mail_by_gmail($email,'確認メール',$display_username.'さん。以下のurlにアクセスして登録を完了させてください。 '.$register_url)){
		echo 'メールの送信に失敗しました。管理者に問い合わせてください。';
	}else{
		echo '仮登録が完了しました。メールを確認してください。';
	}
}else{ ?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/login/css/login.css">
	<script
  src="/login/javascript/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
	<script src="https://code.createjs.com/createjs-2015.11.26.min.js"></script>
	<title>8oti.com</title>
</head>
<body class="login">
<div class="ovbody">
<center>
	<form id="login_form" action="/login/index.php" method="post">
		<!-- http://codepen.io/clintioo/pen/FKymj -->
		<fieldset>
			<!-- Entypo &#128100; = User -->
			<input type="hidden" name="type" id="type" value="">
			<input type="hidden" name="password" value="">
			<input type="hidden" name="referer" value="">
			<input type="text" name="username" id="username" placeholder="Username" pattern="^[a-zA-Z0-9-_]{2,16}$" data-validation-msg="Username must be 2 - 16 characters" required />
			<label for="username" data-icon="&#128100;">Username</label>
			<!-- Entypo &#128274; = Locked -->
			<input type="password" name="pre_password" id="password" placeholder="Password" pattern="^[a-zA-Z0-9-_\.]{8,60}$" data-validation-msg="Password must be 8 - 60 characters" required />
			<label for="password" data-icon="&#128274;">Password</label>
			<div id="register">
				<input type="hidden" name="repassword" value="">
				<input type="email" name="email" id="email" placeholder="E-mail Address" data-validation-msg="e-mail invalid" />
				<label for="email" data-icon="&#x2709;">Email</label>
				<input type="password" name="pre_repassword" id="repassword" placeholder="retype Password" pattern="^[a-zA-Z0-9-_\.]{8,60}$" data-validation-msg="Password must be 8 - 60 characters" />
				<label for="repassword" data-icon="&#128274;">Password</label>
			</div>
			<!-- Entypo &#58542; = Right Arrow -->
			<button value="Submit" data-icon="&#58542;" />
		</fieldset>
	</form>
	<button id="signup_button">あSignup</button>
</center>
<img id="waterroad" src="/login/image/waterroad.png">
<div class="gif-world-wrapper">
	<canvas id="gif-world"></canvas>
</div>
<script type="text/javascript" src="/login/javascript/jsSHA/src/sha256.js"></script>
<script src="/login/javascript/login.js" type="text/javascript" charset="utf-8" async defer></script>
<script src="/login/javascript/gifworld.js" type="text/javascript" charset="utf-8" async defer></script>
</div>
</body>
</html>

<?php } ?>
