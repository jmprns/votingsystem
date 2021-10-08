@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Dashboard
@endsection

{{-- Top Css --}}
@section('css-top')

@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
Dashboard
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li class="active">
	Dashboard
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<!-- Hero -->
                        <div class="row">

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box tilebox-two tilebox-success">
                                    <i class="mdi mdi-archive pull-right text-dark"></i>
                                    <h6 class="text-success text-uppercase m-b-15 m-t-10">Elections</h6>
                                    <h2 class="m-b-10">{{ $count['elc'] }}</h2>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box tilebox-two tilebox-primary">
                                    <i class="mdi mdi-account-star pull-right text-dark"></i>
                                    <h6 class="text-success text-uppercase m-b-15 m-t-10">Candidates</h6>
                                    <h2 class="m-b-10">{{ $count['cand'] }}</h2>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box tilebox-two tilebox-inverse">
                                    <i class="mdi mdi-flag pull-right text-dark"></i>
                                    <h6 class="text-success text-uppercase m-b-15 m-t-10">Partylist</h6>
                                    <h2 class="m-b-10">{{ $count['party'] }}</h2>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="card-box tilebox-two tilebox-warning">
                                    <i class="mdi mdi-account pull-right text-dark"></i>
                                    <h6 class="text-success text-uppercase m-b-15 m-t-10">Voters</h6>
                                    <h2 class="m-b-10">{{ $count['users'] }}</h2>
                                </div>
                            </div>
                        </div>

                        @if($ongoing !== NULL)
                        
                        <!-- Ongoing Election -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Ongoing Election</h4>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="demo-box">
                                                <h4 class="header-title m-t-0">Election Details</h4>
                                                <div class="table-responsive"> 
                                                    <table class="table table-responsive table-hover m-0">
                                                        <tr>
                                                            <td><b>Election Name:</b></td>
                                                            <td>{{ $ongoing->elc_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Election Start:</b></td>
                                                            <td>{{ elc_time($ongoing->start) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Election End:</b></td>
                                                            <td>{{ elc_time($ongoing->end) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Positions:</b></td>
                                                            <td>{{ $ongoing->position_count }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Candidates:</b></td>
                                                            <td>{{ $ongoing->candidate_count }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Voters:</b></td>
                                                            <td>{{ $ongoing->voter_count }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Uncast Votes:</b></td>
                                                            <td>{{ $ongoing->uncast_count }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Casted Votes:</b></td>
                                                            <td>{{ $ongoing->cast_count }}</td>
                                                        </tr>
                                                    </table>
        
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="demo-box">
                                                @if($ongoing_position !== NULL)
                                                <h4 class="header-title m-t-0">Top Position Race</h4>
                                                {{-- <p class="text-muted font-13 m-b-30"> --}}
                                                     <canvas id="myChart" width="2px" height="1px"></canvas>
                                                {{-- </p> --}}
                                                @else
                                                <h4>No candidates found</h4>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->

                                </div>
                            </div>
                        </div>

                        <!-- Ongoing Election -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Other Positions</h4>
                                    <div class="row">
                                        @foreach($positions as $position)
                                        @if($loop->first)
                                            @continue
                                        @else
                                            <div class="col-lg-3">
                                                <div class="demo-box">
                                                    <canvas id="position-{{ $position->id }}" width="100%" height="120px"></canvas>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <!-- end row -->

                                </div>
                            </div>
                        </div>

                        @endif

                        <!-- Recent Row -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Recent Candidate</h4>

                                    <div class="table-responsive">
                                        <table class="table table table-hover m-0">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Election</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recent['candidate'] as $candidate)
                                                <tr>
                                                    <th>
                                                        <img src="{{ asset('media/candidates') }}/{{ $candidate->image }}" alt="user" class="thumb-sm img-circle" />
                                                    </th>
                                                    <td>
                                                        <h5 class="m-0">{{ $candidate->fname }} {{ $candidate->lname }}</h5>
                                                    </td>
                                                    <td>{{ $candidate->election->elc_name }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div> <!-- table-responsive -->
                                </div> <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Recent Voter</h4>

                                    <div class="table-responsive">
                                        <table class="table table table-hover m-0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Election</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($recent['users'] as $voter)
                                                <tr>
                                                    <td>{{ $voter->id }}</td>
                                                    <td>
                                                        <h5 class="m-0">{{ $voter->fname }} {{ $voter->lname }}</h5>
                                                    </td>
                                                    <td>{{ $voter->elc->elc_name }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div> <!-- table-responsive -->
                                </div> <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
@endsection

{{-- Top Page Js --}}
@section('js-top')
<!--Canvas Chart-->
<script type="text/javascript" src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
@endsection

{{-- Bottom Js Script --}}
@section('js-bot')
@if($ongoing !== NULL)
<script>
$(document).ready(function () {

var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: [
            @php($x = 1)
            @foreach($ongoing_candidate as $cand)
                @if(Auth::user()->lvl == 0)
                    "{{ $cand->lname }}, {{ $cand->fname }} {{ $cand->mname }}.",
                @else
                    "Candidate {{ $x++ }}",
                @endif
            @endforeach 
            'Uncast'
        ],
        datasets: [{
            label: '# of Votes',
            data: [
                @foreach($ongoing_candidate as $cand)
                {{ $cand->votes }},
                @endforeach
                {{ $ongoing->uncast_count }}
            ],
            backgroundColor: [
                @foreach($ongoing_candidate as $cand)
                    '{{ color_generate() }}',
                @endforeach
                
            ]
        }]
    },
    options: {
        legend: {
            display: false
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
            position: 'top',
            text: '@if($ongoing_position !== NULL) {{$ongoing_position->position_name}} @else  @endif'
        }
    }
});


@foreach($positions as $position)
@if ($loop->first) @continue @endif
var ctx{{ $position->id }} = document.getElementById("position-{{ $position->id }}");
var myChart{{ $position->id }} = new Chart(ctx{{ $position->id }}, {
    type: 'horizontalBar',
    data: {
        labels: [
            @php($x = 1)
            @foreach($position->candidate as $candidate)
                @if(Auth::user()->lvl == 0)
                    "{{ $candidate->lname }}, {{ $candidate->fname }} {{ $candidate->mname }}.",
                @else
                    "Candidate {{ $x++ }}",
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
                {{ $ongoing->uncast_count }}
            ],
            backgroundColor: [
                @foreach($position->candidate as $candidate)
                    '{{ color_generate() }}',
                @endforeach
                
            ]
        }]
    },
    options: {
        legend: {
            display: false
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
            position: 'top',
            text: '{{ $position->position_name }}'
        }
    }
});
@endforeach

    
});

</script>
@endif
@endsection