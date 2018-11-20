<?php

	//remove before flight
	ini_set('display_errors', 'On');
		
	require 'database.php';

	try {
		$pdo = new PDO($DB_DSN_FIRST, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'CREATE DATABASE IF NOT EXISTS db_camagru';
		$pdo->exec($sql);
	}
	catch (Exception $e)
	{
		die('Error: '.$e->getMessage());
	}	

	try
	{
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS `users` (
			`user_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`login` VARCHAR(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
			`password` VARCHAR(255) NOT NULL,
			`email` VARCHAR(255) NOT NULL,
			`date_created` DATETIME NOT NULL,
			`confirmed` BOOLEAN DEFAULT 0 NOT NULL,
			`token` VARCHAR(255),
			`token_expires` DATETIME
		)";
		$pdo->exec($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `pictures` (
			`pic_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`login` VARCHAR(30) NOT NULL,
			`date_created` DATETIME NOT NULL,
			`pic` LONGBLOB NOT NULL
		)";
		$pdo->exec($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `likes` (
			`like_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`pic_id` INT UNSIGNED NOT NULL,
			`login` VARCHAR(30) NOT NULL,
			`date_created` DATETIME NOT NULL
		)";
		$pdo->exec($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS `comments` (
			`comment_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			`pic_id` INT UNSIGNED NOT NULL,
			`comment` VARCHAR(255) NOT NULL,
			`login` VARCHAR(30) NOT NULL,
			`date_created` DATETIME NOT NULL
		)";
		$pdo->exec($sql);
	}
	catch (PDOException $e)
	{
		die('Error: '.$e->getMessage());
	}

	$pdo = null;

?>

<!--<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Page Title</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" media="screen" href="main.css" />
	<script src="main.js"></script>
</head>
<body>
	
</body>
</html>>-->