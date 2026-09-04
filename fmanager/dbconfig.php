<?php 
	// Pull cloud variables if on Render, fallback to local settings if not set
	$dbhost = getenv('DB_HOST')     ?: 'localhost';
	$dbport = getenv('DB_PORT')     ?: '3306'; // Uses standard port if empty
	$dbuser = getenv('DB_USERNAME') ?: 'root';
	$dbcode = getenv('DB_PASSWORD') ?: '';
	$dbname = getenv('DB_DATABASE') ?: 'pfm_db';

	// Connect using the specific port required by Aiven
	$conn = mysqli_connect($dbhost, $dbuser, $dbcode, $dbname, $dbport);
	
	if (!$conn) {
		die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	}
?>
