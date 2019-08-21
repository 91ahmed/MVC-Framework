<?php
	
	class Files
	{
		public $name;
		public $type;
		public $tmp_name;
		public $error;
		public $size;
		public $sizeBytes;
		public $extension;
		
		/**
		 * Check if input has file
		 *
		 * @param string $fileName
		 *
		 * @return boolean
		 */
		public function hasFile ($fileName)
		{
			if (isset($_FILES[$fileName])) {
				if ($_FILES[$fileName]['name'] !== '') {
					return true;
				}
			}
			return false;
		}
		
		/**
		 * Check if file is image
		 *
		 * @param string $fileName
		 *
		 * @return boolean
		 */
		public function isImage ($fileName)
		{
			$formats   = ['jpeg', 'jpg', 'gif', 'svg', 'png', 'webp'];
			$extension = strtolower($this->getFileExtension($fileName));
			
			if (in_array($extension, $formats)) {
				return true;
			}
			return false;
		}

		/**
		 * Get file name
		 *
		 * @param string $fileName
		 *
		 * @return string
		 */
		public function getFileName ($fileName)
		{
			$this->name = filter_var($_FILES[$fileName]['name'], FILTER_SANITIZE_STRING);
			return (string) $this->name;
		}
		
		/**
		 * Get file extension
		 *
		 * @param string $fileName
		 *
		 * @return string
		 */
		public function getFileExtension ($fileName)
		{
			$this->extension = strtolower(pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION));
			return (string) $this->extension;
		}

		/**
		 * Get file type
		 *
		 * @param string $fileName
		 *
		 * @return string
		 */
		public function getFileType ($fileName)
		{
			$this->type = filter_var($_FILES[$fileName]['type'], FILTER_SANITIZE_STRING);
			return (string) $this->type;
		}
		
		/**
		 * Get file tmp name
		 *
		 * @param string $fileName
		 *
		 * @return string
		 */
		public function getFileTmpName ($fileName)
		{
			$this->tmp_name = filter_var($_FILES[$fileName]['tmp_name'], FILTER_SANITIZE_STRING);
			return (string) $this->tmp_name;
		}
		
		/**
		 * Get file error number
		 *
		 * @param string $fileName
		 *
		 * @return integer
		 */
		public function getFileError ($fileName)
		{
			$this->error = filter_var($_FILES[$fileName]['error'], FILTER_SANITIZE_NUMBER_INT);
			return (int) $this->error;
		}
		
		/**
		 * Get file size with formate
		 *
		 * @param string $fileName
		 *
		 * @return string
		 */
		public function getFileSize ($fileName)
		{
			$this->size = filter_var($_FILES[$fileName]['size'], FILTER_SANITIZE_STRING);
			return (string) $this->formatSizeUnits($this->size);
		}
		
		/**
		 * Get file size with bytes
		 *
		 * @param string $fileName
		 *
		 * @return int
		 */
		public function getFileSizeBytes ($fileName)
		{
			$this->sizeBytes = filter_var($_FILES[$fileName]['size'], FILTER_SANITIZE_NUMBER_INT);
			return (int) $this->sizeBytes;
		}
		
		/**
		 * Formate file size units
		 *
		 * @param integer $bytes
		 *
		 * @return string
		 */
		private function formatSizeUnits ($bytes)
		{
			if ($bytes >= 1073741824) {
				$bytes = number_format($bytes / 1073741824, 2) . ' GB';
			} elseif ($bytes >= 1048576) {
				$bytes = number_format($bytes / 1048576, 2) . ' MB';
			} elseif ($bytes >= 1024) {
				$bytes = number_format($bytes / 1024, 2) . ' KB';
			} elseif ($bytes > 1) {
				$bytes = $bytes . ' bytes';
			} elseif ($bytes == 1) {
				$bytes = $bytes . ' byte';
			} else {
				$bytes = '0 bytes';
			}

			return $bytes;
		}
		
		/**
		 * Get image width
		 *
		 * @param string $fileName
		 * @param string $path (optional)
		 *
		 * @return integer
		 */
		public function getImageWidth ($fileName, $path = '') 
		{
			if ($this->isImage($fileName)) {
				$path  = $_FILES[$fileName]['tmp_name']; 
				$width = getimagesize($path);
				return (int) $width[0];
			}
		}
		
		/**
		 * Get image height
		 *
		 * @param string $fileName
		 * @param string $path (optional)
		 *
		 * @return integer
		 */
		public function getImageHeight ($fileName, $path = '') 
		{
			if ($this->isImage($fileName)) {
				$path   = $_FILES[$fileName]['tmp_name']; 
				$height = getimagesize($path);
				return (int) $height[1];	
			}
		}
		
		/**
		 * Upload file to server
		 *
		 * @param string $fileName
		 * @param string $path
		 * @param string $newName (optional)
		 *
		 * @return void
		 **/
		public function uploadFile ($fileName, $path, $newName = '')
		{
			$tmp_name = $this->getFileTmpName($fileName);
			
			if ($newName == '') {
				$newName = strtoupper(date('Ymd').'@'.md5(microtime()));
			}

			$path = trim($path, '\\');
			$path = trim($path, '/').DIRECTORY_SEPARATOR;
			
			$extension = $this->getFileExtension($fileName);

			move_uploaded_file($tmp_name, $path.$newName.'.'.$extension);
		}
		
		/**
		 * Remove file from server
		 *
		 * @param string $file
		 *
		 * @return void
		 **/
		public function removeFile ($file)
		{
			if (is_file($file) && file_exists($file)) {
				unlink($file);
			}	
		}
		
		/**
		 * Remove directory from server
		 *
		 * @param string $dirPath
		 *
		 * @return void
		 **/
		public function removeDir ($dirPath)
		{
			if (! is_dir($dirPath)) {
				throw new InvalidArgumentException("$dirPath must be a directory");
			}
			
			if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
				$dirPath .= '/';
			}
			
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					$this->removeDir($file);
				} else {
					unlink($file);
				}
			}
			
			rmdir($dirPath);
		}
		
		
		/**
		 * Make new directory
		 *
		 * @param string $name
		 * @param int $mode
		 *
		 * @return void
		 */
		public function makeDir($name, $mode = 0777)
		{
			if(!file_exists($name) && !is_dir($name)) {
				$name = filter_var($name, FILTER_SANITIZE_STRING);
				$mode = filter_var($mode, FILTER_SANITIZE_NUMBER_INT);
				mkdir($name, $mode);
			}
		}
	}
	
	/** 
		[usage]
		
		$file = new Files();
		
		if($file->hasFile('file'))
		{
			$name      = $file->getFileName('file');
			$type      = $file->getFileType('file');
			$size  	   = $file->getFileSize('file');
			$sizeBytes = $file->getFileSizeBytes('file');
			$tmp   	   = $file->getFileTmpName('file');
			$error     = $file->getFileError('file');
			$extension = $file->getFileExtension('file');
			$width     = $file->getImageWidth('file');
			$height    = $file->getImageHeight('file');
			
			$file->uploadFile('fileInputName', 'filePath', 'fileNewName (optional)');
		}
		
		$file->makeDir('C:\xampp\htdocs\test\haha');
		$file->removeDir('C:\xampp\htdocs\test\haha');
		$file->removeFile('C:\xampp\htdocs\test\img\file.jpg');
		
	**/
?>