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
            "current_password" => "required|min:4", // მიმდინარე პაროლის მნიშვნელობის ფილტრი
            "new_password" => [
                "required", // ცარიელი ველის აკრძალვა
                "min:4", // მინიმუმ 4 სიმბოლოს აუცილებლობა
                "regex:/[a-z]/", // აუცილებელია პატარა სიმბოლოები a-დან z-ის ჩათვლით
                "regex:/[A-Z]/", // აუცილებელია დიდი სიმბოლოები A-დან Z-ის თათვლით
                "regex:/[0-9]/", // აუცილებელია ციფრები 0-დან 9-ის ჩათვლით
                "regex:/[!@#?$%&*)(]/" // [@$!%*#?&] აუცილებელია მოცემული სიმბოლოების შეყვანა ერთის მაინც 
            ] // ახალი პაროლის მნიშვნელობის ფილტრი
        ];
    }

    public function messages() {
        return [
            "current_password.required" => "შეიყვანეთ მიმდინარე პაროლი",
            "current_password.min" => "პაროლი უნდა შედგებოდეს მინიმუმ 4 სიმბოლოსგან",

            "new_password.required" => "შეიყვანეთ ახალი პაროლი",
            "new_password.min" => "პაროლი უნდა შედგებოდეს მინიმუმ 4 სიმბოლოსგან",
            "new_password.regex" => " პაროლი უნდა შეიცავდეს მაღალი და დაბალი რეგისტრის<br> სიმბოლოებს, ციფრებს და ერთ სპეციალურ სიმბოლოს მაინც."
        ];
    }
}
