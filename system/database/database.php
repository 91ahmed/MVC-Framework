<?php

	namespace System\Database;
	
	/**
	 *	Class Database
	 *	Create a database connection using PDO
	 */
	class Database
	{	
		// @array, Database configuration
		private $config = [

			'driver'   => DRIVER,
			'host'     => HOST,
			'database' => DATABASE,
			'username' => USERNAME,
			'password' => PASSWORD,
			'port'     => PORT,
			'charset'  => CHARSET,
		];
			
		// @object, The PDO object
		private $pdo = null;
		
		// @array, PDO mysql options
		private $options = [
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
		];
			
		/**
		 * Return a PDO connection
		 * 
		 * @return PDO connection to the database
		 * @throws PDOException
		 * @throws Exception
		 */
		private function PDOconnection ()
		{
			try {

				if ($this->config['driver'] === 'mysql') {
					$this->pdo = new \PDO($this->config['driver'].":host=".$this->config['host'].";port=".$this->config['port'].";dbname=".$this->config['database'].";charset=".$this->config['charset']."", $this->config['username'], $this->config['password'], $this->options);
				} elseif ($this->config['driver'] === 'pgsql') {
					$this->pdo = new \PDO($this->config['driver'].":host=".$this->config['host'].";port=".$this->config['port'].";dbname=".$this->config['database']."", $this->config['username'], $this->config['password']);
				} elseif ($this->config['driver'] === 'sqlsrv') {	
					$this->pdo = new \PDO($this->config['driver'].":Server=".$this->config['host'].";Database=".$this->config['database']."", $this->config['username'], $this->config['password']);
				}
				
				// Set common attributes
				$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
				$this->pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);

			} catch(\PDOException $e) {

				exit($e->getMessage());  
			}

			return $this->pdo;
		}

		/**
		 * @param array $connect
		 *
		 * @return PDO connection to the database
		 */
		public function connect (array $connect = [])
		{	
			if (!empty($connect) || count($connect) != 0) {

				(isset($connect['driver'])   ? $this->config['driver']   = $connect['driver'] : '');
				(isset($connect['host'])     ? $this->config['host']     = $connect['host'] : '');
				(isset($connect['database']) ? $this->config['database'] = $connect['database'] : '');
				(isset($connect['username']) ? $this->config['username'] = $connect['username'] : '');
				(isset($connect['password']) ? $this->config['password'] = $connect['password'] : '');
				(isset($connect['port'])     ? $this->config['port']     = $connect['port'] : '');
				(isset($connect['charset'])  ? $this->config['charset']  = $connect['charset'] : '');
				(isset($connect['server'])   ? $this->config['server']   = $connect['server'] : '');
			}
			
			return $this->PDOconnection();
		}
		
	}

?>