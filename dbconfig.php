<?php 
	DEFINE("DB_USER", "root");
	DEFINE("DB_PASS", "");

	try {
		$db = new PDO("mysql:host=localhost;dbname=gigastore", DB_USER, DB_PASS);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>