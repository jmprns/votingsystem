<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Setting;
use App\Admin;
use App\Department;
use App\Year;
use App\Candidate;
use App\User;
use App\Log;

// Facades
use Auth;
use Hash;
use File;
use Artisan;

class SettingController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {

    	$insd = Setting::where('key', 'insd')->first();
    	$settings['insd'] = $insd->value;

    	$smsId = Setting::where('key', 'smsid')->first();
    	$settings['smsid'] = $smsId->value;

    	$sms = Setting::where('key', 'sms')->first();
    	$settings['sms'] = $sms->value;

        $department = Department::with('year')->get();


    	$admins = Admin::all();

    	// return $settings;

    	return view('admin.settings')
    			->with('admins', $admins)
                ->with('department', $department)
    			->with('settings', $settings);
    }

    public function admin()
    {
    	return view('admin.misc.admin-add');
    }


    public function settings(Request $request)
    {
    	switch ($request->setId) {


            // Admin Information
    		case '1':
    			$update = Admin::find(Auth::user()->id);
    			$update->fname = $request->fname;
                $update->lname = $request->lname;
    			$update->mname = $request->mname;
    			$update->position = $request->pos;
    			$update->save();

    			echo json_encode(array('status' => TRUE, 'response' => 200));
    		break;

            // Admin Password
    		case '2':
    			if(Hash::check($request->old, Auth::user()->password)){
    				$update = Admin::find(Auth::user()->id);
    				$update->password = Hash::make($request->new);
    				$update->save();
    				echo json_encode(array('status' => TRUE, 'response' => 200));
    			}else{
    				echo json_encode(array('status' => TRUE, 'response' => 100));
    			}
    		break;

            // Admin Image
    		case '3':

    			//Image Decoding
		        $image = $request->image;
		        $image = str_replace('data:image/jpeg;base64,', '', $image);
		        $image = str_replace(' ', '+', $image);
		        $imageName = unique_string().".jpg";
		        $destination = public_path()."/media/admin/".$imageName;
		        $actualImage = base64_decode($image);
		        $move = file_put_contents($destination, $actualImage);

                if(Auth::user()->image !== '00.png'){
                    //Deleting the current image
                    $image_path = public_path()."/media/admin/".Auth::user()->image;
                    File::delete($image_path);
                }

		        // Updating
		        $update = Admin::find(Auth::user()->id);
    			$update->image = $imageName;
    			$update->save();

    			echo json_encode(array('status' => TRUE, 'response' => 200, 'image' => $request->image));

    		break;

            // Create new admin
    		case '4':

		        $count = Admin::where('username', $request->uid)->count();

		        if($count > 0){
		        	echo json_encode(array('response' => 100));
		        	die();
		        }

		        //Image Decoding
		        $image = $request->image;
		        $image = str_replace('data:image/jpeg;base64,', '', $image);
		        $image = str_replace(' ', '+', $image);
		        $imageName = unique_string().".jpg";
		        $destination = public_path()."/media/admin/".$imageName;
		        $actualImage = base64_decode($image);
		        $move = file_put_contents($destination, $actualImage);

		        Admin::create([
		        	'username' => $request->uid,
		        	'password' => Hash::make($request->pass),
		        	'fname' => $request->fname,
                    'lname' => $request->lname,
		        	'mname' => $request->mname,
		        	'position' => $request->position,
		        	'lvl' => $request->poslvl,
		        	'image' => $imageName
		        ]);

    			echo json_encode(array('response' => 200));

    		break;

            // Reset Application
            case '5':

                if(Hash::check($request->password, Auth::user()->password)){
                    Artisan::call('migrate:refresh');
                    echo json_encode(array('response' => 200));
                }else{
                    echo json_encode(array('response' => 100));
                }

            break;

            case '6':
                $update = Setting::where('key', 'sms')->first();
                $update->value = $request->stat;
                $update->save();

                echo json_encode(array('response' => 200, 'mode' => $request->stat));

            break;

            // Deleting Admin
            case '7':

                $admin = Admin::find($request->admin_id);

                // print_r($admin);


                if($admin->image !== '00.png'){
                    //Deleting the current image
                    $image_path = public_path()."/media/admin/".$admin->image;
                    File::delete($image_path);
                }

                $admin->delete();

                $logd = Log::where('user_id', $admin->id)->where('user_lvl', 0)->get();

                    foreach($logd as $log){
                        Log::find($log->id)->delete();
                    }

                echo json_encode(array('response' => 200));


            break;

            case '8':
                $update = Setting::where('key', 'smsid')->first();
                $update->value = $request->ip;
                $update->save();

                echo json_encode(array('response' => 200, 'mode' => $request->stat));
            break;

            case '9':
                Department::create([
                    "dept_name" => $request->name
                ]);
                echo json_encode(array('response' => 200));
            break;

            case '10':
                Year::create([
                    'year_name' => $request->year,
                    'dept_id' => $request->dept
                ]);
                 echo json_encode(array('response' => 200));
            break;

            case '11':

                $dept_id = strval($request->dept_id);

                $candidates = Candidate::with('year.department')->get();
                $cands = $candidates->where('year.department.id', $dept_id);

                foreach($cands as $cand){
                    Candidate::find($cand->id)->delete();
                }

                $users = User::with('year.department')->get();
                $user2 = $users->where('year.department.id', $dept_id);

                foreach($user2 as $user3){
                    User::find($user3->id)->delete();
                }

                Year::where('dept_id', $dept_id)->delete();
                Department::find($dept_id)->delete();
               
                echo json_encode(array('response' => 200));
            break;

            case '12':

                $year_id = strval($request->year_id);

                $candidates = Candidate::where('year_id', $year_id)->delete();
                $users = User::where('year_id', $year_id)->delete();

                Year::find($year_id)->delete();
               
                echo json_encode(array('response' => 200));


            break;
    		
    		default:
    			echo json_encode(array('response' => 404));
    		break;
    	}
    }
}
