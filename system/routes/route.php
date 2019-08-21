<?php
	
	namespace System\Routes;
	
	class Route
	{
		private $url;
		private $controller;
		private $action;
		private $routes = array();
		
		private $notFound   = 'errors/404.php';
		private $notAllowed = 'errors/405.php';
		
		/**
		 * Parse URL
		 */
		public function __construct ()
		{
			$this->url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
			$this->url = trim(str_replace($this->clearURL(), '', $this->url),'/');
			$this->url = filter_var($this->url, FILTER_SANITIZE_STRING);
			
			if ($this->url == '') {
				$this->url = '/';
			}
		}
		
		/**
		 *	GET request
		 *
		 *	@param string $route
		 *	@param string $pattern
		 *	@return this
		 */
		public function get ($route, $pattern)
		{
			$this->routes[] = $route;
			
			$pattern = explode('@', $pattern, 2);
			$this->controller = $pattern[0];
			$this->action     = $pattern[1];
			
			if ($route == $this->url) {
				if ($_SERVER['REQUEST_METHOD'] === 'GET') {
					$this->dispatch();
				} else {
					$this->notAllowed();
				}
			}
			
			return $this;
		}
		
		/**
		 *	POST request
		 *
		 *	@param string $route
		 *	@param string $pattern
		 *	@return this
		 */
		public function post ($route, $pattern) 
		{
			$this->routes[] = $route;
			
			$pattern = explode('@', $pattern, 2);
			$this->controller = $pattern[0];
			$this->action     = $pattern[1];
			
			if ($route == $this->url) {
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$this->dispatch();
				} else {
					$this->notAllowed();
				}
			}
			
			return $this;
		}
		
		/**
		 *	Create new instance from controller and run action
		 *	
		 *	@return void
		 */
		public function dispatch ()
		{
			if ($this->controller != '' && $this->action != '')
			{
				$controller  = '\\App\\Controller\\' . ucfirst($this->controller);
				$action = $this->action;
				
				$object = new $controller();
				$object->$action();
			}
		}
		
		private function clearURL ()
		{
			$dir = explode(DIRECTORY_SEPARATOR, ROOT);
			$dir = end($dir);
			$dir = strtolower($dir);
			
			return $dir;
		}
		
		private function notFound ()
		{
			require_once (PATH_VIEW.$this->notFound);
		}
		
		private function notAllowed ()
		{
			require_once (PATH_VIEW.$this->notAllowed);
		}
		
		public function __destruct ()
		{
			if (!in_array($this->url, $this->routes)) {
				$this->notFound();
			}
		}
		
	}
?>