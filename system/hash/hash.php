<?php

	namespace System\Hash;
	
	class Hash
	{	
		public static $algorithm = PASSWORD_BCRYPT;

		public static $options   = [
			'cost' => 12,
		];

		public static function data($text)
		{
			return password_hash($text, self::$algorithm, self::$options);
		}

		public static function verify()
		{

		}

	}

?>