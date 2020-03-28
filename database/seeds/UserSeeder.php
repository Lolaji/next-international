<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            [
                'name' => 'Ajibola Salami',
                'username' => 'lolaji',
                'email' => 'ayo.lolade@gmail.com',
                'password' => Hash::make('ajibola'),
                'role' => 'global',
                'is_admin' => 1
            ],
            [
                'name' => 'Will van Middendorp',
                'username' => 'nextwill',
                'email' => 'next@nextinternational.ca',
                'password' => Hash::make('nextwill123!'),
                'role' => 'global',
                'is_admin' => 1
            ],
            [
                'name' => 'Akinbiyi Mike',
                'username' => 'mike',
                'email' => 'mike@gmail.com',
                'password' => Hash::make('mike'),
                'role' => 'author',
                'is_admin' => 1
            ],
            [
                'name' => 'Blessing Adebayo',
                'username' => 'blessman',
                'email' => 'adebayo@gmail.com',
                'password' => Hash::make('adebayo'),
                'role' => 'moderator',
                'is_admin' => 1
            ],
            [
                'name' => 'John Dumelo',
                'username' => 'dumelo',
                'email' => 'dumelo@gmail.com',
                'password' => Hash::make('dumelo'),
                'role' => 'regular',
                'is_admin' => 0
            ]
        ]);
    }
}
