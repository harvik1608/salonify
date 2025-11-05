@extends('include.front_header')
@section('content')
<div class="bg-image bg-image-overlay" style="background-image: url({{ asset('website/images/login/pic1.jpg') }})"></div>
<div class="join-area">
	<div class="started">
		<h1 class="title">Sign Up</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
	</div>
	<form id="mainForm" method="POST" action="{{ route('common.signup') }}">
		@csrf
		<input type="hidden" name="role" value="{{ $role }}" />
		<div class="step-1">
			<div class="mb-3 input-group input-group-icon">
				<input type="text" class="form-control" placeholder="Your Name" name="name" id="name" />
			</div>
			<div class="mb-3 input-group input-group-icon">
				<input type="text" class="form-control" placeholder="Your Email" name="email" id="email" />
			</div>
		</div>
		<div class="step-2">
			<div class="mb-3 input-group input-group-icon">
				<select class="form-control" name="gender" id="gender">
					<option value="">Choose Gender</option>
					<option value="1">Female</option>
					<option value="2">Male</option>
					<option value="3">Other</option>
				</select>
			</div>
			<div class="mb-3 input-group input-group-icon">
				<input type="date" class="form-control" placeholder="Your DOB" name="dob" id="dob" />
			</div>
			<a href="forgot-password.html" class="btn-link d-block mb-3 text-end text-underline"><small>Why we take DOB?</small></a>
		</div>
		<div class="step-3">
			<div class="mb-3 input-group input-group-icon">
				<input type="text" class="form-control" placeholder="Your Mobile No." name="phone" id="phone" />
			</div>
			<div class="mb-3 input-group input-group-icon">
				<input type="text" class="form-control" placeholder="Your Password" name="password" id="password" />
			</div>
		</div>
		<button id="submitBtn" hidden>Submit</button>
	</form>
	<a href="javascript:;" id="nextBtn" class="btn btn-primary btn-block mb-3" onclick="next_step()">Next</a>
	<div class="d-flex align-items-center justify-content-center">
		<a href="javascript:;" class="text-light text-center d-block" onclick="previous_step('{{ route('common.register') }}')">Back</a>
	</div>
</div>
@endsection