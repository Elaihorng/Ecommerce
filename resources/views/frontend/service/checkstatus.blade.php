@extends('frontend/layout/master')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner" style="background-image:url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc">
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Check Your Application Status</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            Stay informed about your driver’s license or test booking process. Enter your application ID or phone number to see your current status.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('title', 'Check Application Status')
@section('Service_avtive', 'active')

@section('content')
<div class="gtco-section border-bottom">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>What You’ll Need</h2>
                <p>Prepare either of the following to check your application status:</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Application ID</h3>
                        <p>Use the ID provided in your confirmation email or SMS.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-phone-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Phone Number</h3>
                        <p>Check status using your registered mobile number.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@guest
    

<div class="gtco-section">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>How It Works</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-search"></i></span>
                    <div class="feature-copy">
                        <h3>Step 1: Enter Info</h3>
                        <p>Input your Application ID or registered phone number.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-database"></i></span>
                    <div class="feature-copy">
                        <h3>Step 2: Search System</h3>
                        <p>We’ll check the official database for your application.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-info-circle"></i></span>
                    <div class="feature-copy">
                        <h3>Step 3: Get Status</h3>
                        <p>See if your application is pending, approved, or rejected.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-envelope-open-text"></i></span>
                    <div class="feature-copy">
                        <h3>Step 4: Get Notified</h3>
                        <p>You’ll be notified by SMS/email once status updates.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{{-- Login reminder --}}
<div class="alert alert-info text-center mt-4">
    Please <a href="{{ route('login') }}">login</a> to register for your new driver’s license.
</div>
@endguest

@auth
    
<div class="gtco-section">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>Check Your Status</h2>
                <p>Fill out the form below to track your application progress.</p>
            </div>
        </div>

        <div class="row animate-box">
            <div class="col-md-10 col-md-offset-1">

                <!-- Back to Home -->
                <div class="text-left" style="margin-bottom: 15px;">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
                </div>

                <!-- Card Wrapper -->
                <div class="status-card" style="padding:25px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); background-color:#fff; text-align:justify;">
                <h4 class="text-primary mb-4 text-center">🔍 Check Your Application Status</h4>

                <form method="POST" action="">
                    @csrf

                    <div class="form-group">
                    <label for="application_id">Application ID</label>
                    <input 
                        type="text" 
                        name="application_id" 
                        id="application_id" 
                        class="form-control" 
                        placeholder="Enter your application ID (optional)" 
                        value="{{ old('application_id') }}">
                    @error('application_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>

                    <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        class="form-control" 
                        placeholder="Enter your phone number (optional)" 
                        value="{{ old('phone') }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    </div>

                    <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" style="width: 50%;">
                        Check Status
                    </button>
                    </div>
                </form>

                <p class="text-muted text-center mt-3">
                    Having trouble? Contact support with your name and national ID.
                </p>
                </div>

            </div>
            </div>


    </div>
</div>
@endauth
@endsection
