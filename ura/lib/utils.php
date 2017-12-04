<?php

function openDB(){
	include($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
	try{
		$pdo = new PDO('mysql:host='.$config['sql']['host'].';dbname='.$config['sql']['dbname'],$config['sql']['username'],$config['sql']['password']);
	}catch(PDOException $e) {
		exit('データベース接続失敗'.$e->getMessage());
	}
	return $pdo;
}

function random_str($length){
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
}

function getUserName(){
	$sid = $_COOKIE['sid'];
	$memcached = new Memcached();
	$memcached->addServer('memcached',11211);
	$user_data = json_decode($memcached->get($sid));
	return $user_data->username;
}
