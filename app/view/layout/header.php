<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>MVC</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700&display=swap">
		<link rel="stylesheet" href="<?= asset('assets/css/all.min.css') ?>">
		<link rel="stylesheet" href="<?= asset('assets/css/jquery.toast.min.css') ?>">
		<link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?= asset('assets/css/nprogress.css') ?>">
		<link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>">
		<script>
			window.onload = function(){
				$(function(){
					NProgress.configure({ showSpinner: false });
					NProgress.start();
				});
				setTimeout(function(){ 
					NProgress.done();
				}, 2000);
			}			
		</script>
	</head>
	<body>

		<!-- Connection Error -->
		<div id="connection">
			<b><div class="loader"></div>Check your internet connection .</b>
		</div>