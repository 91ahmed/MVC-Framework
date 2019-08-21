<?php
	
	namespace System\Model;

	use System\App\App;

	class Model
	{	
		/**
		 *	@var $query
		 */
		private static $query;
		
		/**
		 *	@var $data
		 */
		private static $data = [];
		
		/**
		 *	@var $table
		 */
		protected static $table;
		
		/**
		 *	Pagination
		 *
		 *	@var $page
		 *	@var $rows_at_page
		 */
		protected static $page = 1;
		protected static $rows_at_page;
		
		/**
		 *	Database instance
		 *
		 *	@var $database
		 */
		protected static $database;
		
		public static function db (array $connect = [])
		{
			if (!empty($connect) || count($connect) > 0) {
				self::$database = App::get('database')->connect($connect);
			} else {
				self::$database = App::get('database')->connect();
			}
			
			return self::$database;
		}
		
		/**
		 *	Build SELECT query.
		 *
		 *	@param string $columns
		 */
		public static function select ($columns)
		{
			self::$query = "SELECT ".$columns." FROM ".static::$table."";
			return new self;
		}
		
		/**
		 *	SELECT all query.
		 */
		public static function all ()
		{
			self::$query = "SELECT * FROM ".static::$table."";
			return new self;
		}
		
		/**
		 *	Add INNER JOIN.
		 *
		 *	@param string $table
		 *	@param string $column1
		 *	@param string $operator
		 *	@param string $column2
		 */
		public static function join ($table, $column1, $operator, $column2)
		{
			self::$query .= " INNER JOIN ".$table." ON ".$column1." ".$operator." ".$column2."";
			return new self;
		}
		
		/**
		 *	Add LEFT JOIN.
		 *
		 *	@param string $table
		 *	@param string $column1
		 *	@param string $operator
		 *	@param string $column2
		 */
		public static function leftJoin ($table, $column1, $operator, $column2)
		{
			self::$query .= " LEFT JOIN ".$table." ON ".$column1." ".$operator." ".$column2."";
			return new self;
		}
		
		/**
		 *	Add RIGHT JOIN.
		 *
		 *	@param string $table
		 *	@param string $column1
		 *	@param string $operator
		 *	@param string $column2
		 */
		public static function rightJoin ($table, $column1, $operator, $column2)
		{
			self::$query .= " RIGHT JOIN ".$table." ON ".$column1." ".$operator." ".$column2."";
			return new self;
		}
		
		/**
		 *	Add a WHERE condition.
		 *
		 *	@param string $columns
		 *	@param string $operator
		 *	@param string $value
		 */
		public static function where ($column, $operator, $value)
		{
			self::$query .= " WHERE ".$column." ".$operator." '".$value."'";
			return new self;
		}
		
		/**
		 *	Add OR operator.
		 *
		 *	@param string $columns
		 *	@param string $operator
		 *	@param string $value
		 */
		public static function or ($column, $operator, $value)
		{
			self::$query .= " OR ".$column." ".$operator." '".$value."'";
			return new self;
		}
		
		/**
		 *	Add AND operator.
		 *
		 *	@param string $columns
		 *	@param string $operator
		 *	@param string $value
		 */
		public static function and ($column, $operator, $value)
		{
			self::$query .= " AND ".$column." ".$operator." '".$value."'";
			return new self;
		}
		
		/**
		 *	Add a GROUPBY condition.
		 *
		 *	@param string $columns
		 */
		public static function groupBy ($columns)
		{
			self::$query .= " GROUP BY ".$columns."";
			return new self;
		}
		
		/**
		 *	Add a HAVING condition.
		 *
		 *	@param string $columns
		 *	@param string $operator
		 *	@param string $value
		 */
		public static function having ($column, $operator, $value)
		{
			self::$query .= " HAVING ".$column." ".$operator." '".$value."'";
			return new self;
		}
		
		/**
		 *	Add a ORDERBY constraint.
		 *
		 *	@param string $columns
		 *	@param string $order (optional)
		 */
		public static function orderBy ($columns, $order = 'DESC')
		{
			self::$query .= " ORDER BY ".$columns." ".$order."";
			return new self;
		}
		
		/**
		 *	Add a LIMIT constraint.
		 *
		 *	@param integer $number
		 */
		public static function limit ($number)
		{
			self::$query .= " LIMIT ".$number."";
			return new self;
		}
		
		/**
		 *	Build INSERT query.
		 *
		 *	@param array $data
		 */
		public static function insert (array $data)
		{
			// Set data
			self::$data = $data;
			
			// Insert query
			self::$query = "INSERT INTO " . static::$table . " SET ";
			foreach ($data as $column => $value) {
				self::$query .= $column . " = :" . $column . ", ";
			}
			self::$query = trim(self::$query, ', ');
			
			return new self;
		}
		
		/**
		 *	Build UPDATE query.
		 *
		 *	@param array $data
		 */
		public static function update (array $data)
		{
			// Set data
			self::$data = $data;
			
			// Update query
			self::$query = "UPDATE " . static::$table . " SET ";
			foreach ($data as $column => $value) {
				self::$query .= $column . " = :" . $column . ", ";
			}
			self::$query = trim(self::$query, ', ');
			
			return new self;
		}
		
		/**
		 *	Build DELETE query.
		 */
		public static function delete ()
		{
			self::$query = "DELETE FROM ".static::$table."";
			return new self;
		}
		
		/**
		 *	Execute query after [ insert - update - delete ] .
		 *
		 *	@return void
		 */
		public static function save ()
		{
			$query = (string) trim(self::$query, ' ');
			
			$stmt = self::db()->prepare($query);
			foreach (self::$data as $column => $value) {
				$stmt->bindValue(':'.$column, $value);
			}
			$stmt->execute();
		}
		
		/**
		 *	Write SQL query.
		 *
		 *	@param string $query
		 *
		 *	@return object
		 */
		public static function query ($query)
		{
			$stmt = self::db()->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}
		
		/**
		 *	Get the final query string.
		 *
		 *	@return object
		 */
		public static function get ()
		{
			$query = (string) trim(self::$query, ' ');
			$stmt  = self::db()->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}
		
		/**
		 *	Get pagination data.
		 *
		 *	@param integer $rows
		 *	
		 *	@return object
		 */
		public static function paginate ($rows)
		{
			if (isset($_GET['page'])) {
				self::$page = $_GET['page'];
			}
			
			self::$rows_at_page = $rows;
			
			$start = (self::$page - 1) * self::$rows_at_page;
			$end   = self::$rows_at_page;
			
			self::$query .= " LIMIT ".$start.", ".$end."";
			
			$query = (string) trim(self::$query, ' ');
			$stmt  = self::db()->prepare($query);
			$stmt->execute();
			
			return $stmt;
		}
		
		/**
		 *	Get pagination links.
		 *
		 *	@return integer
		 */
		public static function links ()
		{	
			$rows_count   = self::getRowsCount();
			$pages_counts = (int)ceil($rows_count / self::$rows_at_page);
			$links        = $pages_counts;

			return (int) $links;
		}
		
		/**
		 *	Get table rows count.
		 *
		 *	@return integer
		 */
		public static function getRowsCount ()
		{
			$tableRows = self::db()->prepare("SELECT * FROM ".static::$table."");
			$tableRows->execute();
			
			$rowsCount = $tableRows->rowCount();
			
			return (int) $rowsCount;
		}

	}

?>