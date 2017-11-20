{{--  <html>
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
            text-align: center;
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
            width:100%;
            text-align: center;
        }

        img {
            width: 200px;
            margin:auto;
        }
    </style>

</head>
<body>
<div class="wrapper">
    <div class="inside-wrapper">
        <table>
            <tr>
                <td>
                    <img src="{{ $message->embed(public_path() . '/img/logo.png') }}" alt="" id="logo">
                    <div class="title">
                        THANKS FOR SIGNING UP
                        <br>
                    </div><!--title-->
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Context">
                        <div class="text">
                            You're one step away from receiving news from us
                            <br>
                            click the link below to confirm your email.
                        </div><!--text-->

                        <div class="button">
                            <a href="{{ URL::to('/activate/' . $activation_code) }}">
                                <button class="btn btn-default" id="btnVerify">Verify Email Address</button>
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

</html>  --}}

@component('mail::message')
# Hello

THANK YOU FOR SIGNING UP

Please click the link below to confirm your email.

@component('mail::button', ['url' => '/activate/' . $activation_code, 'color' => 'blue'])
Activate Account
@endcomponent

@component('mail::subcopy')
    Need Help?
    Contact Us Through
    help@emoonastudio.com
@endcomponent