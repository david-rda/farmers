<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Interfaces\ILogout;

class LogoutController extends Controller implements ILogout
{
    public function Logout(Request $request) {
        try {
            Auth::logout();

            $request->session()->invalidate();

            return 1;
        }catch(Exception $e) {
            return 0;
        }
    }
}
