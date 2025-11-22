@extends('frontend.layout.master')

@section('title', 'Application Status')

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
                        <h1 class="animate-box" data-animate-effect="fadeInUp">Application Status</h1>
                        <h2 class="animate-box" data-animate-effect="fadeInUp">
                            Here is the latest status of your driver’s license application and test booking.
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

        {{-- Back button --}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <a href="{{ url('/service/checkstatus') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Check Status
                </a>
            </div>
        </div>

        {{-- ========== APPLICATION CARD ========== --}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="mb-4"
                     style="border-radius:16px; background:#fff; box-shadow:0 6px 20px rgba(0,0,0,0.08); padding:28px;">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-file-alt"
                           style="font-size:24px; margin-right:10px; color:#555;"></i>
                        <h3 class="m-0" style="font-weight:600;">Application Overview</h3>
                    </div>

                    @php
                        $appStatus = strtolower($application->app_status ?? 'pending');
                    @endphp

                    <div class="row" style="font-size:15px;">
                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Permit Number</p>
                            <div class="fw-bold">{{ $application->permit_number ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <p class="text-muted mb-1">Application Type</p>
                            <span class="badge bg-primary"
                                  style="padding:7px 14px; border-radius:12px; font-size:13px;">
                                {{ ucfirst($application->application_type ?? '-') }}
                            </span>
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
                            @if($appStatus === 'approved')
                                <span class="badge bg-success"
                                      style="padding:7px 14px; border-radius:12px;">Approved</span>
                            @elseif($appStatus === 'rejected')
                                <span class="badge bg-danger"
                                      style="padding:7px 14px; border-radius:12px;">Rejected</span>
                            @elseif($appStatus === 'completed')
                                <span class="badge bg-info"
                                      style="padding:7px 14px; border-radius:12px;">Completed</span>
                            @else
                                <span class="badge bg-warning text-dark"
                                      style="padding:7px 14px; border-radius:12px;">
                                    {{ ucfirst($appStatus) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== BOOKING CARD (SAME WIDTH) ========== --}}
        @if($booking)
            @php $bs = strtolower($booking->b_status ?? 'pending'); @endphp

            <div class="row mt-2">
                <div class="col-md-10 col-md-offset-1">
                    <div class="mb-4"
                         style="border-radius:16px; background:#fff; box-shadow:0 6px 20px rgba(0,0,0,0.08); padding:28px;">

                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-id-card-alt"
                               style="font-size:24px; margin-right:10px; color:#555;"></i>
                            <h3 class="m-0" style="font-weight:600;">Test Booking</h3>
                        </div>

                        <div class="row" style="font-size:15px;">
                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Permit Number</p>
                                <div class="fw-bold">{{ $booking->permit_number }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Test Time</p>
                                <div class="fw-bold">{{ $booking->test_time }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Test Date</p>
                                <div class="fw-bold">{{ $booking->test_date }}</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <p class="text-muted mb-1">Booking Status</p>
                                <span class="badge
                                    @if($bs === 'paid') bg-success
                                    @elseif($bs === 'confirmed') bg-primary
                                    @elseif($bs === 'completed') bg-info
                                    @else bg-warning text-dark
                                    @endif"
                                      style="padding:7px 14px; border-radius:999px; font-size:13px;">
                                    {{ ucfirst($bs) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ========== TEST RESULT CARD (SAME WIDTH) ========== --}}
            @if($testResult)
                <div class="row mt-2">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="mb-4"
                            style="border-radius:16px; background:#fff; box-shadow:0 6px 20px rgba(0,0,0,0.08); padding:28px;">
                            <div class="d-flex align-items-center mb-4">
                                <i class="fas fa-clipboard-check"
                                style="font-size:24px; margin-right:10px; color:#555;"></i>
                                <h3 class="m-0" style="font-weight:600;">Test Results</h3>
                            </div>

                            <div class="row" style="font-size:15px;">
                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1">Theory Test</p>
                                    @if($testResult->theory_result === 'pass')
                                        <span class="badge bg-success"
                                            style="padding:7px 14px; border-radius:999px;">Pass</span>
                                    @elseif($testResult->theory_result === 'fail')
                                        <span class="badge bg-danger"
                                            style="padding:7px 14px; border-radius:999px;">Fail</span>
                                    @else
                                        <span class="badge bg-secondary"
                                            style="padding:7px 14px; border-radius:999px;">
                                            {{ $testResult->theory_result ?? 'N/A' }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1">Practical Test</p>
                                    @if($testResult->practical_result === 'pass')
                                        <span class="badge bg-success"
                                            style="padding:7px 14px; border-radius:999px;">Pass</span>
                                    @elseif($testResult->practical_result === 'fail')
                                        <span class="badge bg-danger"
                                            style="padding:7px 14px; border-radius:999px;">Fail</span>
                                    @else
                                        <span class="badge bg-secondary"
                                            style="padding:7px 14px; border-radius:999px;">
                                            {{ $testResult->practical_result ?? 'N/A' }}
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 mb-3">
                                    <p class="text-muted mb-1">Tested At</p>
                                    <div class="fw-bold">{{ $testResult->created_at ?? '-' }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

    </div>
</div>
@endsection

