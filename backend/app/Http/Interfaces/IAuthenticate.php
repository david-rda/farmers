<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    interface IAuthenticate {
        public function Login(Request $request);
    }
?>