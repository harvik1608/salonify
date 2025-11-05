<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, minimal-ui, viewport-fit=cover">
		<meta name="theme-color" content="#2196f3">
		<meta name="author" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="" />
		<meta name="description" content="" />
		<meta name="format-detection" content="telephone=no">

		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('website/images/favicon.png') }}" />
		<title>My Salonify</title>
		<link rel="stylesheet" href="{{ asset('website/vendor/swiper/swiper-bundle.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('website/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('website/vendor/wow/css/libs/animate.css') }}">
		<link rel="stylesheet" href="{{ asset('website/css/toast.css') }}">
		<link rel="stylesheet" href="{{ asset('custom.css') }}">

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
		<script src="{{ asset('website/js/jquery.js') }}"></script>
	</head>
	<body class="gradiant-bg">
		<div class="page-wraper">
			<div class="content-body">
				<div class="container vh-100">
					<div class="welcome-area">
						@yield('content')
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('website/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('website/vendor/wow/dist/wow.min.js') }}"></script>
		<script src="{{ asset('website/vendor/swiper/swiper-bundle.min.js') }}"></script>
		<script src="{{ asset('website/js/dz.carousel.js') }}"></script>
		<script src="{{ asset('website/js/settings.js') }}"></script>
		<script src="{{ asset('website/js/custom.js') }}"></script>
		<script src="{{ asset('website/js/toast.js') }}"></script>
		<script src="{{ asset('common.js') }}"></script>
		<script>
			new WOW().init();
			var wow = new WOW({
				boxClass:     'wow',
				animateClass: 'animated',
				offset:       50,
				mobile:       false
			});
		</script>
	</body>
</html>