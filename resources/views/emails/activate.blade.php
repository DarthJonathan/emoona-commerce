@component('mail::message')
# Hello

<p align="center">
    <img align="center" src="{{ URL::to('/storage/img/logo.png') }}" width="20%" alt="">
</p>

THANK YOU FOR SIGNING UP

Please click the link below to confirm your email.

@component('mail::button', ['url' => URL::to('/activate/' . $activation_code), 'color' => 'blue'])
Activate Account
@endcomponent

@component('mail::subcopy')
    Need Help?
    Contact Us Through
    help@emoonastudio.com
@endcomponent
@endcomponent