<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ELICENSE CAMBODIA.GOV.KH</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Website Template by gettemplates.co" />
	<meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
	<meta name="author" content="gettemplates.co" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />
	

	
	@include('frontend/layout/styleshop')


	</head>
	<body>
		
	<div class="gtco-loader"></div>
	
	<div id="page">
		
		@include('frontend/layout/header')

		@yield('header')
		{{-- @if (session('success'))
			<div class="alert alert-success" style="margin-bottom: 15px;">
				{{ session('success') }}
			</div>
		@endif --}}
		<div class="cintainer">

			@yield('content')
			
		</div>

	 {{-- Start footer     --}}

        @include('frontend.layout.footer')
        
        {{-- End footer --}}

	</div>

	<!-- Go To Top Button -->
	<div class="gototop js-top">
	<a href="#" class="js-gotop">
		<i class="fas fa-arrow-up"></i>
	</a>
	</div>

	@include('frontend/layout/jssshop')
	</body>
</html>

