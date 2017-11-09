<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=0">
    <style>
        body{
            margin:0;
            padding: 0;
        }
        @font-face{
            font-family: Emoona;
            src:url("{{ \Illuminate\Support\Facades\URL::to('css/font/Avenir.ttc') }}");
        }

        .wrapper{
            background-color: #e3e3e3;
            height: 100vh;
            padding: 5%;
            box-sizing: border-box;

        }
        .inside-wrapper{
            background-color: white;
            border-radius: 10px;
            margin:  0;
            max-width:100%;
            text-align: center;
            font-family: Emoona;
            border-bottom:0px solid grey;
            display:flex;
            height: 100%;
            justify-content: center;
            align-items: center;
        }
        .title{

            font-size: 24px;
            letter-spacing: 10px;
            margin-top: 10px;
        }


        #logo{
            max-width: 130px;
            margin-top: 5%;
            margin-bottom: 20px;
        }
        .context{
            font-size: 18px;
            margin-top: 20px;
        }
        .button{
            text-align: left;
            margin-top: 30px;
            margin-bottom: 25px;
        }
        #btnVerify{
            padding:1em 2.5em 1em 2.5em;
            border:0;
            color: white;
            background-color: black;
            transition: all .3s ease-in-out;
            font-family: Emoona;
        }
        #btnVerify:hover {
            background:#e3e3e3;
        }
        .button button{
            cursor: pointer;
        }

        a{
            cursor: pointer;
            text-decoration: none;
        }
        table
        {
            padding-left: 50px;
            width:100%;
            text-align: left;
        }

        .cart
        {
            width: 70%;
            padding-left: 0;
        }
    </style>

</head>
<body>
<div class="wrapper">
    <div class="inside-wrapper">
        <table>
            <tr>
                <td>
                    <img src="{{ URL::to('img/logo.png') }}" alt="" id="logo">
                    <div class="title">
                        Your Transaction Today

                        <br>
                    </div><!--title-->
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Context">
                        <div class="text">
                            <table class="cart">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Item Name</td>
                                        <td>Quantity</td>
                                        <td>Price</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $count => $item)
                                    <tr>
                                        <td>{{ ($count+1) }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>IDR {{ $item->getPriceSum() }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">Total Quantity</td>
                                    <td>{{ Cart::getTotalQuantity() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">Total Price</td>
                                    <td>{{ Cart::getTotal() }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!--text-->

                        <div class="button">
                            <a href="{{ URL::to('/verify_payment/' . $transaction_code) }}">
                                <button class="btn btn-default" id="btnVerify">Verify Payment</button>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="note">
                        Need Help?
                        <p>Contact Us Through <br>
                            help@emoonastudio.com</p>
                    </div><!--Note-->
                </td>
            </tr>
        </table>
    </div><!--inside-wrapper-->
</div><!--wrapper-->
</body>

</html>