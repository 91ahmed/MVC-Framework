<?php

	/**
	 * autoload function for registration with spl_autoload_register
	 *
	 * @param string $className The fully-qualified class name.
	 * @return void
	 */
	spl_autoload_register( function ($className) {

		$class = ROOT . DS . strtolower($className) . '.php';
		$class = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $class);

		if (file_exists($class) && is_file($class)) {
			require ($class);
		}

	});
	
?>