@extends('include.front_header')
@section('content')
<div class="bg-image bg-image-overlay" style="background-image: url({{ asset('website/images/login/pic1.jpg') }})"></div>
<div class="join-area">
	<div class="started">
		<h1 class="title">Enter Code</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
	</div>
	<form action="https://soziety.dexignzone.com/xhtml/submit">
        <div method="get" id="otp" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
            <input class="form-control" type="text" id="digit-2" name="digit-2" placeholder="-" data-next="digit-3" data-previous="digit-1" />
            <input class="form-control" type="text" id="digit-3" name="digit-3" placeholder="-" data-next="digit-4" data-previous="digit-2" />
            <input class="form-control" type="text" id="digit-4" name="digit-4" placeholder="-" data-next="digit-5" data-previous="digit-3" />
            <input class="form-control" type="text" id="digit-5" name="digit-5" placeholder="-" data-next="digit-6" data-previous="digit-4" />
        </div>                
    </form>
	<div class="seprate-box mb-3">
		<!-- <a href="register.html" class="back-btn">
			<svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.40366 8L9.91646 2.58333L7.83313 0.499999L0.333132 8L7.83313 15.5L9.91644 13.4167L4.40366 8Z" fill="white"/>
			</svg>
		</a> -->
		<a href="change-password.html" class="btn btn-primary btn-block">NEXT</a>
	</div>
	<div class="d-flex align-items-center justify-content-center">
		<a href="javascript:void(0);" class="text-light text-center d-block">Don’t you recevied any code?</a>
		<a href="javascript:void(0);" class="btn-link d-block ms-2 text-underline">Resend</a>
	</div>
</div>
@endsection