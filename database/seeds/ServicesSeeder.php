<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            [
                'title' => 'RECRUITMENT ADVISORY SERVICES',
                'overview_icon' => 'images/014-advisory.png',
                'header_image' => '',
                'short_desc' => 'This service can be purchased as a recruiting support to help you with your high volume recruitment needs.',
                'content' => ''
            ],
            [
                'title' => 'TRAINING',
                'overview_icon' => 'images/013-training.png',
                'header_image' => '',
                'short_desc' => 'Consectetur adipisicing elitaed eiusmod tempor incididuatna labore et dolore magna',
                'content' => ''
            ],
            [
                'title' => 'EXECUTIVE SEARCH',
                'overview_icon' => 'images/008-target.png',
                'header_image' => '',
                'short_desc' => 'Consectetur adipisicing elitaed eiusmod tempor incididuatna labore et dolore magna.',
                'content' => ''
            ]
        ]);
    }
}
