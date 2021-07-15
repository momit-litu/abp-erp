@component('mail::message')
    <h2> Hello, {{ $details['user_info'] }} </h2>
    To reset your password, please click on the link below.
     @component('mail::button', ['url' =>  $details['reset_url']  ])
         Reset your password
     @endcomponent
    If you're having trouble, try copying and pasting the following URL into your browser:<br>
    <a href="{{  $details['reset_url'] }}">{{  $details['reset_url'] }} </a> <br>
    If you did not request this reset, you can ignore this email. It will expire in 1 hours.<br><br><br>
    Regards,<br>
    APB-BD
@endcomponent

