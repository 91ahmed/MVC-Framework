<?php

	/**
	 *	Get URL
	 *
	 *	@param string $route
	 *	@return string
	 */
	function url ($route = '')
	{
		if ($route == '' || $route == '/') {
			return (string) URL;
		} else {
			$url = trim(URL, '/');
			$url = $url.'/'.trim($route, '/');

			return (string) $url;
		}
	}

	/**
	 *	Redirect URL
	 *
	 *	@param string $route
	 *	@return redirect
	 */
	function redirect ($route = '')
	{
		if ($route == '' || $route == '/') {
			return header ("Location:".URL);
			exit();
		} else {
			$url = trim(URL, '/');
			$url = $url.'/'.trim($route, '/');

			return header ("Location:".$url);
			exit();
		}
	}

	/**
	 *	Redirect URL to the previous page
	 *
	 *	@return redirect
	 */
	function redirectBack ()
	{
		$previousURL = $_SERVER['HTTP_REFERER'];

		return header ("Location:".$previousURL);
		exit();
	}

	/**
	 *	Get assets from public folder
	 *
	 *	@param string $file
	 *	@return string
	 */
	function asset ($file = '')
	{
		$public = URL.'public';
		$file = trim($file, '/');

		return (string) $public.'/'.$file; 
	}

	/**
	 *	Get template layout
	 *
	 *	@param string $view
	 */
	function layout ($view)
	{
		$view = trim($view, '/');
		$view = trim($view, '\\');
		$view = str_replace(['/','\\','.'], DS, $view);
		$view = PATH_VIEW.$view.'.php';
		
		require ($view);
	}

	/**
	 *	Get public folder path
	 *
	 *	@param string $path
	 *	@return string
	 */
	function publicPath ($path = '') 
	{
		if ($path != '') {
			$path   = ltrim($path, '/');
			$path   = ltrim($path, '\\');
			$path   = str_replace('/', DS, $path);
		}

		return (string) PATH_PUBLIC.$path;
	}

	/**
	 *	Get storage folder path
	 *
	 *	@param string $path
	 *	@return string
	 */
	function storagePath ($path = '') 
	{
		if ($path != '') {
			$path   = ltrim($path, '/');
			$path   = ltrim($path, '\\');
			$path   = str_replace('/', DS, $path);
		}

		return (string) PATH_STORAGE.$path;
	}

	/**
	 * 	Generate random characters .
	 *
	 * 	use -> random(128);
	 *
	 * 	@param integer $length
	 * 	@return string
	 */
	function randomChar ($length = 10)
	{
		$result    = "";
		$chars     = "abcdefghijklmnopqrstuvwxyz012345678911QWERTYUIOPLKJHGFDSAZXCVBNM9876543210";
		$charArray = str_split($chars);

		for ($i = 0; $i < $length; $i++) {
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}

		return (string) $result;
	}

	/**
	 * 	Generate random numbers
	 *
	 * 	use -> random_numbers();
	 * 	use -> random_numbers(20);
	 *
	 * 	@param integer $quantity
	 * 	@return integer
	 */
	function randomNum ($quantity = null) 
	{
		if ($quantity == null) {
			$quantity =  mt_rand(0,15);
		}

		$numbers = range(0, 500);
		shuffle($numbers);
		$numbers = implode('', $numbers);
		$numbers = substr($numbers, -($quantity));

		return $numbers;
	}

	/**
	 * 	Calculate price discount
	 * 
	 * 	@param integer $discount
	 * 	@param decimal $price
	 * 	@return decimal $totla;
	 */
	function discount ($discount, $price)
	{
		$equation = $discount*$price/100;
		$total    = $price-$equation;
		return $total;
	}

	/**
	 * 	Calculate age from a specified date .
	 *
	 * 	use -> age('1991-01-04'); // format YYYY-MM-DD
	 * 
	 * 	@param date $birthdate
	 *	@return integer
	 */
	function age ($birthdate)
	{
		list($year, $month, $day) = explode("-", $birthdate);
		
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;

		if ($month_diff < 0) {
			$year_diff--;
		} else if(($month_diff == 0) && ($day_diff < 0)) {
			$year_diff--;
		}

		return (int) $year_diff;
	}


	/**
	 *	Get the excerpt from text .
	 *
	 *	use -> excerpt($text, 0, 15);
	 *
	 *	@param string  $str
	 *	@param integer $startPos
	 *	@param integer $maxLength
	 *	@return string
	 */
	function excerpt ($str, $startPos = 0, $maxLength = 100)
	{
		if (strlen($str) > $maxLength) {
			$excerpt   = substr($str, $startPos, $maxLength-3);
			$lastSpace = strrpos($excerpt, ' ');
			$excerpt   = substr($excerpt, 0, $lastSpace);
			$excerpt  .= '...';
		} else {
			$excerpt = $str;
		}
		
		$excerpt = filter_var($excerpt, FILTER_SANITIZE_STRING);
		return (string) $excerpt;
	}
?>