<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'email' => 'Admin@gmail.com',
        //     'username' => 'Admin',
        //     'password' => Hash::make('Admin123'),
        //     'role' => 'admin',
        // ]);
        $this->call(UserSeeder::class);
    }
}
