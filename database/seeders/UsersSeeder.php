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
                'name'=>'Customer',
                'email'=>'customer1@gmail.com',
                'role'=>'customer',
                'password'=>bcrypt('1234')
            ],
            [
                'name'=>'Vendor',
                'email'=>'vendor1@gmail.com',
                'role'=>'vendor',
                'password'=>bcrypt('1234')
            ],
            [
                'name'=>'Admin',
                'email'=>'admin1@gmail.com',
                'role'=>'admin',
                'password'=>bcrypt('1234')
            ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
