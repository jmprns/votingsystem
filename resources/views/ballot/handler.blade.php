
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Voting System | Ballot Handler</title>
    <link href="{{ asset('css/handler.css') }}" media="all" rel="stylesheet" type="text/css" />
    @if(!session('type'))
        <script>window.location = '/ballot';</script>
    @endif
</head>

<body>
@php
    switch (session('type')) {
        case 1:
            $title = 'Your vote has been casted';
            $message = 'Your vote has been successfully casted and recorded in the system.';
        break;

        case 2:
            $title = 'You already cast your vote.';
            $message = 'You already cast your vote and cannot process your ballot again. If you think this is a mistake, please seek an election officer for help.';
        break;

        case 3:
            $title = 'Election is closed.';
            $message = 'The election your requesting is closed as the moment. Please try again later.';
        break;

        case 4:
            $title = 'Election is finished.';
            $message = 'The election your requesting is already finished. Thank you for using Online Voting System.';
        break;
        
        default:
            # code...
        break;
    }
@endphp
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="content-wrap">
                            <table  cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <h1>Online Voting System</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <h3>{{ @$title }}</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                       Thank you for using Online Voting System. {{ @$message }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        To return in login page, please click the button below to redirect.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block aligncenter">
                                        <a href="/ballot" class="btn-primary">Return Login</a>
                                    </td>
                                </tr>
                              </table>
                        </td>
                    </tr>
                </table>
                <div class="footer">
                    <table width="100%">
                        <tr>
                            <td class="aligncenter content-block">Developed by: <a href="http://facebook.com/jp.pagapulan">Jimwell Parinas</a></td>
                        </tr>
                    </table>
                </div></div>
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
