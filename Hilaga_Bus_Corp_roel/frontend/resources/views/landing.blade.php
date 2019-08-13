@extends('layouts.app')

@section('title')
Landing Page
@endsection

@section('content')

<div class="container-fluid">
	<div class="row mt-5">
		<div class="col-md-6 offset-md-1" id="landingPic">
			<img src="{{ asset('images/landingbus.png') }}" id="imageLanding">
		</div>

		<div class="col-md-4" id="bookSlogan">
			<img src="{{ asset('images/booknow.png') }}" id="booknowTag">
			<h2>Your comfortable way of travelling north!</h2>
		</div>

	</div>
	<div id="roadPic">
		
	</div>



</div>

@endsection