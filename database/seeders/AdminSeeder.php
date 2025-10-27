<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where("role", "admin")->exist()) {
            User::create([
                'name' => 'administrator',
                'email'=> 'admin@a.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
        }
    }
}
