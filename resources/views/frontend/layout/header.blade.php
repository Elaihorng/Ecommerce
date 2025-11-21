<nav class="gtco-nav" role="navigation">
			<div class="container" >
				
				<div class="row">
					<div class="col-sm-4 col-xs-12">
						<div id="gtco-logo"><a href="{{route('home')}}">ELICENSE kh <em>.</em></a></div>
					</div>
					<div style="position: absolute; top: 15px; right: 25px;">
						@if(app()->getLocale() === 'en')
							<a href="{{ route('lang.switch', 'kh') }}" 
							class="btn btn-sm btn-outline-primary" 
							style="font-weight: 600; border-radius: 8px;">
								🇰🇭 ខ្មែរ
							</a>
						@else
							<a href="{{ route('lang.switch', 'en') }}" 
							class="btn btn-sm btn-outline-primary" 
							style="font-weight: 600; border-radius: 8px;">
								🇬🇧 English
							</a>
						@endif
					</div>

					<div class="col-xs-8 text-right menu-1">
						<ul>
							<li class="@yield('Home_avtive')"><a href="{{route('home')}}">Home</a></li>


							<li class="has-dropdown @yield('Service_avtive')">
								<a href="{{route('service')}}" class="">Services</a>
								<ul class="dropdown">
									 @foreach($services as $service)
										<li>
											<a href="{{ route($service->route_name) }}">
												@if($service->icon)
													<i class="{{ $service->icon }}"></i>
												@endif
												{{ $service->s_name }}
											</a>
										</li>
									  @endforeach
								</ul>
							</li>
							<li class="@yield('News_avtive')"><a href="{{route('news')}}">News</a></li>
							<li class="@yield('About_avtive')"><a href="{{route('about')}}">About</a></li>
							

							<li class="has-dropdown @yield('User_avtive')">
								<a href="#"><i class="fas fa-user-circle"></i> Profile</a>
								<ul class="dropdown">
									@auth
										<li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> {{ auth()->user()->full_name }}</a></li>
										<li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
										<li><a href="{{ route('booking.history') }}"><i class="fas fa-cog"></i> History</a></li>

										<li>
											<form action="{{ route('logout') }}" method="POST" style="display: inline;">
												@csrf
												<button type="submit" style="background: none; border: none; padding: 0; color: #333; cursor: pointer;">
													<i class="fas fa-sign-out-alt"></i> Logout
												</button>
											</form>
										</li>
									@else
										<li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
										<li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a></li>
									@endauth
									
								</ul>
							</li>
						</ul>
					</div>
				</div>
				
			</div>
		</nav>