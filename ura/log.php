<?php
/**
 * ログ保存スクリプト
 * 参考：　http://forse.hatenablog.com/entry/2014/03/16/161539
 * Doc　：　http://php.net/manual/ja/reserved.variables.server.php
 */

// ランダム文字列生成
function randomStr($length = 8)
{
    return substr(base_convert(md5(uniqid()), 16, 36), 0, $length);
}

// スマホ判定
function checkUA(){
	$ua=$_SERVER['HTTP_USER_AGENT'];
	if((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false)) {
		return true;
	}
	return false;
}

function checkBOT(){
	if (preg_match('/bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
		return true;
	}
	return false;
}

if(empty($_COOKIE['access']) && checkBOT() === false){
	// ユーザ識別
	$logsession = '';
	if(empty($_COOKIE['logsession'])){
		$rs = randomStr();
		// なんかいろいろ面倒なのでハッシュにする
		$logsession = md5($rs);
		setcookie("logsession",$rs,time()+60*60*24);
	}else{
		// なんかいろいろ面倒なのでハッシュにする
		$logsession = md5($_COOKIE['logsession']);
	}

	//日付の取得
	$time=date("Y/m/d-H:i:s");
	//ＵＲＬの取得
	$requestUrl=$_SERVER['REQUEST_URI'];
	//リクエストメソッドの取得
	//$requestMethod=$_SERVER['REQUEST_METHOD'];
	//ブラウザ情報の取得
	$requestbrowser=checkUA() ? 'mb' : 'pc';//$_SERVER['HTTP_USER_AGENT'];
	//IPアドレス(ローカルでの::1は自分を示す)
	//$requestIpHashed=$_SERVER['REMOTE_ADDR'];
	//ホスト名を取得
	//$hostName=@gethostbyaddr($requestIp);
	//遷移元ページを取得
	$httpReferer=$_SERVER['HTTP_REFERER'];

	$log=$time.','.$requestUrl.','.$requestbrowser.','.$httpReferer.','.$logsession."\n";
	$fp=fopen('log.txt','a');
	fwrite($fp,$log);

	setcookie("access",1,time()+1);
}
