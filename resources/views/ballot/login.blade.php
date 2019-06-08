
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Voting System | Ballot Login</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name" style="margin-left: -35px">OVS</h1>
            </div>
            <h3>Ballot Login</h3>
            <p>Welcome to Online Voting System.</p>
            <form class="m-t" role="form" method="POST" action="/ballot">
                @csrf
                <div class="form-group">
                    <input autofocus name="username" type="text" class="form-control" placeholder="User ID" required="">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <p class="m-t"> <small>Developed by: <a href="http://facebook.com/jp.pagapulan">Jimwell Parinas</a> &copy; {{ date('Y', time()) }}</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>
