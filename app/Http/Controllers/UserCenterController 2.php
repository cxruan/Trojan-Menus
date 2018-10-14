<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use View;
use Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    // public function __construct()
    // {
        
        

    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        return view('index');
    }


}
