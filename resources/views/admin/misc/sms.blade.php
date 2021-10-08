<!DOCTYPE html>
<html>
<head>
	<title>SMS SERVER</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/admin/sms.css') }}">
</head>
<body>


<center>
	<section>
		<h1><span id="sms_count">{{ $count }}</span></h1>
		<h2>Pending SMS</h2>
		@if($count == 0)
		<p>The page will refresh to fetch the SMS in <span id="countdowntimer">10 </span> seconds.</p>
		@else
		<p id="send-stat">Sending the SMS. Please wait, this may take a while.</p>
		@endif
	</section>
</center>


<script src="{{ asset('js/admin/jquery.min.js') }}"></script>

<script type="text/javascript">
	var count = {{ $count }};
	var token = '{{ csrf_token() }}';

	if(count > 0){

		$.ajax({
        url: "/sms",
        type: 'POST',
        dataType: 'json',
        data:{
            '_token' : token,
            'count' : count
             
        },
        success:function(Result)
        {   
             $("#send-stat").html("SMS sent successfully. Reloading the page....");
             location.reload();
        },
       
    });

	}else{
		setTimeout(function() {
    		location.reload();
		}, 10000);
	}
</script>
</body>
</html>