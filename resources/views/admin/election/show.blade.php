<!DOCTYPE html>
<html> 
<head>
    <meta http-equiv="refresh" content="180" />
	<title></title>
	<!-- App css -->
    <link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.carousel-fade .carousel-inner .item {
			opacity: 0;
			-webkit-transition-property: opacity;
			-moz-transition-property: opacity;
			-o-transition-property: opacity;
			transition-property: opacity;
			}
			.carousel-fade .carousel-inner .active {
			opacity: 1;
			}
			.carousel-fade .carousel-inner .active.left,
			.carousel-fade .carousel-inner .active.right {
			left: 0;
			opacity: 0;
			z-index: 1;
			}
			.carousel-fade .carousel-inner .next.left,
			.carousel-fade .carousel-inner .prev.right {
			opacity: 1;
			}
			.carousel-fade .carousel-control {
			z-index: 2;
			}
			html,
			body,
			.carousel,
			.carousel-inner,
			.carousel-inner .item {
			height: 100%;
			}
	</style>
</head>
<body>
<!-- START carousel-->
	<div id="carousel-example-captions-1" data-ride="carousel" class="carousel slide carousel-fade">
		<div role="listbox" class="carousel-inner">
            @foreach($positions as $position)
			<div class="item @if($loop->first) active @endif">
				<canvas id="position-{{ $position->id }}" width="2px" height="1px"></canvas>
			</div>
            @endforeach
		</div>

	</div>
	<!-- END carousel-->

<!-- jQuery  -->
<script src="{{ asset('js/admin/jquery.min.js') }}"></script>
<script src="{{ asset('js/admin/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/chart.js/label.min.js') }}"></script>


<script type="text/javascript">

$(window).keypress(function(e) {
    if (e.which === 32) {
        toggleFullScreen();
    }
});



function toggleFullScreen() {
  if (!document.fullscreenElement &&    // alternative standard method
      !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.msRequestFullscreen) {
      document.documentElement.msRequestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }
}


$(document).ready(function () {

Chart.plugins.unregister(ChartDataLabels);

@foreach($positions as $position)

var position{{ $position->id }} = document.getElementById("position-{{ $position->id }}");
var myChart = new Chart(position{{ $position->id }}, {
    plugins: [ChartDataLabels],
    type: 'horizontalBar',
    data: {
        labels: [
            @php($x = 1)
            @foreach($position->candidate as $candidate)
                @if(time() > $election->end)
                    "{{ $candidate->lname }}, {{ $candidate->fname }} {{ $candidate->mname }}.",
                @else
                    'Candidate {{ $x++ }}',
                @endif
                
            @endforeach
            'Uncast'
        ],
        datasets: [{
            label: '# of Votes',
            data: [
                @foreach($position->candidate as $candidate)
                    {{ $candidate->votes }},
                @endforeach 
                    {{ $election->uncast_count }}
            ],
            backgroundColor: [
                @foreach($position->candidate as $candidate)
                    '{{ color_generate() }}',
                @endforeach
                    '{{ color_generate() }}'
                
            ]
        }]
    },
    options: {
        legend: {
            display: false
        },
        plugins: {
            datalabels: { color : 'white' }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
        title: {
            display: true,
            fontSize: 28,
            position: 'top',
            text: '{{ $position->position_name }}'
        }
    }
});

@endforeach

    
});



</script>
</body>
</html>