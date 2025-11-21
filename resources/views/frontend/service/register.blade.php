@extends('frontend/layout/master')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner" style="background-image:url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc">
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Register for a New Driver’s License</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            Applying for your first driver’s license has never been easier. Our online registration system guides you through every step — from account creation to exam booking — without needing to visit the office in person.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('title', 'Register for a New License')
@section('Service_avtive', 'active')

@section('content')
<div class="gtco-section border-bottom">
    <div class="gtco-container">

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>What You’ll Need</h2>
                <p>Before you register, make sure you have these essential items ready to upload:</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-id-card"></i></span>
                    <div class="feature-copy">
                        <h3>Valid National ID or Passport</h3>
                        <p>This is required to verify your identity during the registration process.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-image"></i></span>
                    <div class="feature-copy">
                        <h3>Passport-Sized Photo</h3>
                        <p>Please prepare a clear, recent passport-style photo for your application.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-notes-medical"></i></span>
                    <div class="feature-copy">
                        <h3>Medical Certificate</h3>
                        <p>Optional at registration time, but required before your final approval.</p>
                    </div>
                </div>
            </div>
        </div>

      @guest
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>How It Works</h2>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-user-edit"></i></span>
                    <div class="feature-copy">
                        <h3>Step 1: Fill Out Personal Details</h3>
                        <p>Enter your name, contact info, and choose license type (Car or Motorcycle).</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-upload"></i></span>
                    <div class="feature-copy">
                        <h3>Step 2: Upload Your Documents</h3>
                        <p>Upload your National ID, passport photo, and optional medical certificate securely.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                    <div class="feature-copy">
                        <h3>Step 3: Select Test Center</h3>
                        <p>Choose a test location and schedule your written exam conveniently.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-envelope-open-text"></i></span>
                    <div class="feature-copy">
                        <h3>Step 4: Get Confirmation</h3>
                        <p>Receive confirmation via SMS or email with your booking details and next steps.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-lock"></i></span>
                    <div class="feature-copy">
                        <h3>Step 5: Data Security</h3>
                        <p>All data is encrypted and processed through official government systems for safety.</p>
                    </div>
                </div>

                <div class="feature-left animate-box" data-animate-effect="fadeInLeft">
                    <span class="icon"><i class="fas fa-flag"></i></span>
                    <div class="feature-copy">
                        <h3>Start Your Registration</h3>
                        <p>Take the first step toward legal driving in Cambodia below.</p>
                       
                    </div>
                </div>
            </div>
        </div>
        {{-- Login reminder --}}
        <div class="alert alert-info text-center mt-4">
            Please <a href="{{ route('login') }}">login</a> to register for your new driver’s license.
        </div>
      @endguest
    </div>
</div>
@auth
<div class="gtco-section">
    <div class="gtco-container">
        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>Driver’s License Registration Form</h2>
                <p>Please complete the form below to register for your new driver’s license.</p>
            </div>
        </div>

<div class="row animate-box">
  <div class="col-md-10 col-md-offset-1">

    <!-- Back to Home -->
    {{-- <div class="text-left" style="margin-bottom:15px;">
      <a href="{{ url('/') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Home
      </a>
    </div> --}}
  
    <div class="register-card" style="padding:25px;border-radius:10px;box-shadow:0 4px 8px rgba(0,0,0,.1);background:#fff;text-align:justify;">
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
        
      <form method="POST" action="{{ route('register.license') }}" enctype="multipart/form-data">
      @csrf

        <h4 class="text-primary">🧍 Personal Information</h4>
        <div class="form-group row">
          <div class="col-md-12">
            <label for="full_name">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="full_name" id="full_name" class="form-control"
                   value="{{ old('full_name') }}" required>
            @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          
        </div>

        {{-- <div class="form-group row">
          <div class="col-md-6">
            <label for="gender">Gender <span class="text-danger">*</span></label>
            <select name="gender" id="gender" class="form-control" required>
              <option value="">-- Select Gender --</option>
              <option value="male"   {{ old('gender')==='male' ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('gender')==='female' ? 'selected' : '' }}>Female</option>
              <option value="other"  {{ old('gender')==='other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label for="dob">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" name="dob" id="dob" class="form-control"
                   value="{{ old('dob') }}"
                   max="{{ now()->subYears(16)->toDateString() }}" required>
            <small class="text-muted">You must be at least 16 years old.</small>
            @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div> --}}

        {{-- <div class="form-group row">
          <div class="col-md-6">
            <label for="email">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control"
                   placeholder="name@example.com" value="{{ old('email') }}" >
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
          <div class="col-md-6">
            <label for="phone">Phone Number <span class="text-danger">*</span></label>
            <input type="tel" name="phone" id="phone" class="form-control"
                   placeholder="+855 12 345 678"
                   value="{{ old('phone') }}"
                   pattern="^(?:\+855\d{8,9}|0\d{8,9})$" required>
            <small class="text-muted">Format: +855xxxxxxxx or 0xxxxxxxxx</small>
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div> --}}

        <h4 class="text-primary">📄 License Information</h4>
        <div class="form-group row">
          <div class="col-md-6">
            <label for="license_type">License Type <span class="text-danger">*</span></label>
            <select name="license_type" id="license_type" class="form-control" required>
              <option value="">-- Choose Type --</option>
              @foreach($licenseTypes as $type)
                <option value="{{ $type->code }}" {{ old('license_type') == $type->code ? 'selected' : '' }}>
                  {{ $type->code }} — {{ $type->description }}
                </option>
              @endforeach
            </select>
            @error('license_type')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="test_center">Test Center <span class="text-danger">*</span></label>
            <select name="test_center" id="test_center" class="form-control" required>
              <option value="">-- Select Center --</option>
              <option value="phnom_penh"     {{ old('test_center')==='phnom_penh' ? 'selected' : '' }}>Phnom Penh</option>
              <option value="siem_reap"      {{ old('test_center')==='siem_reap' ? 'selected' : '' }}>Siem Reap</option>
              <option value="battambang"     {{ old('test_center')==='battambang' ? 'selected' : '' }}>Battambang</option>
              <option value="kampong_cham"   {{ old('test_center')==='kampong_cham' ? 'selected' : '' }}>Kampong Cham</option>
              <option value="preah_sihanouk" {{ old('test_center')==='preah_sihanouk' ? 'selected' : '' }}>Preah Sihanouk</option>
            </select>
            @error('test_center') <small class="text-danger">{{ $message }}</small> @enderror
          </div>
        </div>

        <div class="form-group">
          <label for="test_date">Preferred Test Date <span class="text-danger">*</span></label>
          <input type="date" name="test_date" id="test_date" class="form-control"
                 value="{{ old('test_date') }}" min="{{ now()->toDateString() }}" required>
          @error('test_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <h4 class="text-primary">📎 Document Uploads</h4>
        <div class="form-group">
          <label for="national_id">National ID or Passport <span class="text-danger">*</span></label>
          <input type="file" name="national_id" id="national_id" class="form-control"
                 accept=".pdf,.jpg,.jpeg,.png" >
          <small class="text-muted">Accepted: PDF, JPG, PNG. Max 5 MB.</small>
          @error('national_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
          <label for="photo">Passport-Sized Photo <span class="text-danger">*</span></label>
          <input type="file" name="photo" id="photo" class="form-control"
                 accept=".jpg,.jpeg,.png" >
          <small class="text-muted">Accepted: JPG, PNG. Max 3 MB.</small>
          @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- <div class="form-group">
          <label for="medical_cert">Medical Certificate (Optional)</label>
          <input type="file" name="medical_cert" id="medical_cert" class="form-control"
                 accept=".pdf,.jpg,.jpeg,.png">
          <small class="text-muted">Accepted: PDF, JPG, PNG. Max 5 MB.</small>
          @error('medical_cert') <small class="text-danger">{{ $message }}</small> @enderror
        </div> --}}

        <div class="form-group text-center">
        <button type="submit" class="btn btn-primary" style="width: 50%;">
            Submit Registration
        </button>
        </div>

      </form>
    @endauth
    </div>

  </div>
</div>

{{-- Optional client-side size guard (no external libs) --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const limits = {
      national_id: 5 * 1024 * 1024,
      photo: 3 * 1024 * 1024,
      medical_cert: 5 * 1024 * 1024
    };
    ['national_id','photo','medical_cert'].forEach(id => {
      const input = document.getElementById(id);
      if (!input) return;
      input.addEventListener('change', function () {
        const f = this.files && this.files[0];
        if (f && limits[id] && f.size > limits[id]) {
          alert('File too large for ' + id.replace('_',' ') + '. Please upload a smaller file.');
          this.value = '';
        }
      });
    });
  });
</script>

    </div>
</div>


@endsection
