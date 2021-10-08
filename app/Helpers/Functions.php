<?php

function isAlive($host, $port)
{
	$checkSMSGateway = @fsockopen($host, $port, $errorno, $errstr, 10 );
  	return (!$checkSMSGateway) ? FALSE : TRUE;
}

function voter_password($length = 6) 
{
    return substr(str_shuffle(str_repeat($x='234678wertypsdfghjkzxcbnm', ceil($length/strlen($x)) )),1,$length);
}

function lbg()
{
	$array = array('bg-01.jpg', 'bg-02.jpg', 'bg-03.jpg', 'bg-04.jpg', 'bg-05.jpg', 'bg-06.jpg', 'bg-07.jpg', 'bg-08.jpg', 'bg-09.jpg');

	$pick = shuffle($array);

	return $array[0];
}

function send_sms($number, $message)
{
	$type = env('SMS_SERVER');

	$message = $message."\n\n This is a system generated text message from WUP-Aurora. Do not reply.";

	if($type == 'OZEKI'){
		$send = sms_ozeki($number, $message);
	}elseif($type == 'AT'){
		$send = sms_at($number, $message);
	}elseif($type == 'ANDROID'){
		$send = sms_android($number, $message);
	}else{
		$send['code'] = '500';
	}

	return $send;

}


function sms_android($number, $message)
{
	
}

function sms_ozeki($number, $message)
{

	$host = env('SMS_HOST');
	$username = env('SMS_USER');
	$password = env('SMS_PASS');

	$message_encode = urlencode($message);

	$curl = curl_init();
	$url = "http://{$host}/api?action=sendmessage&username={$username}&password={$password}&recipient={$number}&messagetype=SMS:TEXT&messagedata={$message_encode}";

	curl_setopt_array($curl, array(
	   CURLOPT_RETURNTRANSFER => 1,
	   CURLOPT_URL => $url ,
	   CURLOPT_SSL_VERIFYPEER => false, // If You have https://
	   CURLOPT_SSL_VERIFYHOST => false,
	   CURLOPT_CUSTOMREQUEST => "GET",
	   CURLOPT_HTTPHEADER => array(
	    		// Set here requred headers
	        	"content-type: application/xml",
	    	),
	));

	// Send the request & save response to $resp
	$resp = curl_exec($curl);

	$handler = array();

	if( !$resp ){

   	// log this Curl ERROR:

		$handler['status'] = 'error';
		$handler['code'] = '404';
		$handler['message'] = 'Cannot connect to the host';
   
	}else{

	$xml = simplexml_load_string($resp);
	$json = json_encode($xml);
	$finalr = json_decode($json);

		if($finalr->action == 'error'){

			$handler['status'] = 'error';
			$handler['code'] = $finalr->data->errorcode;
			$handler['message'] = $finalr->data->errormessage;

		}else{
			$handler['status'] = 'success';
			$handler['code'] = '200';
			$handler['message'] = 'Message accepted for delivery.';
			$handler['sms_id'] = $finalr->data->acceptreport->messageid;
		}

	}

	curl_close($curl);

	return $handler;

}

function sms_at($number, $message)
{
	$port = env('SMS_SP');
	$baud = env('SMS_BAUD');
	$parity = env('SMS_PARITY');
	$data = env('SMS_DATA');
	$stop = env('SMS_STOP');

	$handler = array();

	exec("MODE {$port}: BAUD={$baud} PARITY={$parity} DATA={$data} STOP={$stop}", $output, $retval);

	$fp = @fopen("{$port}","r+");

	if($fp){

	   	$handler['status'] = 'success';
		$handler['code'] = '200';
		$handler['message'] = 'Port has been open';

	}else{
		$handler['status'] = 'error';
		$handler['code'] = '404';
		$handler['message'] = 'Port cannot be open.';
	}

	fwrite($fp,"AT+CMGF=1\n\r");
	fwrite($fp, "AT+CMGS=\"{$number}\"\r");
	fwrite($fp, $message.chr(26));

	fclose($fp);

	return $handler;
}

function color_generate($length = 6){

	$a =  substr(str_shuffle(str_repeat($x='0123456789ABCDEF', ceil($length/strlen($x)) )),1,$length);

	return "#".$a;
}

function vote_percent($x, $y)
{	
	if($y !== 0){
		$a = ($x / $y) * 100;
		return round(abs($a));
	}else{
		return "0";
	}
}

function sms_status($val){
	if($val == 1){
		return 'Open';
	}else{
		return 'Close';
	}
}

function current_time_footer()
{
	return date('h:i:s A', time());
}

function is_between($x, $y, $z)
{
	if($x >= $y && $x <= $z){
		return true;
	}else{
		return false;
	}
}

function unique_string($length = 16) 
{
	$x = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $y =  substr(str_shuffle(str_repeat($x, ceil($length/strlen($x)) )),1,$length);
    $z = time();
    return $z.'-'.$y;
}

function sidebarHelper($string)
{
	$url = $_SERVER['REQUEST_URI'];
	if(strpos($url, $string) !== false){echo "active";}
}

function vote_stat($val)
{
	if($val == '0')
	{	
		return '<span class="label label-danger">Uncast Vote</span>';
	}else{
		return '<span class="label label-primary">Casted Vote</span>';
	}
}

function leading_zero($value){
	return str_pad($value,0,'0',STR_PAD_LEFT);
}

function elc_time($time)
{
	echo date('d/m/y h:i A', $time);
}

function log_time($time)
{
	return date('d M y | H:i A', $time);
}

function timestamp_to_date($time)
{
	return date('Y-m-d', $time);
}

function timestamp_to_time($time)
{
	return date('H:i', $time);
}

function position_decode($val)
{
	switch ($val) {
		case '1':
			return 'All Select';
		break;

		case '2':
			return 'Department Select';
		break;

		case '3':
			return 'Year Select';
		break;
		
		default:
			return 'Undefined';
		break;
	}
}