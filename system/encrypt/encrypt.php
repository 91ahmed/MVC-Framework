<?php

	/**
	 *	Class for data encryption using openssl extension
	 */
	
	namespace System\Encrypt;

	class Encrypt
	{
		/**
		 *	@var string $openssl_key
		 */
		private static $openssl_key    = 'bRuD5WYw5wd0rdHR9yLlM6XX2vteuUniQBqE70nAuhU9';

		/**
		 *	@var string $openssl_method
		 */
		private static $openssl_method = 'AES-256-CBC';

		/**
		 *	@var string $openssl_iv
		 */
		private static $openssl_iv     = '413149ee42cfcda5';

		/**
		 *	Encrypt data
		 *
		 *	@param string $value
		 *
		 * 	@return string
		 */
		public static function set ($value)
		{
			return openssl_encrypt($value, self::$openssl_method, self::$openssl_key, OPENSSL_RAW_DATA,self::$openssl_iv);
		}

		/**
		 *	Decrypt data
		 *
		 *	@param string $value
		 *
		 * 	@return string
		 */
		public static function get ($value)
		{
			return openssl_decrypt($value, self::$openssl_method, self::$openssl_key, OPENSSL_RAW_DATA, self::$openssl_iv);
		}
	}
	
?>