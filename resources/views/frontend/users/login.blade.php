@extends('frontend/layout/master')

@section('title', 'Login')
@section('Login_active', 'active')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner" 
  style="background-image: url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg'); 
  background-repeat: no-repeat; background-size: cover; background-position: center;">
  <div class="overlay"></div>
  <div class="gtco-container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <div class="display-t">
          <div class="display-tc">
            <h1 class="animate-box" data-animate-effect="fadeInUp">Login</h1>
            <h2 class="animate-box" data-animate-effect="fadeInUp">Access your account to manage services</h2>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
@endsection

@section('content')
<style>
  .login-card {
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    background-color: #fff;
    text-align: justify;
  }
  .login-card h2 {
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
  .back-btn {
    display: inline-block;
    margin-bottom: 15px;
  }
</style>

<div class="gtco-section border-bottom">
  <div class="gtco-container">
    <div class="row animate-box">
      <div class="col-md-6 col-md-offset-3">
        @if (session('success'))
    <div class="alert alert-success" style="margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" style="margin-bottom: 15px;">
        {{ session('error') }}
    </div>
@endif
        <!-- Back to Home button -->
        
        <div class="login-card">
          <h2>Please Log In</h2>

        @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom: 15px;">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
  
    <div class="form-group">
      <label for="email">Email address</label>
      <input 
        type="email" 
        name="email" 
        id="email" 
        class="form-control" 
        placeholder="Enter your email" 
        required 
        autofocus>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input 
        type="password" 
        name="password" 
        id="password" 
        class="form-control" 
        placeholder="Enter your password" 
        required>
    </div>

    <div class="form-group">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="remember"> Remember Me
        </label>
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Log In</button>
</form>

          <div class="text-center" style="margin-top:15px;">
            <a href="#">Forgot Your Password?</a> | 
            <a href="{{ route('register') }}">Register</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
