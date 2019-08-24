<?php

	/** URL **/
	define ('URL', 'http://'.$_SERVER['HTTP_HOST'].'/mvc/');

	/** Database **/
	define ('DRIVER',   'mysql'); // [ mysql , pgsql , sqlsrv ]
	define ('HOST',     'localhost'); // [ localhost , 127.0.0.1 ]
	define ('DATABASE', 'mvc');
	define ('USERNAME', 'root');
	define ('PASSWORD', '');
	define ('PORT',     3306); // [ 5432 , 3306 ]
	define ('CHARSET',  'utf8');

	/** Mail **/
	define ('MAIL_HOST', 	  'smtp.gmail.com');
	define ('MAIL_PORT',       587);
	define ('MAIL_ENCRYPTION', 'tls');
	define ('MAIL_USERNAME',   'handersonnaser4010@gmail.com');
	define ('MAIL_PASSWORD',   "24882533");

	/** Paths **/
	define ('PATH_VIEW',    ROOT.DS.'app'.DS.'view'.DS);
	define ('PATH_SESSION', ROOT.DS.'storage'.DS.'sessions'.DS);
	define ('PATH_PUBLIC',  ROOT.DS.'public'.DS);
	define ('PATH_STORAGE', ROOT.DS.'storage'.DS);

	/** Errors **/
	ini_set ('display_errors', 1);
	error_reporting (E_ALL);

	/** Time zone **/
	ini_set ('date.timezone', 'Africa/Cairo');

	/** Charset **/
	ini_set ('default_charset', 'UTF-8');
	
	/** URL include **/
	ini_set ('allow_url_include', 0);
?>