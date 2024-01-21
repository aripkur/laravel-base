<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function users()
    {
        return view('user');
    }

}
