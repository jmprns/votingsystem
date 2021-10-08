@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')

@endsection

{{-- Top Css --}}
@section('css-top')

@endsection

{{-- Bottom Css --}}
@section('css-bot')

@endsection

{{-- Page Title --}}
@section('page-title')
{{ $elc->elc_name }} <small>Result</small>
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li>
	<a href="/admin/election">Election</a>
</li>
<li>
	<a href="/admin/election/precinct/show/{{ $elc->id }}">{{ $elc->elc_name }}</a>
</li>
<li>
    <a href="/admin/election/result/{{ $elc->id }}">Result</a>
</li>
<li class="active">
	Error
</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-10">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="index.html" class="text-success">
                                            VOTING SYSTEM
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                               
                                <div class="text-center m-b-20">
                                        <div class="m-b-20">
                                            <h1 style="font-size:70px; color: red;">OPEN</h1>
                                        </div>
                                        <p class="text-muted font-13 m-t-10">
                                           The voting system that you have been requesting to generate result is still <strong>open.</strong> Please try again later.
                                        </p>
                                        <br>
                                        
                                    </div>
                               
                                </div>
                            </div>
                            <!-- end card-box-->


                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
@endsection

{{-- Top Page Js --}}
@section('js-top')

@endsection

{{-- Bottom Js Script --}}
@section('js-bot')

@endsection