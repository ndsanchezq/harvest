<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            ['name' => 'Administrador', 'username' => 'admin', 'email' => 'neil.sanchez@bodytechcorp.com', 'password' => Hash::make('admin'), 'email_verified_at' => now(), 'remember_token' => \Str::random(10)],
            ['name' => 'Cristian Machado', 'username' => 'cristian.machado', 'email' => 'cristian.machado@bodytechcorp.com', 'password' => Hash::make('admin'), 'email_verified_at' => now(), 'remember_token' => \Str::random(10)],
            ['name' => 'Neil Sanchez', 'username' => 'ndsanchez', 'email' => 'nd.sanchezq@gmail.com', 'password' => Hash::make('admin'), 'email_verified_at' => now(), 'remember_token' => \Str::random(10)]
        ]);
    }
}
