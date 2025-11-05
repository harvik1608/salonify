@extends('include.front_header')
@section('content')
<div class="bg-image bg-image-overlay" style="background-image: url({{ asset('website/images/login/pic1.jpg') }})"></div>
<div class="join-area">
	<div class="mb-3">
		<div class="swiper-container get-started">
			<div class="swiper-wrapper">
				@if($taglines)
					@foreach($taglines as $tagline)
						<div class="swiper-slide">
							<div class="started">
								<h1 class="title">{{ $tagline->title }}</h1>
								<p>{{ $tagline->description }}</p>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</div>
		<div class="swiper-btn">
			<div class="swiper-pagination style-1 flex-1"></div>
		</div>
	</div>
	<a href="{{ route('common.register') }}" class="btn btn-primary btn-block mb-3">SIGN UP</a>
	<a href="login.html" class="btn btn-light btn-block mb-3">SIGN IN</a>
	<a href="{{ route('common.forgot-password') }}" class="text-light text-center d-block">Forgot your account?</a>
</div>
@endsection