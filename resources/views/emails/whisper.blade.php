@component('mail::message')
#Contact Us Form

@component('mail::table')
| Data      | Info          |
| :-------  | -------------:|
| Name      | {{ $data['name'] }}|
| Email     | {{ $data['email'] }}|
| Subject      | {{ $data['subject'] }}|
| Message      | {{ $data['message'] }}|
@endcomponent

@component('mail::subcopy')
    This email is computer generated. <br>
    Need Help? <br>
    Contact Us Through <br>
    help@emoonastudio.com <br>
@endcomponent
@endcomponent