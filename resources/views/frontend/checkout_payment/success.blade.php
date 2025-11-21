@extends('frontend/layout/master')

@section('title', 'Payment Successful')
@section('Service_avtive', 'active')

@section('content')
<div class="gtco-section border-bottom">
    <div class="gtco-container text-center" style="padding-top:80px; padding-bottom:80px;">
        <h2 class="text-success"><i class="fas fa-check-circle"></i> Payment Successful</h2>
        <p class="lead">Your KHQR payment has been received successfully.</p>
        <p><strong>Permit Number:</strong> {{ $permit_number }}</p>

        <div style="margin-top:30px;">
            <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
            <a href="{{ route('booking.history') }}" class="btn btn-success">View Booking</a>
        </div>
    </div>
</div>
@endsection
