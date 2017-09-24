<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1
    ,user-scalable=0"
    >
    <title>Not Found</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_404.css') }}">

    <script type="text/javascript" src ="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script type="text/javascript" src ="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src ="{{ asset('js/bootstrap.min.js') }}"></script>


</head>
<body>

<div class="main-wrapper">
    <div class="text-container">
        <div id="scene" class="scene">
            <div class="hidden-md-down">
                <div class="layer" data-depth="0.30" id="l1">
                    <div class="obj level1 object-1"><img src="{{ asset('img/l1.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.50" id="l2">
                    <div class="obj level2 object-2"><img src="{{ asset('img/l2.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.60" id="l3">
                    <div class="obj level3 object-3"><img src="{{ asset('img/l3.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.30" id="l4">
                    <div class="obj level4 object-4"><img src="{{ asset('img/l4.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.50" id="l5">
                    <div class="obj level5 object-5"><img src="{{ asset('img/l5.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.40" id="l6">
                    <div class="obj level6 object-6"><img src="{{ asset('img/l6.png') }}"></div>
                </div>

            </div><!--hideen-md-down-->

            <div class="hidden-lg-up">
                <div class="layer" data-depth="0.30" id="l1">
                    <div class="obj level1 object-1 img1" style=""><img src="{{ asset('img/l1.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.30" id="l1">
                    <div class="obj level1 object-1 img2" style=""><img src="{{ asset('img/l2.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.30" id="l1">
                    <div class="obj level1 object-1 img3" style=""><img src="{{ asset('img/l4.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.30" id="l1">
                    <div class="obj level1 object-1 img4" style=""><img src="{{ asset('img/l5.png') }}"></div>
                </div>

                <div class="layer" data-depth="0.30" id="l1">
                    <div class="obj level1 object-1 img5" style=""><img src="{{ asset('img/l6.png') }}"></div>
                </div>
            </div><!--hidden-md-up-->
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="text">
                        <div class="text1">
                            404
                        </div>
                        <div class="text2">
                            Look Like You've Lost Your Way
                        </div>
                        <div class="button">
                            <a href="{{ route('home') }}">
                                <button
                                    class="btn btn-default"
                                    style="cursor:pointer"
                                >
                                Go Back Home</button>
                            </a>
                        </div>
                    </div><!--text-->

                </div>
            </div><!--row-->
        </div>
    </div>
</div>

<script type="text/javascript" src ="{{ asset('js/parallax.min.js') }}"></script>

<script>
    var scene = document.getElementById('scene');
    var parallax = new Parallax(scene);
    var min_x = -50;
    var min_y = 0;
    var max_x = $(document).width()-50;
    var max_y = $(document).height()-50;
    var filled_area = new Array();

    $('.obj').each(function()
    {
        do {
            var rand_x = Math.round(min_x + ((max_x - min_x) * (Math.random() % 2)));
            var rand_y = Math.round(min_y + ((max_y - min_y) * (Math.random() % 2)));

            area = {x: rand_x, y: rand_y, width: $(this).width(), height: $(this).height()}
        }while(checkOverlap(area));

        filled_area.push(area);
        $(this).css({left: rand_x, top:rand_y});
    });

    function checkOverlap (area)
    {
        for(var i = 0; i<filled_area.length; i++) {
            var left = area.x;
            var top = area.y;
            var right = area.x + area.width;
            var bottom = area.y + area.height;
            var left1 = filled_area[i].x;
            var top1 = filled_area[i].y;
            var right1 = filled_area[i].x + filled_area[i].width;
            var bottom1 = filled_area[i].y + filled_area[i].height;

            if(top > bottom1 || bottom < top1 || left > right1 || right < left1) {
                continue;
            }else {
                return true;
            }
        }

        return false;
    }

</script>

</body>
</html>