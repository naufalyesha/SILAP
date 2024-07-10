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
            'nama' => 'Reham Futsal Arena',
            'alamat' => 'Jl. Mulawarman Sel. Dalam I, Kramas, Kec. Tembalang, Kota Semarang, Jawa Tengah 50278',
            'phone' => '081234567890',
            'google_map_link' => 'https://maps.app.goo.gl/6LuZY7HSgsnXfiWB6',
            'role' => 'vendor',
            'password' => bcrypt('12345678')
        ],
        [
            'email' => 'admin1@gmail.com',
            'nama' => 'Admin',
            'alamat' => 'Jl. Raden Sahid, Kadilangu, Kec. Demak, Kabupaten Demak, Jawa Tengah 59517',
            'phone' => '081234567891',
            'google_map_link' => 'https://maps.app.goo.gl/8TtoVMDA4Bf4j5KE6',
            'role' => 'admin',
            'password' => bcrypt('12345678')
        ],
        [
            'email' => 'customer1@gmail.com',
            'nama' => 'Customer One',
            'alamat' => 'Jalan PDAM Domenggalan RT.8/RW.3, Stinggil, Bintoro, Kec. Demak, Kabupaten Demak, Jawa Tengah 59511',
            'phone' => '081234567890',
            'google_map_link' => '',
            'role' => 'customer',
            'password' => bcrypt('12345678')
        ],
    ];

    foreach ($userData as $key => $val) {
        User::create($val);
    }
}

}
