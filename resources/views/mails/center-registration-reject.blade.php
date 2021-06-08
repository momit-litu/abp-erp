@component('mail::message')
# Hello {{$center->name}}
## Sorry. {{ config('app.name') }}  has rejected your registration.
@component('mail::panel')
Please contact with {{ config('app.name') }} for further query.
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

