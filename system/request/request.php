<?php
	
	namespace System\Request;

	class Request 
	{
		/**
		 * Determine whether a request is [ GET - POST ] .
		 *
		 * @param string $method
		 * 
		 * @return boolean
		 */
		public static function isMethod($method)
		{
			$request_method = $_SERVER['REQUEST_METHOD'];
			
			if ($request_method === strtoupper($method)) {
				return true;
			} else {
				return false;
			}
		}
		
		/**
		 * Return request method .
		 * 
		 * @return string
		 */
		public static function method()
		{
			return $_SERVER['REQUEST_METHOD'];
		}

		/**
		 * Determine if an input value is present on the request .
		 *
		 * @param string $input
		 *
		 * @return boolean
		 */
		public static function has($input)
		{	
			if (isset($_REQUEST[$input])) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Return the result from form data sent with GET method .
		 *
		 * @param string $input
		 * 
		 * @return string
		 */
		public static function get($input = null)
		{
			$_GET = self::clean($_GET);
			
			if ($input == '') {
				return $_GET;
			}
			return $_GET[$input];
		}
		
		/**
		 * Return the result from form data sent with POST method .
		 *
		 * @param string $input
		 * 
		 * @return string
		 */
		public static function post($input = null)
		{
			$_POST = self::clean($_POST);
			
			if ($input == '') {
				return $_POST;
			}
			
			return $_POST[$input];
		}
		
		/**
		 * Return the result from form data sent with both the GET and POST methods .
		 *
		 * @param string $input
		 * 
		 * @return string
		 */
		public static function input($input = null)
		{
			$_REQUEST = self::clean($_REQUEST);
			
			if ($input == '') {
				return $_REQUEST;
			}
			
			return $_REQUEST[$input];
		}

		/**
		 * Clean data from malicious code
		 *
		 * @param string $data
		 *
		 * @return mixed
		 */
		private static function clean($data)
		{
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					unset($data[$key]);
					$data[self::filter($key)] = self::filter($value);
				}
			} else {
				$data = self::filter($data);
			}
			
			return $data;
		}

		/**
		 * Shorthand method for filtering data .
		 *
		 * @param string $value
		 *
		 * @return string
		 */
		private static function filter($value)
		{
			if (is_array($value) || is_object($value)) {

				$value = array_map("strip_tags", $value);

			} else {

				$value = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
				$value = stripslashes($value);
				$value = filter_var($value, FILTER_SANITIZE_STRING);
				$value = trim($value, ' ');			
			}

			return $value;
		}
	}

?>