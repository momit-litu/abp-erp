@component('mail::message')
# Hello {{$center->name}}
## Sorry. {{ config('app.name') }}  has deactivated your account.
@component('mail::panel')
Please contact with {{ config('app.name') }} for further query.
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

