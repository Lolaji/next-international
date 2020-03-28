<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqs')->insert([
            [
                'question' => 'What do we offer?',
                'answer' => 'We offer a range of services',
                'position' => '1'
            ],
            [
                'question' => 'Are our client happy about the nature of our work?',
                'answer' => 'Yes, they are extremely happy',
                'position' => '2'
            ],
            [
                'question' => 'What is our striength?',
                'answer' => 'Our striength is attending to details and deliver the best candidate in your company.',
                'position' => '3'
            ],
        ]);
    }
}
