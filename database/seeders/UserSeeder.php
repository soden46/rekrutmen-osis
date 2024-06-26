<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'userName' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('Admin123'),
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        User::create([
            'nama' => 'Siswa',
            'userName' => 'Siswa',
            'email' => 'Siswa@siswa.com',
            'role' => 'siswa',
            'password' => Hash::make('Siswa123'),
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        User::create([
            'nama' => 'Pembina',
            'userName' => 'Pembina',
            'email' => 'Pembina@pembina.com',
            'role' => 'pembina',
            'password' => Hash::make('Pembina123'),
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        User::create([
            'nama' => 'Pembina1',
            'userName' => 'Pembina1',
            'email' => 'Pembina1@pembina.com',
            'role' => 'pembina',
            'password' => Hash::make('Pembina123'),
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
        User::create([
            'nama' => 'Pembina2',
            'userName' => 'Pembina2',
            'email' => 'Pembina2@pembina.com',
            'role' => 'pembina',
            'password' => Hash::make('Pembina123'),
            'created_at' => '2024-02-04 10:30:27',
            'updated_at' => '2024-02-04 10:30:27'
        ]);
    }
}
