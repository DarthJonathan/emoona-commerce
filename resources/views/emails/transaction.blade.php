@component('mail::message')
# Your Transaction for Today

<p align="center">
    <img align="center" src="/storage/img/logo.png" width="20%" alt="">
</p>

Thank you for your transaction, below is the detail for your transaction.

@component('mail::table')
| Item No.  | Item Name     | Quantity  | Price |
| :-------  |:--------------| ---------:| -----:|
@foreach($data['transaction']['cart'] as $key => $item)
| {{ ($key+1) }}     | {{ $item->name }}      | {{ $item->quantity }} |  IDR {{ $item->getPriceSum() }}   |
@endforeach
| | | Total Price | IDR {{ Cart::getTotal() }} |
@endcomponent

@component('mail::button', ['url' => '/verify_payment/' . $data['transaction']['transaction_code'], 'color' => 'blue'])
Verify Your Payment
@endcomponent

@component('mail::subcopy')
    Need Help?
    Contact Us Through
    help@emoonastudio.com
@endcomponent
@endcomponent