<?php

	//logout.php
	
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/htmlUtils.php";
	require_once $_SERVER['DOCUMENT_ROOT'] . "/athena/www/utils/dbWorker.php";
	
	session_start();
	
	$_SESSION = array();
	
	session_destroy();
	
	if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
	}
	
	$htmlUtils = new htmlUtils();
	
	$htmlUtils->makeHeader();
	
	echo "Logout successful.";
	
	$htmlUtils->makeFooter();
	
?>