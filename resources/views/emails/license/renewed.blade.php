@component('mail::message')
# License Renewal Successful

Hi {{ $user->full_name ?? $user->name ?? 'Customer' }},

Your driver license has been successfully **renewed**.

@component('mail::panel')
- **License Type:** {{ $license->license_type }}
- **License Number:** {{ $license->license_number }}
- **Permit Number:** {{ $license->permit_number }}
- **Issued At:** {{ $license->issued_at }}
- **Expires At:** {{ $license->expires_at }}
@endcomponent

If you did not request this renewal, please contact support immediately.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
