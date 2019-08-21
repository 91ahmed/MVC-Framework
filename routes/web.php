<?php

	$route = new System\Routes\Route();
	
	$route->get('/', 'HomeController@index');
	$route->get('signup', 'UsersController@signup');
	$route->post('user/add', 'UsersController@add');
?>