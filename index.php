<?php
	ob_start();
	header ('Content-Type: text/html; charset=utf-8');
	
	define ('DS', DIRECTORY_SEPARATOR);
	define ('ROOT', __DIR__);
	
	/**	Require configuration file **/
    require_once (ROOT.DS.'system'.DS.'config.php');
	/**	Require helper functions **/
	require_once (ROOT.DS.'system'.DS.'helpers.php');
	/** Load Composer's autoloader **/
	require_once (ROOT.DS.'vendor'.DS.'autoload.php');
    /**	Require autoloader class **/
	require_once (ROOT.DS.'system'.DS.'autoload.php');

	$app = new System\App\App();

	/** Require routes file **/
    require_once (ROOT.DS.'routes'.DS.'web.php');
?>