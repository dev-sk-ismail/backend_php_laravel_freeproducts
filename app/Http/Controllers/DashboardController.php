<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\sendMailtoUser;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	public function index()
    {
    	if(!Session::get('userArray'))
        {
            return redirect('/admin');
        }
		return view('dashboard.index');
	}
}