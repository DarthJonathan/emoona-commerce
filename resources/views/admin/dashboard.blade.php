@extends ('layouts.admin')

@section('title', 'Admin Dashboard')
@section('dashboard_active', 'class=active')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 lastweekChart">
            <h2 class="my-3">Visitors in the last 7 Days</h2>
            <canvas id="lastWeek"></canvas>
        </div>
        <div class="col-lg-6 my-5">
            <h3 class="my-3">Visitor Right Now</h3>
            <canvas id="visitorRightNow"></canvas>
        </div>
        <div class="col-lg-6 my-5">
            <h3 class="my-3">Visitor Right Now</h3>
        </div>
    </div>
</div>
<script>
    var lastweek = document.getElementById("lastWeek").getContext('2d');

    var options = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    };

    var lastweekChart = new Chart(lastweek, {
        type: 'bar',
        data: {
            labels: [
                @foreach($last_week as $day)
                '{!! \Carbon\Carbon::parse($day['date'])->format('D, d M Y') !!}',
                @endforeach
            ],
            datasets: [{
                label: '# of Visitors',
                data: [
                    @foreach($last_week as $day)
                    {!! $day['visitors'] !!},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: options
    });
</script>
@endsection