@extends('frontend/layout/master')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner" style="background-image:url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc">
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Renew Your Driver’s License</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            Renew your expired or soon-to-expire driver’s license quickly and conveniently—no need to wait in line or visit a government office. Our online renewal system is secure, simple, and saves you time.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('title', 'Renew Driver License')
@section('Service_avtive', 'active')

@section('content')
<div class="gtco-section border-bottom">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>What You’ll Need</h2>
                <p>Make sure you have the following ready before starting your renewal:</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-id-card-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Current or Expired License Number</h3>
                        <p>Required to verify your existing license status.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-id-card"></i></span>
                    <div class="feature-copy">
                        <h3>National ID or Passport</h3>
                        <p>Used to confirm your identity during the renewal.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-image"></i></span>
                    <div class="feature-copy">
                        <h3>Recent Passport Photo</h3>
                        <p>Ensure your photo is clear and recent for your new license.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-notes-medical"></i></span>
                    <div class="feature-copy">
                        <h3>Medical Certificate</h3>
                        <p>Updated certificate if required for renewal approval.</p>
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
                    <span class="icon"><i class="fas fa-sign-in-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Step 1: Log In</h3>
                        <p>Access your account and select the <strong>Renew License</strong> option.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-edit"></i></span>
                    <div class="feature-copy">
                        <h3>Step 2: Update Your Information</h3>
                        <p>Fill out any updated personal details and upload your documents.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Step 3: Choose Pickup or Delivery</h3>
                        <p>Select your preferred location for receiving your renewed license.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-credit-card"></i></span>
                    <div class="feature-copy">
                        <h3>Step 4: Pay Online</h3>
                        <p>Complete your payment securely through our online system.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-envelope-open-text"></i></span>
                    <div class="feature-copy">
                        <h3>Step 5: Receive Confirmation</h3>
                        <p>Get SMS or email confirmation with details about your renewal.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
        <div class="alert alert-info text-center mt-4">
            Please <a href="{{ route('login') }}">login</a> to register for your new driver’s license.
        </div>
      @endguest
@auth
    

<div class="gtco-section">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>Driver’s License Renewal Form</h2>
                <p>Please fill out the form below to renew your driver’s license.</p>
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
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Card Wrapper -->
            <div class="renewal-card" style="padding:25px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); background-color:#fff; text-align:justify;">
            <form method="POST" action="{{ route('license.renewal') }}" enctype="multipart/form-data">
                @csrf

                <h4 class="text-primary">🧾 License Information</h4>
                <div class="form-group">
                <label for="current_license_number">Current or Expired License Number <span class="text-danger">*</span></label>
                <input type="text" name="current_license_number" class="form-control" required value="{{ old('current_license_number') }}">
                @error('current_license_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
                
                <h4 class="text-primary">🧍 Personal Information</h4>
                <div class="form-group row">
                <div class="col-md-6">
                    <label for="national_id">National ID or Passport <span class="text-danger">*</span></label>
                    <input type="file" name="national_id" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    @error('national_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="photo">Recent Passport Photo <span class="text-danger">*</span></label>
                    <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png" required>
                    @error('photo')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                </div>
{{-- 
                <div class="form-group">
                <label for="medical_cert">Updated Medical Certificate (If Required)</label>
                <input type="file" name="medical_cert" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                @error('medical_cert')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div> --}}

                <h4 class="text-primary">📦 Delivery Options</h4>
                <div class="form-group">
                <label for="delivery_option">Choose Pickup or Delivery <span class="text-danger">*</span></label>
                <select name="delivery_option" class="form-control" required>
                    <option value="">-- Select Option --</option>
                    <option value="pickup" {{ old('delivery_option') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                    <option value="delivery" {{ old('delivery_option') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                </select>
                @error('delivery_option')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>

                <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" style="width: 50%;">
                    Submit Renewal
                </button>
                </div>
            </form>
            </div>

        </div>
        </div>


    </div>
</div>
@endauth
@endsection
