@extends('frontend.layout.master')

@section('title', 'My Booking History')

@section('content')
<div class="gtco-section border-bottom">
    
    <div class="gtco-container py-5">
        <div class="text-left">
          <a href="{{ url('/') }}" class="btn btn-outline-secondary back-btn">
            <i class="fas fa-arrow-left"></i> Back to Home
          </a>
        </div>

        <div class="row animate-box">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2>📘 My Booking History</h2>
                <p>Here are all your previous and current bookings.</p>
            </div>
        </div>

        @if($bookings->isEmpty())
            <div class="alert alert-info text-center">You don’t have any bookings yet.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle shadow-sm" style="vertical-align: middle;">
                    <thead class="table-dark text-uppercase">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Permit Number</th>
                            <th>Test Center</th>
                            <th>License Type</th>
                            <th>Application Type</th>
                            <th>Test Date</th>
                            <th>Test Time</th>
                            <th>Booking Status</th>
                            <th>Payment</th>
                            <th>Test Results</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $booking->permit_number }}</td>
                                <td>{{ $booking->center_name }}</td>
                                <td>{{ $booking->requested_license_type }}</td>
                                <td>{{ ucfirst($booking->application_type) }}</td>
                                <td>{{ $booking->test_date }}</td>
                                <td>{{ $booking->test_time }}</td>

                                {{-- Booking Status --}}
                                <td>
                                    @php $bs = strtolower($booking->b_status ?? ''); @endphp
                                    @if($bs === 'paid')
                                        <span class="badge bg-success px-3 py-2">Paid</span>
                                    @elseif($bs === 'pending')
                                        <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                    @elseif($bs === 'confirmed')
                                        <span class="badge bg-primary px-3 py-2">Confirmed</span>
                                    @elseif($bs === 'completed')
                                        <span class="badge bg-info px-3 py-2">Completed</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">{{ ucfirst($booking->b_status ?? 'N/A') }}</span>
                                    @endif
                                </td>

                                {{-- Payment --}}
                                <td>
                                    @if(!empty($booking->payment_status) && strtolower($booking->payment_status) === 'paid')
                                        <div><span class="badge bg-success px-3 py-2">Paid</span></div>
                                        <small>{{ number_format($booking->payment_amount ?? 0) }} {{ $booking->payment_currency ?? 'KHR' }}</small>
                                    @elseif(!empty($booking->payment_status))
                                        <div><span class="badge bg-warning text-dark px-3 py-2">{{ ucfirst($booking->payment_status) }}</span></div>
                                        <small>{{ number_format($booking->payment_amount ?? 0) }} {{ $booking->payment_currency ?? 'KHR' }}</small>
                                    @else
                                        <span class="text-muted">No payment</span>
                                    @endif
                                </td>

                                {{-- Test Results --}}
                                <td>
                                    @if(!empty($booking->theory_result) || !empty($booking->practical_result))
                                        <div>Theory: <strong>{{ $booking->theory_result ?? '-' }}</strong></div>
                                        <div>Practical: <strong>{{ $booking->practical_result ?? '-' }}</strong></div>
                                    @else
                                        <span class="text-muted">Not tested</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Optional styling to make the table perfectly justified --}}
<style>
    table th, table td {
        text-align: center;
        vertical-align: middle !important;
    }
    table th {
        white-space: nowrap;
    }
    .table {
        font-size: 15px;
        border-radius: 10px;
        overflow: hidden;
    }
    .badge {
        border-radius: 10px;
        font-size: 13px;
    }
</style>
@endsection
