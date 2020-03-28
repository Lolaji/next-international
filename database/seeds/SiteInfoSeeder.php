<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_infos')->insert([
            [
                'title' => 'Site Short description',
                'name' => 'site_short_description',
                'content' => 'A collaborative partner to help you definy your recruitment process and strategy while assisting you to connect with talented professionals.',
                'form_type' => 'textarea',
                'status' => 1
            ],
            [
                'title' => 'Phone',
                'name' => 'phone',
                'content' => '(403) 604 4334',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'Location',
                'name' => 'location',
                'content' => 'Calgary, Canada',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'Contact Email Address',
                'name' => 'contact_email_address',
                'content' => 'info@nextinternational.ca',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'Facebook',
                'name' => 'facebook',
                'content' => 'https://facebook.com/nextint',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'LinkedIn',
                'name' => 'linkedin',
                'content' => 'https://linkedin.com/in/nextint',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'Twitter',
                'name' => 'twitter',
                'content' => 'https://twitter.com/nextint',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'Privacy',
                'name' => 'privacy',
                'content' => 'This is our privacy',
                'form_type' => 'text',
                'status' => 1
            ],
            [
                'title' => 'Terms and Conditions',
                'name' => 'terms_and_conditions',
                'content' => 'This is our Terms and Conditions',
                'form_type' => 'text',
                'status' => 1
            ]
            
        ]);
    }
}
