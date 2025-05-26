<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class LoginRegistrationController extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/
    public function index(){
        if(Session::get('userArray'))
        {
            return redirect('admin/dashboard');
        }
    	return view('login.login');
    }
    public function login(Request $request){


    	$validatedData = $request->validate([
	        'email_address' => 'required|email',
	        'password' => 'required|min:6'
	    ]);

	    $userdata = DB::table('admin_table')->where('email', $validatedData['email_address'])->get()->toArray();

        $user_id = $userdata[0]->id;
        $user_email = $userdata[0]->email;
	    $user_password = $userdata[0]->password;

	    if(!empty($userdata)){
	    	if(Hash::check($validatedData['password'],$user_password)){
                $userArray = array(
                    'id' => $user_id,
                    'user_email' => $user_email,
                    'user_password' => $user_password
                 );
	    		Session::put('userArray', $userArray);
                return redirect('admin/dashboard');
	    	}
	    }
    }
    public function register(Request $request){
        //dd($request);
    	$validatedData = $request->validate([
	        'email_address' => 'required|email',
	        'password' => 'required|min:6'
	    ]);
    	
    	$admindata = array(
    		'email' => $validatedData['email_address'],
    		'password' => Hash::make($validatedData['password']),
    		'role' => 'admin'
    	);
    	DB::table('admin_table')->insert($admindata);
        return redirect('admin');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Session::flash('successMessage', 'You have successfully logged out from your account.');
        return redirect('/admin');
    }
}
