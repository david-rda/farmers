<?php
    namespace App\Http\Interfaces;
    
    use App\Http\Requests\PasswordRequest;

    interface IPassword {
        public function ValidatePassword(PasswordRequest $request);

        public function ChangePassword(PasswordRequest $request);
    }
?>