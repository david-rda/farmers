<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => "required|string",
            "email" => "required|email",
            "password" => [
                "required_if:password,!=,null", // ცარიელი ველის აკრძალვა
                "min:4", // მინიმუმ 4 სიმბოლოს აუცილებლობა
                "regex:/[a-z]/", // აუცილებელია პატარა სიმბოლოები a-დან z-ის ჩათვლით
                "regex:/[A-Z]/", // აუცილებელია დიდი სიმბოლოები A-დან Z-ის თათვლით
                "regex:/[0-9]/", // აუცილებელია ციფრები 0-დან 9-ის ჩათვლით
                "regex:/[!@#?$%&*)(]/" // [@$!%*#?&] აუცილებელია მოცემული სიმბოლოების შეყვანა ერთის მაინც 
            ],
            "role" => "required"
        ];
    }

    public function messages() {
        return [
            "name.required" => "სახელის შეყვანა სავალდებულოა",
            "email.required" => "ელ.ფოსტის შეყვანა სავალდებულოა",
            "email.email" => "შეიყვანეთ სწორი ფორმატის ელ.ფოსტა",
            "password.required_if" => "პაროლის შეყვანა სავალდებულოა",
            "password.min" => "პაროლი უნდა შედგებოდეს მინიმუმ 4 სიმბოლოსგან",
            "password.regex" => " პაროლი უნდა შეიცავდეს მაღალი და დაბალი რეგისტრის სიმბოლოებს, ციფრებს და ერთ სპეციალურ სიმბოლოს მაინც.",
            "role.required" => "როლის მითითება სავალდებულოა"
        ];
    }
}
