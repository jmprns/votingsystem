@extends('admin.layouts.app')

{{-- HTML Title --}}
@section('title')
Settings
@endsection

{{-- Top Css --}}
@section('css-top')

@endsection

{{-- Bottom Css --}}
@section('css-bot')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppie/croppie.css') }}">
<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Page Title --}}
@section('page-title')
Settings
@endsection

{{-- Breadcrumb --}}
@section('breadcrumb')
<li>
	<a href="/admin/dashboard">Voting System</a>
</li>
<li class="active">Settings</li>
@endsection

{{-- Main Content --}}
@section('main-content')
<div class="row">
    <div class="col-md-6">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">System Information</h4>
                <table class="table table table-hover m-0">
                            <thead>
                                <tr>
                                    <th width="60%">Information</th>
                                    <th width="40%">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>System Name</td>
                                    <td>Voting System</td>
                                </tr>
                                <tr>
                                    <td>Markup Layout</td>
                                    <td>HTML5/CSS3-Bootstrap</td>
                                </tr>
                                <tr>
                                    <td>Programming Language</td>
                                    <td>PHP-OOP</td>
                                </tr>
                                <tr>
                                    <td>PHP Version</td>
                                    <td>7</td>
                                </tr>
                                <tr>
                                    <td>PHP Framework</td>
                                    <td>Laravel 5.6</td>
                                </tr>
                                <tr>
                                    <td>Database</td>
                                    <td>votingsystem</td>
                                </tr>
                                <tr>
                                    <td>Installed Date</td>
                                    <td>{{ elc_time($settings['insd']) }}</td>
                                </tr>
                            </tbody>
                </table>
        </div>
    </div> <!-- end col -->

    <div class="col-md-6">
        <div id="profile-whirl" class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Profile Settings</h4>

            <ul class="nav nav-tabs tabs-bordered nav-justified">
                <li class="active">
                    <a href="#profile-1" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Basic</span>
                    </a>
                </li>
                <li class="">
                    <a href="#profile-2" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Information</span>
                    </a>
                </li>
                <li class="">
                    <a href="#profile-3" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                        <span class="hidden-xs">Credentials</span>
                    </a>
                </li>
                <li class="">
                    <a href="#profile-4" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                        <span class="hidden-xs">Image</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="profile-1">
                   <div class="row">
                       <div class="col-md-4">
                            <img src="{{ asset('media/admin') }}/{{ Auth::user()->image }}" alt="" class="img-thumbnail">
                       </div>
                       <div class="col-md-8">
                           <h2>{{ Auth::user()->fname }} {{ Auth::user()->mname }}. {{ Auth::user()->lname }}</h2>
                           <h4 class="header-title">&commat;{{ Auth::user()->username }} || {{ Auth::user()->position }}</h4>
                       </div>
                   </div>
                </div>
                <div class="tab-pane" id="profile-2">
                <form id="setting-admin-info" method="POST" class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">First Name</label>
                            <div class="col-md-10">
                                <input type="text" id="admin-fname" class="form-control" value="{{ Auth::user()->fname }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Last Name</label>
                            <div class="col-md-7">
                                <input type="text" id="admin-lname" class="form-control" value="{{ Auth::user()->lname }}" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="admin-mname" class="form-control" value="{{ Auth::user()->mname }}" required minlength="1" maxlength="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Position</label>
                            <div class="col-md-10">
                                <input type="text" id="admin-pos" class="form-control" placeholder="School Head" value="{{ Auth::user()->position }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <input type="submit" value="Save" class="btn btn-block btn-bordered btn-primary">
                        </div>
                    </div>
                </form>
                </div>
                <div class="tab-pane" id="profile-3">
                    <form id="setting-admin-pass" method="POST" class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Username</label>
                            <div class="col-md-10">
                                <input type="text" id="last-name" class="form-control" value="{{ Auth::user()->username }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Old password</label>
                            <div class="col-md-10">
                                <input type="text" id="old-pass" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-2 control-label">New password</label>
                            <div class="col-md-10">
                                <input type="text" id="new-pass" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <input type="submit" value="Save" class="btn btn-block btn-bordered btn-primary">
                        </div>
                    </div>
                </form>
                </div>
                <div class="tab-pane" id="profile-4">
                    <div class="row">
                    <form id="setting-admin-image" method="POST">
                       <div class="col-md-4">
                            <img id="edit-avatar" src="{{ asset('media/admin') }}/{{ Auth::user()->image }}" alt="" class="img-thumbnail">
                       </div>
                       <div class="col-md-8">
                           <input type="hidden" id="crop-image" value="" required>
                            <input type="file" name="upload_image" id="upload_image" accept="image/*" data-buttonbefore="true" class="filestyle" required>
                           <br>
                           <button class="btn btn-bordered btn-primary btn-lg">Save</button>
                       </div>
                    </form>
                   </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->   
</div>

@if(Auth::user()->lvl == 0)
<div class="row">
    <div class="col-md-6">
        <div id="system-whirl" class="card-box">
            <h4 class="header-title m-t-0 m-b-30">System Settings</h4>

            <ul class="nav nav-tabs tabs-bordered nav-justified">
                <li class="active">
                    <a href="#system-2" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Partylist</span>
                    </a>
                </li>
                <li class="">
                    <a href="#system-3" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                        <span class="hidden-xs">Account</span>
                    </a>
                </li>
                @if(Auth::user()->lvl == 0)
                <li class="">
                    <a href="#system-4" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-cog"></i></span>
                        <span class="hidden-xs">Data</span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="system-2">
                     <a href="/admin/partylist" target="_new" class="btn btn-bordered btn-block btn-danger">Open Partylist Page</a>
                </div>
                <div class="tab-pane" id="system-3">
                    <table class="table table table-hover m-0">
                            <thead>
                                <tr>
                                    <th width="10%">Image</th>
                                    <th width="50%">Name</th>
                                    <th width="35%">Username</th>
                                    <th width="5%" align="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($admins as $admin)
                                @if($admin->id == Auth::user()->id)
                                @continue
                                @else
                                    <tr id="admin-tr-{{ $admin->id }}">
                                        <td><img src="{{ asset('media/admin') }}/{{ $admin->image }}" class="img-circle img-thumbnail"></td>
                                        <td>{{ $admin->fname }} {{ $admin->lname }}</td>
                                        <td>{{ $admin->username }}</td>
                                        @if($admin->lvl !== '0')
                                        <td>
                                            <button onclick="delete_admin('{{ $admin->id }}')" class="btn btn-icon btn-sm waves-effect waves-light btn-danger m-b-5"> <i class="fa fa-remove"></i> </button>
                                        </td>
                                        @endif
                                    </tr>
                                
                                @endif
                                @endforeach
                            </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6"><h4 class="header-title"></h4><a href="/admin/settings/add-admin" class="btn btn-bordered btn-block btn-primary">Add another admin</a></div>
                    </div>
                </div>
                @if(Auth::user()->lvl == 0)
                <div class="tab-pane" id="system-4">
                    <div class="row">
                        <div class="col-md-4"><hr></div>
                        <div class="col-md-4 text-center"><h4 class="header-title">Logs</h4></div>
                        <div class="col-md-4"><hr></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="/admin/log/voter" target="_new" class="btn btn-block btn-bordered btn-danger">Voters</a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/log/votes" target="_new" class="btn btn-block btn-bordered btn-danger">Votes</a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/log/admin" target="_new" class="btn btn-block btn-bordered btn-danger">Admin</a>
                        </div>
                        <div class="col-md-3">
                            <a href="/admin/log/activity" target="_new" class="btn btn-block btn-bordered btn-danger">Activity</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><hr></div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div> <!-- end col -->

    <div class="col-md-6">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">Departments</h4>
            <div class="row">
                <div class="col-md-4"><hr></div>
                <div class="col-md-4 text-center"><h4 class="header-title">Add</h4></div>
                <div class="col-md-4"><hr></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="#" data-toggle="modal" data-target="#modal-add-dept" class="btn btn-block btn-bordered btn-primary">Add Department</a>
                </div>
                <div class="col-md-6">
                    <a href="#" data-toggle="modal" data-target="#modal-add-year" class="btn btn-block btn-bordered btn-success">Add Year</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <a href="#" data-toggle="modal" data-target="#modal-dept-map" class="btn btn-block btn-bordered btn-inverse">Department Map</a>
                </div>
            </div>
        </div>
    </div> <!-- end col -->   
</div>
@endif

<div class="row">
    <div class="m-t-50 p-t-10">
                <h4 class="text-uppercase text-center">People Behind this Project</h4>
                <hr>

                <div class="row about-team text-center">

                    <!-- team-member -->
                    <div class="col-sm-3">
                        <div class="about-team-member">
                            <img src="{{ asset('media/researcher/1.jpg') }}" alt="team-member" class="img-responsive img-circle">
                            <h4>Jimwell Parinas</h4>
                            <p>Developer</p>
                        </div>
                    </div>

                    <!-- team-member -->
                    <div class="col-sm-3">
                        <div class="about-team-member">
                            <img src="{{ asset('media/researcher/2.jpg') }}" alt="team-member" class="img-responsive img-circle">
                            <h4>Arianne Gulla</h4>
                            <p>Analyst</p>
                        </div>
                    </div>

                    <!-- team-member -->
                    <div class="col-sm-3">
                        <div class="about-team-member">
                            <img src="{{ asset('media/researcher/3.jpg') }}" alt="team-member" class="img-responsive img-circle">
                            <h4>Sarah Jane Catipon</h4>
                            <p>Beta Tester</p>
                        </div>
                    </div>

                    <!-- team-member -->
                    <div class="col-sm-3">
                        <div class="about-team-member">
                            <img src="{{ asset('media/researcher/4.jpg') }}" alt="team-member" class="img-responsive img-circle">
                            <h4>Christian Jay Campos</h4>
                            <p>Beta Tester</p>
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div>
</div>


<!-- Modal Image -->
<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-12 text-center">
        <div id="image_demo"></div>
       </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success crop_image">Crop</button>
        </div>
     </div>
    </div>
</div><!-- /.modal -->


{{-- Modal Reset --}}
<div id="reset-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Reset Applications</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Reset Application Wizard</h4>
                <p>Proceeding to this action will:</p>
                <ul>
                    <li>Delete all the data related to the elections like reports, candidates, etc.</li>
                    <li>Removing other administrator and making a default super admin.</li>
                    <li>Reset the SMS settings which can cause malfunction in the system.</li>
                    <li>Deleting the logs like the login logs of the administrators and the voters.</li>
                </ul>

                <p>If you wish to continue please enter your password:</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <form id="setting-reset-form" method="POST">
                                <input type="password" class="form-control" id="reset-pwd" placeholder="Your Password">
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-lg btn-block btn-inverse" value="Reset">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



{{-- Modal ADD DEPT --}}
<div id="modal-add-dept" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="modal-add-dept-whirl" class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Department</h4>
            </div>
            <div class="modal-body">
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <input type="text" class="form-control" id="dept-name" required placeholder="Department Name">
                        </div>
                    </div>
                </div>
                <button type="submit" onclick="add_dept()" class="btn btn-lg btn-block btn-primary">Add</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Modal ADD YEAR --}}
<div id="modal-add-year" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="modal-add-year-whirl" class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Year</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <select id="dept-select" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($department as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->dept_name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <input type="text" class="form-control" id="year-name" required placeholder="Year Name">
                        </div>
                    </div>
                </div>

                <button type="submit" onclick="add_year()" class="btn btn-lg btn-block btn-primary">Add</button>
                

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{-- Modal DEPT MAP --}}
<div id="modal-dept-map" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div id="dept-map-whirl" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Department Map</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    @foreach($department as $dept)
                   <div class="col-md-6">
                       <details>
                      <summary><span class="text-primary lead m-t-0">{{ $dept->dept_name }}</span></summary>
                        <ul>
                            <li><a href="#" onclick="delete_dept('{{ $dept->id }}')">Delete Department</a></li>
                            @foreach($dept->year as $year)
                                <li>{{ $dept->dept_name }} - {{ $year->year_name }} | <a href="#" onclick="delete_year('{{ $year->id }}')">Delete</a></li>
                            @endforeach
                        </ul>
                    </details>
                   </div>
                @endforeach
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
                                 

                                   


@endsection

{{-- Top Page Js --}}
@section('js-top')
<script src="{{ asset('vendor/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/croppie/croppie.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/exif.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
@endsection
 
{{-- Bottom Js Script --}}
@section('js-bot')
<script src="{{ asset('js/admin/settings.js') }}"></script>
@endsection