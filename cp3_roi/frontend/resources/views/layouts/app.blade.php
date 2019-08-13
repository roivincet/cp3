<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  	<link href="https://fonts.googleapis.com/css?family=Chivo|Righteous|Roboto&display=swap" rel="stylesheet">

  	{{-- crap datepicker --}}
{{-- 	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}

  	{{-- crap end datepicker --}}

  	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
  	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
  	{{-- datepicker css --}}
  	<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
  	
	{{-- <title>@yield('title', 'MELN')</title> --}}
	<title>r/Foundation</title>
</head>
<body>
	<nav class="navbar navbar-expand-md bg-info navbar-dark" id="navBar">

	</nav>
	





	@yield('content')
	
	{{-- run external js once content has loaded --}}
	<script src="{{ asset('js/scripts.js') }}"></script>
	{{-- datepicker js --}}
	<script src="{{ asset('js/jquery-ui.min.js') }}"></script>

</body>
</html>