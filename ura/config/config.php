<?php
$default_config = parse_ini_file('config/default_config.ini',true);
$user_config = parse_ini_file('config/user_config.ini',true);

$config = [];

foreach ($default_config as $set_key => $set_value) {
	foreach ($set_value as $key => $value) {
		$config[$set_key][$key] = isset($user_config[$set_key][$key]) ?
			$user_config[$set_key][$key]:
			$default_config[$set_key][$key];
	}
}
