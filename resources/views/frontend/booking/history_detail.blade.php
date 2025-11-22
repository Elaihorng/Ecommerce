@extends('frontend/layout/master')

@section('title', 'Booking Detail')

@section('content')
<div class="gtco-section">
    <div class="gtco-container" style="padding-top:40px; padding-bottom:40px;">

        <h2 class="text-center mb-4">Booking Detail</h2>

        <div class="card shadow-sm p-4">

            <h4 class="mb-3">Booking Information</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Permit Number</th>
                    <td>{{ $booking->permit_number }}</td>
                </tr>
                <tr>
                    <th>Test Date</th>
                    <td>{{ $booking->test_date }}</td>
                </tr>
                <tr>
                    <th>Test Time</th>
                    <td>{{ $booking->test_time }}</td>
                </tr>
                <tr>
                    <th>Center</th>
                    <td>{{ $center->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($booking->b_status === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                </tr>
            </table>

            <hr>

            <h4 class="mb-3">Application Information</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Application Type</th>
                    <td>{{ $application->application_type ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>License Type</th>
                    <td>{{ $application->requested_license_type ?? 'N/A' }}</td>
                </tr>
            </table>

            <hr>

            <h4 class="mb-3">Payment Information</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Amount</th>
                    <td>{{ $payment->amount ?? 'N/A' }} {{ $payment->currency ?? '' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if(!empty($payment) && $payment->p_status === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Transaction ID</th>
                    <td>{{ $payment->provider_payment_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Paid At</th>
                    <td>{{ $payment->paid_at ?? 'N/A' }}</td>
                </tr>
            </table>

            <div class="text-center mt-4">
                <a href="{{ route('booking.history') }}" class="btn btn-primary">
                    Back to History
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
