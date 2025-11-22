@extends('frontend/layout/master')

@section('title', 'Register')
@section('Register_active', 'active')

@section('header')

<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner" 
  style="background-image: url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg'); 
  background-repeat: no-repeat; 
  background-size: cover; 
  background-position: center;">
  <div class="overlay"></div>
  <div class="gtco-container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <div class="display-t">
          <div class="display-tc">
            <h1 class="animate-box" data-animate-effect="fadeInUp">Register</h1>
            <h2 class="animate-box" data-animate-effect="fadeInUp">Create a new account to get started</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</header> 

@endsection

@section('content')
<style>
  .register-card {
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    background-color: #fff;
    text-align: justify;
  }
  .register-card h2 {
    margin-bottom: 25px;
    text-align: center;
  }
  .form-group label {
    font-weight: 600;
  }
  .btn-block {
    width: 100%;
    padding: 10px;
  }
</style>
<div class="gtco-section border-bottom">
  <div class="gtco-container">
    <div class="row animate-box">
      <div class="col-md-6 col-md-offset-3">

        <!-- Back to Home button -->
        <div class="text-left" style="margin-bottom: 15px;">
          <a href="{{ url('/') }}" class="btn btn-outline-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
          </a>
        </div>

        <div class="register-card">
          @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
          @endif
          <h2>Create Your Account</h2>

          <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            {{-- Full Name --}}
            <div class="form-group">
              <label for="full_name">Full Name</label>
              <input 
                type="text" 
                name="full_name" 
                id="full_name" 
                class="form-control" 
                placeholder="Enter your full name" 
                value="{{ old('full_name') }}" 
                required 
                autofocus>
            </div>
             @error('full_name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            {{-- Gender --}}
            <div class="form-group">
              <label class="d-block">Gender <span class="text-danger">*</span></label>
              <div style="display: flex; gap: 20px; align-items: center;">
                <label><input type="radio" name="gender" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required> Male</label>
                <label><input type="radio" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }}> Female</label>
                <label><input type="radio" name="gender" value="other" {{ old('gender') === 'other' ? 'checked' : '' }}> Other</label>
              </div>
              @error('gender') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
            </div>

            {{-- Register by --}}
            <div class="form-group">
              <label>Register by:</label><br>
              <label><input type="radio" name="register_by" value="email" {{ old('register_by', 'email') == 'email' ? 'checked' : '' }}> Email</label> &nbsp;&nbsp;
              <label><input type="radio" name="register_by" value="phone" {{ old('register_by') == 'phone' ? 'checked' : '' }}> Phone Number</label>
            </div>

            {{-- Email --}}
            <div class="form-group" id="email-group" style="{{ old('register_by', 'email') == 'email' ? '' : 'display:none;' }}">
              <label for="email">Email address</label>
              <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="Enter your email"
                value="{{ old('email') }}">
                 @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="form-group" id="phone-group" style="{{ old('register_by') == 'phone' ? '' : 'display:none;' }}">
              <label for="phone">Phone Number</label>
              <input 
                type="tel" 
                name="phone" 
                id="phone" 
                class="form-control" 
                placeholder="Enter your phone number"
                value="{{ old('phone') }}">
                 @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- DOB --}}
            <div class="form-group">
              <label for="dob">Date of Birth <span class="text-danger">*</span></label>
              <input 
                type="date" 
                name="dob" 
                id="dob" 
                class="form-control" 
                value="{{ old('dob') }}" 
                max="{{ now()->subYears(16)->toDateString() }}" 
                required>
              <small class="text-muted">You must be at least 16 years old.</small>
              @error('dob')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
              @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
              <label for="password">Password</label>
              <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control"
                value="{{ old('password_hash') }}" 
                placeholder="Enter your password" 
                required>
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
              <label for="password_confirmation">Confirm Password</label>
              <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="form-control" 
                placeholder="Confirm your password">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </form>

          {{-- Dynamic toggle --}}
          <script>
            document.addEventListener('DOMContentLoaded', function () {
              const emailGroup = document.getElementById('email-group');
              const phoneGroup = document.getElementById('phone-group');
              const radios = document.querySelectorAll('input[name="register_by"]');

              radios.forEach(radio => {
                radio.addEventListener('change', function () {
                  if (this.value === 'email') {
                    emailGroup.style.display = 'block';
                    phoneGroup.style.display = 'none';
                  } else {
                    emailGroup.style.display = 'none';
                    phoneGroup.style.display = 'block';
                  }
                });
              });
            });
          </script>


          <div class="text-center" style="margin-top:15px;">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const emailGroup = document.getElementById('email-group');
    const phoneGroup = document.getElementById('phone-group');
    const radios = document.getElementsByName('register_by');

    radios.forEach(radio => {
      radio.addEventListener('change', function() {
        if (this.value === 'email') {
          emailGroup.style.display = 'block';
          phoneGroup.style.display = 'none';
          document.getElementById('phone').value = '';
        } else {
          emailGroup.style.display = 'none';
          phoneGroup.style.display = 'block';
          document.getElementById('email').value = '';
        }
      });
    });
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const emailGroup = document.getElementById('email-group');
  const phoneGroup = document.getElementById('phone-group');
  const radios = document.querySelectorAll('input[name="register_by"]');

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.value === 'email') {
        emailGroup.style.display = 'block';
        phoneGroup.style.display = 'none';
      } else {
        emailGroup.style.display = 'none';
        phoneGroup.style.display = 'block';
      }
    });
  });
});
</script>

@endsection
