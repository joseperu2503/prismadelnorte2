<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="es" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="https://i.postimg.cc/jj9jhhDj/prismaicono.png">
		<title>@yield('title')</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--<title> Drop Down Sidebar Menu | CodingLab </title>-->
		<link rel="stylesheet" href="{{asset('css/sidebar.css')}}">
		<!-- Boxiocns CDN Link -->
		<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="{{asset('css/colores.css')}}">
		<script src="https://kit.fontawesome.com/191a957bb7.js" crossorigin="anonymous"></script>
		@yield('css')  
		<link rel="stylesheet" href="{{asset('css/tablas.css')}}">  
	</head>
<body> 

	@yield('sidebar')

	<section class="home-section">   
		<main class="main">
			@yield('content')
		</main>
	</section>

	<script src="{{asset('js/sidebar.js')}}"></script>
	@yield('js')
</body>
</html>