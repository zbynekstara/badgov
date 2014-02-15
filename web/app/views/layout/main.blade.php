<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Shoftak</title>
		<meta name="description" content="">
		<meta name="author" content="lenovo">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		
		<link rel="stylesheet" href="{{URL::route('home')}}/css/main.css" />
	</head>

	<body>
		<div>
			<header>
				@include("layout.navigation")
			</header>

			<div class="container">
				<div class="row">
					<div class="col-xs-7">
						@yield("content")
					</div>
					
					
				</div>
			</div>

			<footer>
				<p>
					&copy; Copyright  by Shoftak
				</p>
			</footer>
		</div>
	</body>
</html>
