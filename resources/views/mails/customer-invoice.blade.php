@component('mail::message')
# Hello Momit
## This email containing the invoice against the payment of <b>1st installment PGDHRM batch:14</b>
## Please find the invoice as attachment. {{ config('app.name') }}  has deactivated your account.
@component('mail::panel')
Please contact with {{ config('app.name') }} for further query.
@endcomponent
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

