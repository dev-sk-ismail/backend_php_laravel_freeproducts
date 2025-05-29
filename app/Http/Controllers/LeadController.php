<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
	public function index()
    {
        if(!Session::get('userArray'))
        {
            return redirect('/admin');
        }
    	$allUsers = DB::table('users')->select('*')->simplePaginate(10)->toArray();
    	//dd($allUsers);
		return view('lead.lead',compact('allUsers'));
	}
	public function view(Request $request, $id)
    {
        if(!Session::get('userArray'))
        {
            return redirect('/admin');
        }
    	$userDetails = DB::table('users')->select('*')->where(array('id'=> $id))->first();
    	//dd($userDetails);
    	return view('lead.view-user',compact('userDetails'));
	}

	
}