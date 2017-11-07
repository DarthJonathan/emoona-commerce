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
            <h3 class="my-3">Most Visited Page</h3>
            <div class="mt-5">
                <h2>{{ $most_visited[1]['pageViews'] }}</h2>
                <h4>{{ $most_visited[1]['pageTitle'] }}</h4>
            </div>
        </div>
        <div class="col-lg-6 my-5 row">
            <div class="col-lg-12">
                <h3 class="my-2">User Types</h3>
            </div>
            <div class="col-lg-6 mt-5">
                <h2>{{ $user_type[0]['sessions'] }}</h2>
                <h4>{{ $user_type[0]['type'] }}</h4>
            </div>
            <div class="col-lg-6 mt-5">
                <h2>{{ $user_type[1]['sessions'] }}</h2>
                <h4>{{ $user_type[1]['type'] }}</h4>
            </div>
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