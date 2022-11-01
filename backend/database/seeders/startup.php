<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class startup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // როლი 1 წვდომა აქვს მხოლოდ ფერმერის სემოწმებაზე
        // 2-ს შემოწმებაზეც და იფნორმაციის მოძიებაზეც
        User::create([
            "name" => "ადმინისტრატორი",
            "email" => "admin@rda.gov.ge",
            "password" => bcrypt("1234"),
            "role" => 3
        ]);
    }
}
