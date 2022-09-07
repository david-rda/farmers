<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\ILogout;
use Auth;

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
