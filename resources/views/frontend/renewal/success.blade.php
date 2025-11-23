{{-- resources/views/frontend/renewal/success.blade.php --}}
@extends('frontend/layout/master')

@section('title', 'License Renewal Success')
@section('Service_avtive', 'active')

@section('content')
<style>
    .center-wrap {
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .success-card {
        max-width: 650px;
        width: 100%;
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    .success-card h2 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .details-list p {
        margin: 4px 0;
        font-size: 15px;
    }
</style>

<div class="gtco-section border-bottom center-wrap">

    <div class="success-card text-center">

        <h2 class="text-success">
            <i class="fas fa-check-circle"></i> License Renewal Payment Successful
        </h2>

        <p class="lead mb-4">Your renewal payment has been received successfully.</p>

        <div class="details-list text-start d-inline-block">

            @if($user)
                <p><strong>Name:</strong> {{ $user->full_name ?? $user->name ?? '-' }}</p>
                <p><strong>Email:</strong> {{ $user->email ?? '-' }}</p>
            @endif

            <p><strong>Current License No:</strong> {{ $renewal->current_license_number }}</p>
            <p><strong>Renewal Permit:</strong> {{ $renewal->permit_number }}</p>
            <p><strong>Delivery Option:</strong>
                {{ $renewal->delivery_option === 'delivery' ? 'Delivery' : 'Pickup at Center' }}
            </p>
            <p><strong>Status:</strong>
                <span class="badge bg-success">{{ ucfirst($renewal->status) }}</span>
            </p>
        </div>

        <div class="mt-4">

            <a href="{{ route('home') }}" class="btn btn-primary">Go to Dashboard</a>
        </div>

    </div>

</div>
@endsection
