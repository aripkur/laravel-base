<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Services\Captcha;
use Illuminate\Http\Request;
use App\Repositories\UserRepo;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request, Captcha $captcha)
    {
        if(!$captcha->check($request->captcha_id, $request->captcha)){
            return back()->with(['status' => 'Captcha tidak valid'])->onlyInput('username');
        }

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->with(['status' => 'Username / password salah'])->onlyInput('username');
    }
    public function captcha(Captcha $captcha)
    {
        $captcha->destroy();
        return Helper::jsonResponse(200, "ok", $captcha->generate());
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
