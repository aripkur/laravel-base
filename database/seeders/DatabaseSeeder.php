<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            "username" => "admin",
            "password" => Hash::make("admin"),
            "role" => "SUPER ADMIN",
            "fullname"=> "Administrator"
        ]);
    }
}
