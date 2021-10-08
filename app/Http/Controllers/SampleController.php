<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SMS;

use Faker;


class SampleController extends Controller
{
    public function index()
    {

    	$sms = SMS::where('number', '09480223295')->get()->first();


   		// echo "{SMS:TEXT}{Wavecom Fastrack M1306B}{+639467034972}{{$sms->number}}{{$sms->message}}\r\n";
	}

	public function faker()
	{
		$faker = Faker\Factory::create();
		echo $faker->firstname."<br>".$faker->lastName;
	}
    public function post(Request $request)
    {
    
    		
    }
}
