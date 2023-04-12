@component('mail::message')
# Hi , Admin

**Subject :** {{ $details['subject'] }} 

**Name :** {{ $details['name'] }} 

**Email :** {{ $details['email'] }} 

**Phone :** {{ $details['phone'] }} 

**Messgae :** 

{{ $details['message'] }} 



Thanks,<br>
{{ config('app.name') }}
@endcomponent