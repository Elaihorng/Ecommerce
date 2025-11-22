@component('mail::message')
# Booking Confirmed

Hi {{ $user->full_name ?? $user->name }},

Your driving test booking has been confirmed and paid.

**Permit number:** {{ $booking->permit_number }}  
**Test date:** {{ $booking->test_date }}  
**Test time:** {{ $booking->test_time }}

@component('mail::button', ['url' => route('booking.history')])
View My Booking
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
