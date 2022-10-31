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
        User::insert([
            [
                "name" => "prime",
                "email" => "prime@rda.gov.ge",
                "password" => bcrypt("Prime!!"),
                "role" => 1
            ],
            [
                "name" => "monitoring",
                "email" => "Monitoring@rda.gov.ge",
                "password" => bcrypt("Monitoring1!"),
                "role" => 2
            ],
            [
                "name" => "aldagi insurance",
                "email" => "aldagi@rda.gov.ge",
                "password" => bcrypt("Aldagi1!!"),
                "role" => 1
            ]
        ]);
    }
}
