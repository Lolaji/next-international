<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'title' => 'Recuitment'
            ],
            [
                'title' => 'Banking'
            ],
            [
                'title' => 'Sales Representation'
            ],
            [
                'title' => 'Construction'
            ]
        ]);
    }
}
