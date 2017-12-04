<?php
$dbh;
$dsn = 'mysql:dbname=app;host=mysql';
$user = 'user';
$password = 'pass';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

echo "<br>Table list:<br>";
foreach($dbh->query("Show tables") as $row) {
	echo "$row[0]<br>";
}

echo "<br>Setting list:<br>";
foreach($dbh->query("Show variables") as $row) {
    echo "$row[0] : $row[1]<br>";
}
