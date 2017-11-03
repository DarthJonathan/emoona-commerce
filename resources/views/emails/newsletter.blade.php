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
            src:url("{{ URL::to('css/font/Avenir.ttc') }}");
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
    </style>
</head>
<body>
<div class="wrapper">
    <div class="inside-wrapper">
        <table>
            <tr>
                <td>
                    <img src="{{ URL::to('img/logo.png') }}" alt="" id="logo">
                    <h1 class="title">{{ $newsletter->title }}</h1>
                </td>
                <tr>
                <td>
                    <p>{!! $newsletter->content !!}</p>
                </td>
            </tr>
        </table>
    </div><!--inside-wrapper-->
</div><!--wrapper-->
</body>

</html>