<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Actor|Audiowide|Rock+Salt|Antic&display=swap" rel="stylesheet">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
  	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
  	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
  	
	<title>@yield('title', 'MELN')</title>
</head>
<body>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark" id="navBar">

	</nav>
	
	<section class="windowHeight">
	@yield('content')
	</section>


	<footer class="footer bg-dark text-light" id="footerHilaga">
		<div class="row m-0">
			<div class="col-md-3 offset-md-3 mt-3 p-0 text-md-right mr-4">
				<p><i class="fab fa-phoenix-framework"></i>Hilaga Bus Corp &copy; 2019</p>
				<p>Another Way to be King in the North!</p>
			</div>
			<div>
				<p class="mt-3">Follow Us:</p>
				<i class="fab fa-facebook-square fa-3x mr-2"></i>
				<i class="fab fa-instagram fa-3x mr-2"></i>
				<i class="fab fa-facebook-messenger fa-3x mr-2"></i>
				<i class="fab fa-twitter fa-3x mr-2"></i>
				<p class="mt-3">Email Your Concerns and Suggestions To: <br>
				<i>hilagabuscorpSuggestions@hilaga.com <br> hilacorpConcerns@hilaga.com</i></p>
			</div>
		</div>
	</footer>
	{{-- run external js once content has loaded --}}
	<script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>