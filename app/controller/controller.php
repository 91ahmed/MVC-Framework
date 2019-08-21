<?php
	
	namespace App\Controller;
	
	class Controller
	{
		protected function view ($view, $data = [])
		{
			$data = (object) $data; // Convert array to object
			$view = PATH_VIEW.$view.'.php';
			
			require ($view);
			ob_end_flush();
		}
	}
	
?>