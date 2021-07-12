@component('mail::message')
    # Hello {{ $details['user_info'] }}
    ## Congratulations.  Youhas activated your account.
     {{ $a = $details['reset_url'] }}
    @component('mail::button', ['url' =>  $a  ])
        Reset Password  {{$details['user_info']}}
        Thanks <br>
    @endcomponent
@endcomponent
