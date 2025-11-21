@extends('frontend/layout/master')

@section('header')
    <header id="gtco-header" class="gtco-cover" role="banner" style="background-image:url('{{ asset('frontend/assets/images/Header-bg1.jpg') }}');background-repeat: no-repeat;background-size: cover;background-position: center;">
				<div class="overlay"></div>
				<div class="gtco-container">
					<div class="row">
						<div class="col-md-12 col-md-offset-0 text-left">
							<div class="display-t">
								<div class="display-tc">
									<h1 class="animate-box" data-animate-effect="fadeInUp">Register, Renew, and Manage Your Driver’s License Online</h1>
									<h2 class="animate-box" data-animate-effect="fadeInUp">Welcome to Cambodia’s official online platform for driver’s license services. 
										Whether you're a new applicant or an 
														existing license holder, our all-in-one system is designed to simplify your journey.</h2>
									<p class="animate-box" data-animate-effect="fadeInUp"><a href="{{route('login')}}" class="btn btn-white btn-lg btn-outline">Start Now</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
	</header>
@endsection
 
 
@section('title', 'Home' )
@section('Home_avtive', 'active')
@section('content')

 
			
			<div id="gtco-features-3">
				<div class="gtco-container">
					<div class="gtco-flex">
						<div class="feature feature-1 animate-box" data-animate-effect="fadeInUp">							
							<div class="feature-inner">
								<span class="icon">
									<i class="fa-solid fa-arrows-spin"></i>
								</span>
								<h3>Renew</h3>
								<p>Renew your expired or soon-to-expire driver’s license quickly and conveniently—no need to wait in line or visit a government office. Our online renewal system is secure, simple, and saves you time.</p>
								<p><a href="{{route('renew')}}" class="btn btn-white btn-outline">Learn More</a></p>
							</div>
						</div>
						<div class="feature feature-2 animate-box" data-animate-effect="fadeInUp">
							
							<div class="feature-inner">
								<span class="icon">
									<i class="fa-solid fa-file-lines"></i>
								</span>
								<h3>Book Test</h3>
								<p>Easily schedule your driver’s license exam online—choose the time and test center that works best for you.</p>
								<p><a href="{{ route('booktest') }}" class="btn btn-white btn-outline">Learn More</a></p>
							</div>
						</div>
						<div class="feature feature-3 animate-box" data-animate-effect="fadeInUp">
							<div class="feature-inner">
								<span class="icon">
									<i class="fa-solid fa-circle-plus"></i>
								</span>
								<h3>Register</h3>
								<p>Applying for your first driver’s license has never been easier. Our online registration system guides you through every step — from account creation to exam booking — without needing to visit the office in person. </p>
								<p><a href="{{ route('checkstatus') }}" class="btn btn-white btn-outline">Learn More</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="gtco-features">
				<div class="gtco-container">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
							<h2>Fast & Simple Driver’s License Services Online</h2>
							<p>Welcome to Cambodia’s official online platform for driver’s license services. Whether you're a new applicant or an existing license holder, our all-in-one system is designed to simplify your journey.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="feature-center animate-box" data-animate-effect="fadeIn">
								<span class="icon">
									<i class="fas fa-user-plus"></i>
								</span>
								<h3>Register for a New Driver’s License</h3>
								<p>Applying for your first driver’s license has never been easier. Our online registration system guides you through every step — from account creation to exam booking — without needing to visit the office in person. </p>
							</div>
						</div>

						<div class="col-md-3 col-sm-6">
							<div class="feature-center animate-box" data-animate-effect="fadeIn">
								<span class="icon">
									<i class="fas fa-calendar-check"></i>
								</span>
								<h3>Book Your Driving Test</h3>
								<p>Quickly schedule your written or practical driving test online. Choose your preferred date, time, and test center, and get instant confirmation with SMS or email reminders. Easily manage or reschedule your bookings anytime.</p>
							</div>
						</div>


						<div class="col-md-3 col-sm-6">
							<div class="feature-center animate-box" data-animate-effect="fadeIn">
								<span class="icon">
									<i class="fas fa-sync-alt"></i>
								</span>
								<h3>Renew Your Driver’s License</h3>
								<p>Renew your expired or soon-to-expire driver’s license quickly and conveniently—no need to wait in line or visit a government office. Our online renewal system is secure, simple, and saves you time. </p>
							</div>
						</div>

						<div class="col-md-3 col-sm-6">
							<div class="feature-center animate-box" data-animate-effect="fadeIn">
								<span class="icon">
									<i class="fas fa-file-alt"></i>
								</span>
								<h3>Check License Status & Download Documents</h3>
								<p>Easily monitor the progress of your driver’s license application or renewal online. Receive real-time updates and securely download important documents like appointment confirmations and test results to keep your process smooth and hassle-free. </p>
							</div>
						</div>
					</div>
				</div>
			</div>

			

			<div id="gtco-counter" class="gtco-section">
				<div class="gtco-container">

					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
							<h2>Fun Facts</h2>
							<p>
								Here’s a snapshot of how we’re helping people across Cambodia get on the road:
							</p>
						</div>
					</div>

					<div class="row">
						
						<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInLeft">
							<div class="feature-center">
								<span class="icon">
									<i class="fas fa-id-card-alt"></i>
								</span>

								<span class="counter js-counter" data-from="0" data-to="22070" data-speed="5000" data-refresh-interval="50">1</span>								
								<span class="counter-label">Successful License Registrations</span>

							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInLeft">
							<div class="feature-center">
								<span class="icon">
									<i class="fas fa-smile-beam"></i>
								</span>
								<span class="counter js-counter" data-from="0" data-to="97" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Satisfaction Rating from Users</span>
								
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInLeft">
							<div class="feature-center">
								<span class="icon">
									<i class="fas fa-map-marker-alt"></i>
								</span>
								<span class="counter js-counter" data-from="0" data-to="402" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Test Centers Served Nationwide</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInLeft">
							<div class="feature-center">
								<span class="icon">
									<i class="fas fa-clock"></i> 
								</span>
								<span class="counter js-counter" data-from="0" data-to="212023" data-speed="5000" data-refresh-interval="50">1</span>
								<span class="counter-label">Hours Saved Through Online Services</span>

							</div>
						</div>
							
					</div>
				</div>
			</div>
{{-- 
			<div id="gtco-products">
				<div class="gtco-container">
					<div class="row animate-box">
						<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
							<h2>Products</h2>
							<p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
						</div>
					</div>
					<div class="row animate-box">
						<div class="owl-carousel owl-carousel-carousel">
							<div class="item">
								<img src="images/img_1.jpg" alt="Free HTML5 Bootstrap Template by GetTemplates.co">
							</div>
							<div class="item">
								<img src="images/img_2.jpg" alt="Free HTML5 Bootstrap Template by GetTemplates.co">
							</div>
							<div class="item">
								<img src="images/img_3.jpg" alt="Free HTML5 Bootstrap Template by GetTemplates.co">
							</div>
							<div class="item">
								<img src="images/img_4.jpg" alt="Free HTML5 Bootstrap Template by GetTemplates.co">
							</div>
						</div>
					</div>
				</div>
			</div> --}}

			

			<div id="gtco-subscribe">
				<div class="gtco-container">
					<div class="row animate-box">
						<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
							<h2>Subscribe for Updates</h2>
							<p>Be the first to know about important news, service updates, and helpful tips related to driver’s license registration, renewal, and testing in Cambodia.</p>
						</div>
					</div>
					<div class="row animate-box">
						<div class="col-md-12">
							<form class="form-inline">
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label for="email" class="sr-only">Email</label>
										<input type="email" class="form-control" id="email" placeholder="Your Email">
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<div class="form-group">
										<label for="name" class="sr-only">Name</label>
										<input type="text" class="form-control" id="name" placeholder="Your Name">
									</div>
								</div>
								<div class="col-md-4 col-sm-4">
									<button type="submit" class="btn btn-default btn-block">Subscribe</button>
								</div>
							</form>
						</div>
					</div>
				</div>

			</div>
@endsection