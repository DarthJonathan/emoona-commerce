@extends ('layouts.admin')

@section('title', 'Admin Dashboard')
@section('dashboard_active', 'class=active')

@section('content')
<div class="container">
    <div class="row">
            <pre>
                <?php print_r($last_week->toArray()); ?>
            </pre>
        <div class="col-lg-12">
            <canvas id="lastWeel" width="400" height="400"></canvas>
        </div>
        <div class="col-lg-6">

        </div>
    </div>
</div>
<script>
    var ctx = document.getElementById("lastWeek").getContext('2d');
    var lastWeek = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($last_week as $day)
                '{!! \Carbon\Carbon::parse($day['date'])->format('D, d M Y') !!}',
                @endforeach
            ],
            datasets: [{
                label: '# of Votes',
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
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
@endsection