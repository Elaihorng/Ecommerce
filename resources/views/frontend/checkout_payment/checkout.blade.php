@extends('frontend/layout/master')

@section('title', 'Checkout Registration')
@section('Service_avtive', 'active')

@section('header')
<header id="gtco-header" class="gtco-cover gtco-cover-xs" role="banner" style="background-image:url('https://pppenglish.sgp1.digitaloceanspaces.com/image/large/field/image/topic-16.-khmer-national-identity-card-by-hong-menea-2.jpg');background-repeat:no-repeat;background-size:cover;background-position:center;">
    <div class="overlay"></div>
    <div class="gtco-container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc">
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Register for a New Driver’s License</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            Applying for your first driver’s license has never been easier. Our online system guides you from registration to exam booking.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<div class="gtco-section border-bottom">
    <div class="gtco-container">

        {{-- flash + validation --}}
        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
            </div>
        @endif

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>Checkout</h2>
                <p>Review your booking, then confirm to pay with KHQR.</p>
            </div>
        </div>

        <div class="row animate-box">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary" style="box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fas fa-receipt"></i> Registration Summary</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">

                            {{-- LEFT --}}
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong><i class="fas fa-hashtag"></i> Permit Number:</strong> {{ $permit_number }}
                                    </li>
                                    @isset($full_name)
                                        <li class="list-group-item">
                                            <strong><i class="fas fa-user"></i> Full Name:</strong> {{ $full_name }}
                                        </li>
                                    @endisset
                                    
                                    @isset($gender)
                                        <li class="list-group-item">
                                            <strong><i class="fas fa-venus-mars"></i> Gender:</strong> {{$gender }}
                                        </li>
                                    @endisset

                                    @isset($user_email)
                                        <li class="list-group-item">
                                            <strong><i class="fas fa-envelope"></i> Email:</strong> {{ $user_email }}
                                        </li>
                                    @endisset

                                    @isset($user_phone)
                                        <li class="list-group-item">
                                            <strong><i class="fas fa-phone"></i> Phone:</strong> {{ $user_phone }}
                                        </li>
                                    @endisset

                                    

                                    

                                    

                                    
                                </ul>
                            </div>

                            {{-- RIGHT --}}
                            <div class="col-md-6">
                                <ul class="list-group">
                                    @isset($application_type)
                                        <li class="list-group-item">
                                            <strong><i class="fas fa-file-alt"></i> Application Type:</strong> {{ ucfirst($application_type) }}
                                        </li>
                                    @endisset

                                    @isset($license_type)
                                        <li class="list-group-item">
                                            <strong><i class="fas fa-id-card"></i> License Type:</strong> {{ $license_type }}
                                        </li>
                                    @endisset
                                    <li class="list-group-item">
                                        <strong><i class="fas fa-map-marker-alt"></i> Test Center:</strong> {{ $center_name }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong><i class="fas fa-calendar-alt"></i> Test Date:</strong> {{ $test_date }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong><i class="fas fa-clock"></i> Test Time:</strong> {{ $test_time }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong><i class="fas fa-money-bill"></i> Price:</strong> {{ number_format($amount) }} {{ $currency }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <hr>

                        {{-- Confirm & Pay form --}}
                        <div class="text-center" style="margin-top:20px;">
                            <form method="POST" action="{{ route('booking.payKhqr') }}" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="permit_number" value="{{ $permit_number }}">
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="currency" value="{{ $currency }}">
                                
                            </form>

                            <form method="POST" action="{{ isset($renewal_id) ? route('renewal.payKhqr') : route('booking.payKhqr') }}">
                                @csrf
                                @if(isset($renewal_id))
                                    <input type="hidden" name="renewal_id" value="{{ $renewal_id }}">
                                @else
                                    <input type="hidden" name="permit_number" value="{{ $permit_number }}">
                                @endif
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="currency" value="{{ $currency }}">
                                <button type="submit" class="btn btn-success btn-lg">Confirm & Pay with KHQR</button>
                            </form>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
