@extends('frontend.layout.master')

@section('title', 'Your License')

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
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Your License</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            View your driver’s license status and details.
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

        {{-- Back --}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>

        @if(!$application)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="alert alert-info">
                        You have not submitted any application yet.
                    </div>
                </div>
            </div>
        @else
            {{-- LICENSE CARD --}}
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="mb-4"
                         style="border-radius:16px; background:#fff; box-shadow:0 6px 20px rgba(0,0,0,0.08); padding:28px;">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-id-card"
                               style="font-size:24px; margin-right:10px; color:#555;"></i>
                            <h3 class="m-0" style="font-weight:600;">License Summary</h3>
                        </div>

                        @php
                            $badgeClass = 'bg-secondary';
                            $label = 'In Progress';

                            switch ($licenseStatus) {
                                case 'active':
                                    $badgeClass = 'bg-success';
                                    $label = 'Active';
                                    break;
                                case 'rejected':
                                    $badgeClass = 'bg-danger';
                                    $label = 'Rejected';
                                    break;
                                case 'waiting_test':
                                    $badgeClass = 'bg-warning text-dark';
                                    $label = 'Waiting for Test Result';
                                    break;
                                case 'no_application':
                                    $badgeClass = 'bg-secondary';
                                    $label = 'No Application';
                                    break;
                                default:
                                    $badgeClass = 'bg-info';
                                    $label = 'In Progress';
                            }
                        @endphp

                        <div class="row" style="font-size:15px;">
                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Full Name</p>
                                <div class="fw-bold">{{ $user->full_name ?? $user->name }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">License Status</p>
                                <span class="badge {{ $badgeClass }}"
                                      style="padding:7px 14px; border-radius:12px; font-size:13px;">
                                    {{ $label }}
                                </span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Permit Number</p>
                                <div class="fw-bold">{{ $application->permit_number ?? '-' }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">License Type</p>
                                <span class="badge bg-warning text-dark"
                                      style="padding:7px 14px; border-radius:12px; font-size:13px;">
                                    {{ $application->requested_license_type ?? '-' }}
                                </span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Application Status</p>
                                <div class="fw-bold text-capitalize">{{ $application->app_status ?? '-' }}</div>
                            </div>

                            @if($booking)
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1">Latest Booking</p>
                                    <div class="fw-bold">
                                        {{ $booking->test_date }} {{ $booking->test_time }}
                                        ({{ ucfirst($booking->b_status) }})
                                    </div>
                                </div>
                            @endif

                            @if($testResult)
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1">Test Results</p>
                                    <div>
                                        Theory:
                                        <strong class="text-capitalize">{{ $testResult->theory_result }}</strong><br>
                                        Practical:
                                        <strong class="text-capitalize">{{ $testResult->practical_result }}</strong>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1">Tested At</p>
                                    <div class="fw-bold">{{ $testResult->created_at }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
