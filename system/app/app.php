<?php
	
	namespace System\App;

	class App
	{
        /**
         *  The classes listed here will be automatically loaded on the
         *  request to your application.
         */
        private $classes = [
            'session'  => 'System\Session\Session',
            'database' => 'System\Database\Database',
        ];

        /**
         * @var array $_registry
         */
        protected static $_registry = array();

        public function __construct ()
        {
            $this->classes();
        }

        /**
         * @param string $key
         * @param mixed  $value
         *
         * @return void
         */
        public static function set ($key, $value)
        {
            if (isset(self::$_registry[$key])) {
                throw new Exception('There is already an entry for key ' . $key);
            }
            return self::$_registry[$key] = $value;
        }
        
        /**
         * @param string $key
         *
         * @return mixed
         */
        public static function get ($key) 
        {
            if (!isset(self::$_registry[$key])) {
                throw new Exception('There is no entry for key ' . $key);
            }
            return self::$_registry[$key];
        }

        private function classes ()
        {
            foreach ($this->classes as $key => $value) {
                self::set($key, new $value);
            }
        }

	}
?>