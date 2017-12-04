<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/utils.php');
$dbh = openDB();
if(is_string(filter_input(INPUT_POST, 'title')) &&
	is_string(filter_input(INPUT_POST, 'start')) &&
	is_string(filter_input(INPUT_POST, 'color'))){
	$title = filter_input(INPUT_POST, 'title');
	$start = filter_input(INPUT_POST, 'start');
	$color = filter_input(INPUT_POST, 'color');
	$stmt = $dbh->prepare('INSERT INTO calender (title,start,end,color) VALUES(:title,:start,:end,:color)');
	$stmt->bindParam(':title',$title);
	$stmt->bindParam(':start',$start);
	$stmt->bindParam(':color',$color);
	if(is_string(filter_input(INPUT_POST, 'end'))){
		$end = filter_input(INPUT_POST, 'end');
		$stmt->bindParam(':end',$end);
	}else{
		$stmt->bindParam(':end',null);
	}
	$stmt->execute();
}
?>
