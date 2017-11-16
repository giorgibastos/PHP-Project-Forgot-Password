<?php

	try {
		$pdo = new PDO("mysql:dbname=project_forgot-password;host=localhost;", "root", "");
	} catch(PDOException $e) {
		die($e->getMessage());
	}

?>