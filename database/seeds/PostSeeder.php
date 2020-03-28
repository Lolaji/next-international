<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('Posts')->insert([
            [
                'user_id' => '',
                'title' => '',
                'status' => '',
                'content' => ''
            ],
            [
                'user_id' => '',
                'title' => '',
                'status' => '',
                'content' => ''
            ]
        ]);
    }
}
