<?php
	
	namespace System\Session;

	use System\Encrypt\Encrypt;

	class Session
	{

		private $config = [
			'sess-name'     => 'sess',
			'sess-domain'   => 'localhost:8080', // URL [ .example.com ]
			'sess-lifetime' => 2678400, // expire in 30 days
			'sess-path'     => '/',
			'sess-ssl' 	    => false,
			'sess-http' 	=> true,
			'sess-handler'  => 'files',
			'sess-save' 	=> PATH_SESSION,
		];

	    public function __construct ()
	    {
	    	$this->config();
	    	$this->start();
	    }

	    /**
	     * Start new session
	     * @return void
	     */
		private function start ()
		{
			if (session_id() == '') {
				session_start();
			}
		}

		/**
		 * Session configuration
		 * @return void
		 */
		private function config ()
		{
			ini_set ('session.cookie_secure', 0);
			ini_set ('session.use_cookies', 1);
			ini_set ('session.use_only_cookies', 1);
			ini_set ('session.use_trans_sid', 0);
			ini_set ('session.cookie_httponly', 1);
			ini_set ('session.cookie_lifetime', $this->config['sess-lifetime']);
			ini_set ('session.gc_probability', 1);
			ini_set ('session.gc_divisor', 1000);
			ini_set ('session.gc_maxlifetime', $this->config['sess-lifetime']);
			ini_set ('session.save_handler', $this->config['sess-handler']);

			session_name($this->config['sess-name']);

			/*
			session_set_cookie_params(
				$this->config['sess-lifetime'],
				$this->config['sess-path'],
				$this->config['sess-domain'],
				$this->config['sess-ssl'],
				$this->config['sess-http']
			);
			*/

			session_save_path($this->config['sess-save']);
		}

		/**
		 * Set session data
		 *
		 * @param string $name
		 * @param string $value
		 * @return void
		 */
		public function set ($name, $value)
		{
			return $_SESSION[$name] = Encrypt::set($value);
		}

		/**
		 * Get session data
		 *
		 * @param string $name
		 * @return string
		 */
		public function get ($name)
		{
			return Encrypt::get($_SESSION[$name]);
		}

		/**
		 *	Destroy a particular session variable
		 *
		 *	@param string $name
		 *	@return void
		 */
		public function delete ($name)
		{
			unset($_SESSION[$name]);
		}

		/**
		 *	Destroy all the session data
		 *
		 *	@return void
		 */
		public function destroy ()
		{
			// unset all of the session variables
			$_SESSION = array();
			unset($_SESSION);

			// if it's desired to kill the session, also delete the session cookie
			// note: this will destroy the session, and not just the session data!
			if(ini_get("session.use_cookies")) 
			{
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}

			// destroy the session
			session_destroy();
		}
		
	}

?>