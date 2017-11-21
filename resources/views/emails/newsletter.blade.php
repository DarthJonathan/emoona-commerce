@component('mail::message')
# {{ $newsletter->title }}

<p align="center">
    <img align="center" src="/storage/img/logo.png" width="20%" alt="">
</p>

{!! $newsletter->content !!}

@component('mail::subcopy')
    Need Help?
    Contact Us Through
    help@emoonastudio.com
@endcomponent
@endcomponent