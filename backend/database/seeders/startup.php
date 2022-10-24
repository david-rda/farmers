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
        User::insert([
            [
                "name" => "prime",
                "email" => "prime@rda.gov.ge",
                "password" => bcrypt("Prime!!"),
                "role" => 1
            ],
            [
                "name" => "prime",
                "email" => "prime@rda.gov.ge",
                "password" => bcrypt("Monitoring1!"),
                "role" => 2
            ]
        ]);
    }
}
