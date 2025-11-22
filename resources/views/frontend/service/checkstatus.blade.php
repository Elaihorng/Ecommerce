@extends('frontend/layout/master')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner"
    style="background-image:url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg');
           background-repeat:no-repeat; background-size:cover; background-position:center;">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc">
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Check Your Application Status</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            Track your driver's license application or test booking using your Application ID or phone number.
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

{{-- What you need --}}
<div class="gtco-section border-bottom">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>What You’ll Need</h2>
                <p>You can check your application using either:</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="feature-left animate-box">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Application ID</h3>
                        <p>Provided in your SMS / email confirmation.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="feature-left animate-box">
                    <span class="icon"><i class="fas fa-phone-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Phone Number</h3>
                        <p>Your registered mobile number.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Guest user --}}
@guest
<div class="alert alert-info text-center mt-4">
    Please <a href="{{ route('login') }}">login</a> to check your full application status.
</div>
@endguest

{{-- Logged in user --}}
@auth
<div class="gtco-section">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>Track Your Application</h2>
                <p>Enter the required details below and check your progress instantly.</p>
            </div>
        </div>

        <div class="row animate-box">
            <div class="col-md-10 col-md-offset-1">

                <div class="text-left mb-2">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Home
                    </a>
                </div>

                <div class="status-card" style="padding:25px; border-radius:10px; background:#fff; box-shadow:0 3px 10px rgba(0,0,0,0.1);">
                    <h4 class="text-primary mb-4 text-center">🔍 Check Application Status</h4>

                    <form method="POST" action="{{ route('application.status.search') }}">
                        @csrf

                        <label for="permit_number">Permit Number</label>
                        <input 
                            type="text" 
                            name="permit_number" 
                            id="permit_number" 
                            class="form-control" 
                            placeholder="Enter your permit number (e.g. PERMIT-20251122-0001)" 
                            value="{{ old('permit_number') }}">
                        @error('permit_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">
                                Check Status
                            </button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-3">
                        Need help? Contact support with your full name and national ID.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endauth

@endsection
