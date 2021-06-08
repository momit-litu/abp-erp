@component('mail::message')
# Hello {{$center->name}}
## Congratulations. Your registration approved.
@component('mail::panel')
Your username is: {{$center->email}}<br>
Your password is: {{config('app.center_default_password')}}
@endcomponent
<br>
*Important: Please change the password after signin for better security.*

@component('mail::button', ['url' => config('app.url')  ])
Sign in to {{ config('app.name') }} as {{$center->name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

