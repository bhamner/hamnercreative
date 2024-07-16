@extends('layouts.public')
@section('title') 404 @stop
@section('content')

<div class="header-fullscreen" style="background: url({{ Vite::asset('resources/images/space-travel-loop.gif') }}); background-size: cover;">
	<div class="container">
        <div class="row">
			<main role="main" class="inner cover text-center pt-5 p-2">
		        <h1 class="cover-heading">404</h1>
		        <p class="lead">Sorry! We couldnt find that page. Please check the url.</p>
		        <p class="lead">
		          <a href="/" class="btn btn-lg btn-secondary">Go Home</a>
		        </p>
		    </main>
      	</div>
  	</div>
</div>

@endsection