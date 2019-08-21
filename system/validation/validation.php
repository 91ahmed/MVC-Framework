<?php

    /**
     * Validation 
     *
     * Simple PHP validation class .
     *
     * @author Ahmed Hassan
     */

	namespace System\Validation;
	
	class Validation 
	{
		/**
		 *	@var $request
		 */
		private $request;

		/**
		 *	@var $input
		 */
		private $input;
		
		/**
		 *	@var array $errors
		 */
		private $errors   = array();
		
		/**
		 *	@var array $messages
		 */
		private $messages = [
			'required'  => 'filed is required',
			'email'     => 'is not valid email address',
			'integer'   => 'should be integer',
			'float'     => 'should be float',
			'numeric'   => 'should be numeric',
			'regex'     => 'is not in valid format',
			'max'       => 'may not be greater than',
			'min'       => 'should be at least',
			'maxLength' => 'maximum length should be',
			'minLength' => 'minimum length should be',
			'confirm'   => 'confirmation does not match',
		];
		
		public function __construct () 
		{
			$this->request = $_REQUEST;
		}
		
		/**
		 *	Determin input name for validation
		 *
		 *	@param string $name
		 *	@return this
		 */
		public function input ($name) 
		{
			$this->input = $name;
			
			return $this;
		}

		/**
		 *	Check empty values
		 *
		 *	@return this
		 */
		public function required ()
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if ($this->request[$input] == '') {
					$this->errors[$input] = $input.' '.$this->messages['required'];
				}
			}
			
			return $this;
		}
		
		/**
		 *	Check if email address is valid or not
		 *
		 *	@return this
		 */
		public function email ()
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (!empty($this->request[$input]) && !filter_var($this->request[$input], FILTER_VALIDATE_EMAIL)) {
					$this->errors[$input] = $input.' '.$this->messages['email'];
				}
			}
			
			return $this;
		}
		
		/**
		 *	Check integer value
		 *
		 *	@return this
		 */
		public function integer ()
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (!empty($this->request[$input]) && !filter_var($this->request[$input], FILTER_VALIDATE_INT)) {
					$this->errors[$input] = $input.' '.$this->messages['integer'];
				}
			}
			
			return $this;	
		}
		
		/**
		 *	Check float value
		 *
		 *	@return this
		 */
		public function float ()
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (!empty($this->request[$input]) && !filter_var($this->request[$input], FILTER_VALIDATE_FLOAT)) {
					$this->errors[$input] = $input.' '.$this->messages['float'];
				}
			}
			
			return $this;	
		}
		
		/**
		 *	Check numeric value
		 *
		 *	@return this
		 */
		public function numeric ()
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (!empty($this->request[$input]) && !is_numeric($this->request[$input])) {
					$this->errors[$input] = $input.' '.$this->messages['numeric'];
				}
			}
			
			return $this;	
		}
		
		/**
		 *	Check if regular expression match or not
		 *
		 *	@param string $regex
		 *	@return this
		 */
		public function regex ($regex)
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (!empty($this->request[$input]) && !preg_match_all($regex, $this->request[$input])) {
					$this->errors[$input] = $input.' '.$this->messages['regex'];
				}
			}
			
			return $this;
		}
		
		/**
		 *	Check maximum value
		 *
		 *	@param integer $value 
		 *	@return this
		 */
		public function max ($value) 
		{
			$input = $this->input;
			$value = (int) $value;
			
			if (isset($this->request[$input])) {
				if ($this->request[$input] > $value) {
					$this->errors[$input] = $input.' '.$this->messages['max'].' '.$value;
				}
			}
			
			return $this;
		}
		
		/**
		 *	Check minimum value
		 *
		 *	@param integer $value
		 *	@return this
		 */
		public function min ($value)
		{
			$input = $this->input;
			$value = (int) $value;

			if (isset($this->request[$input])) {
				if ($this->request[$input] < $value) {
					$this->errors[$input] = $input.' '.$this->messages['min'].' '.$value;
				}
			}
			
			return $this;
		}
		
		/**
		 *	Check maximum string length
		 *
		 *	@param integer $value
		 *	@return this
		 */
		public function maxLength ($value)
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (mb_strlen($this->request[$input]) > $value) {
					$this->errors[$input] = $input.' '.$this->messages['maxLength'].' '.$value;
				}
			}
			
			return $this;
		}

		/**
		 *	Check minimum string length
		 *
		 *	@param integer $value
		 *	@return this
		 */
		public function minLength ($value)
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if (mb_strlen($this->request[$input]) < $value) {
					$this->errors[$input] = $input.' '.$this->messages['minLength'].' '.$value;
				}
			}
			
			return $this;
		}

		/**
		 *	Check if two inputs are the same values or not
		 *
		 *	@param string $confirmInputName
		 *	@return this
		 */
		public function confirm ($confirmInputName) 
		{
			$input = $this->input;
			
			if (isset($this->request[$input])) {
				if ($this->request[$input] !== $this->request[$confirmInputName]) {
					$this->errors[$input] = $input.' '.$this->messages['confirm'].' '.$input;
				}
			}
			
			return $this;
		}
		
		/**
		 *	Check if validation success
		 *
		 *	@return boolean
		 */
		public function success () 
		{
			if (count($this->errors) > 0 || !empty($this->errors)) {
				return false;
			} else {
				return true;
			}
		}

		/**
		 *	Get errors
		 *
		 *	@return void
		 */
		public function __destruct ()
		{
			if (count($this->errors) > 0) {

				header("HTTP/1.1 500 Internal Server Error");
		        header('Content-Type: application/json; charset=UTF-8');
		        exit(json_encode($this->errors));

			} else {

				header("HTTP/1.1 200 OK");
			}
		}

	}
	
?>