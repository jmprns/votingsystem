@extends('layouts.app')

{{-- HTML TITLE --}}
@section('html-title')
@endsection

{{-- CSS VENDOR --}}
@section('css-top')
<link href="{{ asset('vendor/dataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

{{-- CSS STYLES --}}
@section('css-bot')
@endsection

{{-- Bread --}}
@section('bread')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Settings</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/dashboard">Voting System</a>
            </li>
            <li class="active">
                <strong>Settings</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endsection

{{-- MAIN CONTENT --}}
@section('main')
<div class="row m-t-lg">

    <div class="col-lg-12">
        <div class="tabs-container">

            <div class="tabs-left">
                <ul class="nav nav-tabs">

                    <li class="active"><a data-toggle="tab" href="#information"> Information</a></li>
                    <li class=""><a data-toggle="tab" href="#profile"> Profile</a></li>
                    <li class=""><a data-toggle="tab" href="#account"> Accounts</a></li>
                    <li class=""><a data-toggle="tab" href="#data"> Data</a></li>

                </ul>

                <div class="tab-content ">

                    <div id="information" class="tab-pane active">
                        <div class="panel-body">
                            Information
                        </div>
                    </div>

                    <div id="profile" class="tab-pane">
                        <div class="panel-body">
                            @include('settings.profile')
                        </div>
                    </div>

                    <div id="account" class="tab-pane">
                        <div class="panel-body">
                            @include('settings.accounts')
                        </div>
                    </div>

                    <div id="data" class="tab-pane">
                        <div class="panel-body">
                            @include('settings.datas')
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    
</div>
@endsection

{{-- JS VENDOR --}}
@section('js-top')
<script src="{{ asset('vendor/dataTables/datatables.min.js') }}"></script>
@endsection

{{-- JS SECTION --}}
@section('js-bot')
<script>
$(document).ready(function(){
    $('.admin-table').DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'print',
                title: '',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).prepend(
                        "<h2 align='center'>Position List</h2>"
                    );

                    $(win.document.body).prepend(
                        '<h1 align="center">Administrator List</h1>'
                    );
                    
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            },
                autoPrint:false,
                exportOptions:{
                    columns: [0,1,2,3,4],
                    stripHtml: false
                }

            }
        ]

    });

    $('.data-account-table').DataTable({
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            { extend: 'copy'},
            {extend: 'print',
                title: '',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).prepend(
                        '<h1 align="center">Administrator List</h1>'
                    );
                    
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                }
            }
        ]

    });
});

$('#add-admin-form').submit(function(e){

e.preventDefault();

    $.ajax({
    url: "/settings/admin/add",
    type: 'POST',
    dataType: 'json',
    data:{
        '_token' : $("meta[name='_token']").attr("content"),
        'lname' : $('#add-admin-lname').val(),
        'fname' : $('#add-admin-fname').val(),
        'mname' : $('#add-admin-mname').val(),
        'username' : $('#add-admin-username').val(),
        'password' : $('#add-admin-pass').val(),
        'cpassword' : $('#add-admin-cpass').val()
    },
    success:function(Result)
    {   
        swal({
                title: "Success",
                text: "The user has been registered.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }, function () {
               location.reload();
        });
    },
    error:function(xhr){
        if(xhr.status == 406){
            var message_er = JSON.parse(xhr.responseText);
            toastr.error(message_er['message']);
        }else if(xhr.status == 422){
            toastr.error("Certain fields are required!");
        }
    },
    beforeSend: function(){
        var element = document.getElementById('account');
        element.classList.add("whirl", "traditional");
    },
    complete: function(){
        var element = document.getElementById('account');
        element.classList.remove("whirl", "traditional");
    }
    });

});

$('#update-profile-form').submit(function(e){

    e.preventDefault();

    $.ajax({
    url: "/settings/admin/update",
    type: 'POST',
    dataType: 'json',
    data:{
        '_token' : $("meta[name='_token']").attr("content"),
        'lname' : $('#update-admin-lname').val(),
        'fname' : $('#update-admin-fname').val(),
        'mname' : $('#update-admin-mname').val(),
        'type'  : 1
    },
    success:function(Result)
    {   
        swal({
                title: "Success",
                text: "The profile has been updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }, function () {
               location.reload();
        });
    },
    error:function(xhr){
        if(xhr.status == 406){
            var message_er = JSON.parse(xhr.responseText);
            toastr.error(message_er['message']);
        }else if(xhr.status == 422){
            toastr.error("Certain fields are required!");
        }
    },
    beforeSend: function(){
        var element = document.getElementById('profile');
        element.classList.add("whirl", "traditional");
    },
    complete: function(){
        var element = document.getElementById('profile');
        element.classList.remove("whirl", "traditional");
    }
    });

});

$('#update-credential-form').submit(function(e){

    e.preventDefault();

    $.ajax({
    url: "/settings/admin/update",
    type: 'POST',
    dataType: 'json',
    data:{
        '_token' : $("meta[name='_token']").attr("content"),
        'opass' : $('#update-opass').val(),
        'npass' : $('#update-npass').val(),
        'cpass' : $('#update-cpass').val(),
        'type'  : 2
    },
    success:function(Result)
    {   
        swal({
                title: "Success",
                text: "The credentials has been updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: false
            }, function () {
            location.reload();
        });
    },
    error:function(xhr){
        if(xhr.status == 406){
            var message_er = JSON.parse(xhr.responseText);
            toastr.error(message_er['message']);
        }else if(xhr.status == 422){
            toastr.error("Certain fields are required!");
        }
    },
    beforeSend: function(){
        var element = document.getElementById('profile');
        element.classList.add("whirl", "traditional");
    },
    complete: function(){
        var element = document.getElementById('profile');
        element.classList.remove("whirl", "traditional");
    }
    });

});


function deleteAdmin(id){
    swal({
        title: "Delete this user?",
        text: "All related informations to this user will also be removed. Continue?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function () {
       window.location = '/settings/admin/delete/'+id;
    });
}
</script>
@endsection