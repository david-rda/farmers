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
        User::create([
            "name" => "monitoring",
            "email" => "monitoring@rda.gov.ge",
            "password" => bcrypt(123456),
            "role" => 1 // or 2 | 1 წვდომა აქვს მხოლოდ ფერმერის შემოწმებაზე, 2 - ყველაფერზე
        ]);
    }
}
