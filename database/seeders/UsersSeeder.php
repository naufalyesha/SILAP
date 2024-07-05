<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $userData = [
        [
            'email' => 'vendor1@gmail.com',
            'nama' => 'Vendor One',
            'alamat' => 'Jl. Kalijaga Satu No. 1',
            'phone' => '081234567890',
            'role' => 'vendor',
            'password' => bcrypt('12345678')
        ],
        [
            'email' => 'admin1@gmail.com',
            'nama' => 'Admin One',
            'alamat' => 'Jl. Kalibata Satu No. 1',
            'phone' => '081234567891',
            'role' => 'admin',
            'password' => bcrypt('12345678')
        ],
        [
            'email' => 'customer1@gmail.com',
            'nama' => 'Customer One',
            'alamat' => 'Jl. Kalinyamatan Satu No. 1',
            'phone' => '081234567890',
            'role' => 'customer',
            'password' => bcrypt('12345678')
        ],
    ];

    foreach ($userData as $key => $val) {
        User::create($val);
    }
}

}
