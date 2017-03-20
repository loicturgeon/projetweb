<?php
	//Ouvrir la session
	session_start();
	
	//Définition de variable
	define('ROOT', dirname(__FILE__));
	define('LIBS', str_replace("/index.php", "", $_SERVER['PHP_SELF']));
	define("INCLUDE_ONLY", "true");
	
	include ROOT."/config/config.php";
	include ROOT."/classes/manager.class.php";
	include ROOT."/classes/auth.class.php";
	
	//Trouve la bonne page selon URL
	if(isset($_GET['page'])){
		$context = isset($_GET['context']) ? $_GET['context']:"";
		$page = $_GET['page'];
		if(Manager::isPage($page, $context)){
			Manager::page($page, $context);
		} else {
			Manager::page(DEFAULT_ERROR);
		}
	} else {
		Manager::page(DEFAULT_PAGE);
	}
?>
