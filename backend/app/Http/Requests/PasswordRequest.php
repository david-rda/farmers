<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "current_password" => "required|min:4", // მიმდინარე პაროლის მნიშვნელობა
            "new_password" => [
                "required",
                "min:4",
                "regex:/[a-z]/",
                "regex:/[A-Z]/",
                "regex:/[0-9]/",
                "regex:/[@$!%*#?&]/"
            ] // ახალი პაროლის მნიშვნელობა
        ];
    }

    public function messages() {
        return [
            "current_password.required" => "შეიყვანეთ მიმდინარე პაროლი",
            "current_password.min" => "პაროლი უნდა შედგებოდეს მინიმუმ 4 სიმბოლოსგან",

            "new_password.required" => "შეიყვანეთ ახალი პაროლი",
            "new_password.min" => "პაროლი უნდა შედგებოდეს მინიმუმ 4 სიმბოლოსგან",
            "new_password.regex" => "პაროლი უნდა შეიცავდეს მაღალი და დაბალი რეგისტრის<br> ერთ სიმბოლოს მაინც, ციფრს და ერთ სპეციალურ სიმბოლოს მაინც."
        ];
    }
}
