<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        // $this->call(PostSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(SiteInfoSeeder::class);
        $this->call(ContactsSeeder::class);
    }
}
