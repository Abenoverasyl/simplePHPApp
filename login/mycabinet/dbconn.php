<?php 

	@header('Content-type: text/html; charset=UTF-8');
	@session_start();
	$host='localhost';
	$db='ps.diplom';
	$user='root';
	$password='';
	$host_web = "";

	$IsLocalhost = FALSE;

	try {
		$PDOdb = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
	} catch(PDOException $e) {
		die("Error: ".$e->getMessage());
	}

	$PDOdb -> query("SET CHARACTER SET cp1251");
	$error_array = $PDOdb->errorInfo();
	if($PDOdb->errorCode() != 0000) {
		echo "SQL: " . $error_array[2] . '<br /><br />';
	}
 ?>