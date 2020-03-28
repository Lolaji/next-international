<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            [
                'name' => 'Salami Ajibola',
                'email' => 'ayo.lolade@gmail.com',
                'address' => 'No 4. Apete, Ibadan',
                'phone' => '08060485046',
                'zip_code' => '20192',
                'message' => "Primarily Focused On Serving Small To Medium Businesses And Start-Ups, We Don’t See Our Niche In Terms Of Vertical Expertise, Though We Have Plenty. Our Experience Expands Across A Broad Stripe Of Businesses, With An Unparalleled Ability To Drill Down And Uncover An Organization's DNA. Leveraging This Knowledge In Our Service Offerings We Are Able To Identify Areas For Improvement, Provide Custom Developed Training Programs And Identify High Performance Talent That Fit Both The Profile For Success AND Corporate Culture."
            ],
            [
                'name' => 'Akinboye Olaide',
                'email' => 'akinboye@gmail.com',
                'address' => 'Adebayo street',
                'phone' => '08060467546',
                'zip_code' => '20192',
                'message' => "Primarily Focused On Serving Small To Medium Businesses And Start-Ups, We Don’t See Our Niche In Terms Of Vertical Expertise, Though We Have Plenty. Our Experience Expands Across A Broad Stripe Of Businesses, With An Unparalleled Ability To Drill Down And Uncover An Organization's DNA. Leveraging This Knowledge In Our Service Offerings We Are Able To Identify Areas For Improvement, Provide Custom Developed Training Programs And Identify High Performance Talent That Fit Both The Profile For Success AND Corporate Culture."
            ],
            [
                'name' => 'James Blunt',
                'email' => 'james@gmail.com',
                'address' => 'calgray, canada',
                'phone' => '0806046778766',
                'zip_code' => '20192',
                'message' => "Primarily Focused On Serving Small To Medium Businesses And Start-Ups, We Don’t See Our Niche In Terms Of Vertical Expertise, Though We Have Plenty. Our Experience Expands Across A Broad Stripe Of Businesses, With An Unparalleled Ability To Drill Down And Uncover An Organization's DNA. Leveraging This Knowledge In Our Service Offerings We Are Able To Identify Areas For Improvement, Provide Custom Developed Training Programs And Identify High Performance Talent That Fit Both The Profile For Success AND Corporate Culture."
            ]
        ]);
    }
}
