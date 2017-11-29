@component('mail::message')
# {{ $newsletter->title }}

<p style="text-align: center">
    <img src="{{ URL::to('/storage/img/logo.png') }}" width="20%" alt="Emoona Logo">
</p>

@if($newsletter->images != null)
<p style="text-align: center">
    <img src="{{ URL::to('/storage/newsletter/' . $newsletter->images . '/image.jpg') }}" width="50%">
</p>
@endif

{!! $newsletter->content !!}

@component('mail::subcopy')
    Need Help?
    Contact Us Through
    help@emoonastudio.com
    <a href="{{ URL::to('/unsubscribe/' . $userid) }}">Unsubscribe</a>
@endcomponent
@endcomponent