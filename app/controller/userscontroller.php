<?php
	
	namespace App\Controller;

	use System\Request\Request;
	use System\Validation\Validation;
	use System\Hash\Hash;
	use App\Model\User;
	
	class UsersController extends Controller
	{
		public function signup ()
		{
			return $this->view('auth/signup');
		}

		public function add ()
		{
			// Data validation
			$val = new Validation();
			$val->input('username')->maxLength(20)->minLength(5)->required();
			$val->input('email')->maxLength(60)->email()->required();
			$val->input('password')->confirm('password_confirm')->maxLength(30)->minLength(8)->required();

			// Validation success
			if ($val->success())
			{
				// Insert data
				User::insert([
					'user_id'       => randomNum(12),
					'user_name'     => Request::input('username'),
					'user_email'    => Request::input('email'),
					'user_password' => Hash::data(Request::input('password')),
					'user_token'	=> randomChar(128),
				])->save();
			}
		}
	}
?>