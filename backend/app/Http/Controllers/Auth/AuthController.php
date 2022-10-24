<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Http\Interfaces\IAuthenticate;

class AuthController extends Controller implements IAuthenticate
{
    public function Login(Request $request) {
        $data = $this->validate($request, [
            "email" => "required|email",
            "password" => "required"
        ]);

        if(Auth::attempt($data)) {

            $token = Auth::user()->createToken("API_ACCESS_TOKEN")->accessToken;

            return response()->json([
                "login" => 1,
                "role" => Auth::user()->role,
                "id" => Auth::user()->id,
                "token" => $token
            ], 200);
        }else {
            return response()->json([
                "login" => 0,
                "message" => "იმეილი ან პაროლი არასწორია."
            ], 422);
        }
    }
}
