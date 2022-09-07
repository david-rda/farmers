<?php
    namespace App\Http\Interfaces;

    use Illuminate\Http\Request;

    interface ILogout {
        public function Logout(Request $request);
    }
?>