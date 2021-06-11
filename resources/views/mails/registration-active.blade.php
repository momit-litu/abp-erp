@component('mail::message')
# Hello {{$center->name}}
## Congratulations. {{ config('app.name') }}  has activated your account.
@component('mail::panel')
You can now sign in to {{ config('app.name') }} portal
@endcomponent
<br>
@component('mail::button', ['url' => config('app.url')  ])
Sign in to {{ config('app.name') }} as {{$center->name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

