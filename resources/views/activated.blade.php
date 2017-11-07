<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1 ,user-scalable=0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">


</head>
<style>
    body{
        margin:0;
        padding: 0;
    }
    @font-face{
        font-family: Emoona;
        src:url("{{ \Illuminate\Support\Facades\URL::to('assets/css/font/Avenir.ttc') }}");
    }

    .wrapper{
        background-color: #e3e3e3;
        height: 100vh;
        padding: 5%;
    }
    .inside-wrapper
    {
        display:flex;
        justify-content: center;
        align-items: center;
    }
    .inside-wrapper{
        background-color: white;
        border-radius: 10px;
        margin:  0;
        max-width:100%;
        text-align: center;
        font-family: Emoona;
        border-bottom:0px solid grey;
        height: 100%;

    }
    .title{

        font-size: 24px;
        letter-spacing: 10px;
        margin-top: 40px;
        font-weight: 300;
    }


    #logo{
        max-width: 130px;
        margin-top: 5%;
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
        padding:.5em 1.5em .5em 1.5em;
        color: white;
        background-color: black;
        transition: all .3s ease-in-out;
        font-family: Emoona;
    }
    .button button{
        cursor: pointer;
    }

    a{
        cursor: pointer;
    }

</style>
<body>
<div class="wrapper">
    <div class="inside-wrapper">
        <div class="container">

            <!--heading-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="header">
                        <img src="{{ public_path() . 'assets/img/logo.png' }}" alt="" id="logo">

                        <div class="title">
                            THANKS FOR VERIFYING YOUR EMAIL
                            <br>
                        </div><!--title-->
                    </div>

                </div>
            </div><!--row-->



            <div class="row">
                <div class="col-lg-12">
                    <div class="Context">
                        <div class="text">
                            You can now shop at our store,
                            <br>
                            We look forward to serve you.
                        </div><!--text-->

                    </div><!--Context-->
                </div>
            </div><!--row-->


        </div><!--container-->
    </div><!--inside-wrapper-->
</div><!--wrapper-->

</body>
</html>