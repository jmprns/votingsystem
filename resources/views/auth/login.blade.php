<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ballot Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{asset('media/favicon.ico')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
 
  <link rel="stylesheet" type="text/css" href="{{ asset('css/ballot/login2.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/ballot/login.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('vendor/whirl/whirl.min.css') }}">

</head>
<body>
  
  <div class="limiter">
    <div class="container-login100" style="background-image: url('{{ asset('media/bg') }}/{{ lbg() }}');">
      <div class="wrap-login100 p-t-30 p-b-50">


        <span class="login100-form-title p-b-41">
          <img src="{{ asset('media/seal.png') }}" alt="" width="100px" height="100px">

          <br>

          WU-P AURORA <br> ONLINE VOTING SYSTEM
        </span>
        <form id="voter-login-form" method="POST" action="/login" class="login100-form validate-form p-b-33 p-t-5">
        @csrf
          <div class="wrap-input100">
            <input class="input100" type="text" id="email" name="id" placeholder="User I.D.">
          </div>

          <div class="wrap-input100">
            <input class="input100" type="password" name="password" id="password" placeholder="Password">
          </div>

          <div class="container-login100-form-btn m-t-32">
            <button class="login100-form-btn" onclick="submit_form()">
              Login
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
   

  
  <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('vendor/swal2/swal2.min.all.js') }}"></script>
  <script type="text/javascript">

    
    function submit_form()
  {

    if($('#email').val() == ''){

      swal('Error!', 'User ID is required', 'error');
      $('#voter-login-form').attr('onsubmit','return false;');
  
    }else if($('#password').val() == ''){
      swal('Error!', 'Password is required', 'error');
     $('#voter-login-form').attr('onsubmit','return false;');
    }else{
      $('#voter-login-form').attr('onsubmit','return true;');
       var element = document.getElementById('voter-login-form');
      element.classList.add("whirl", "traditional");
      $("#voter-login-form").submit();
    }

  

  }

  @if(session('message') == 'error')
    swal('Error!', 'Invalid credentials', 'error');
  @endif
  </script>

</body>
</html>