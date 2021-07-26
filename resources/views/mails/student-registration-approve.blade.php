@component('mail::message')
# Hello {{$student->name}}
## Congratulations. Your registration has been successfull.
@component('mail::panel')
Your username is: {{$student->email}}<br>
Your password is: {{config('app.student_default_password')}}
@endcomponent
<br>
*Important: Please change the password after signin for better security.*

@component('mail::button', ['url' => config('app.url')  ])
Sign in to {{ config('app.name') }} as {{$student->name}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

