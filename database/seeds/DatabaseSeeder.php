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
         $this->call(TypeSeeder::class);
         $this->call(FilterItemSeeder::class);
         $this->call(ProductSeeder::class);
         $this->call(SubFilterItemSeeder::class);
         $this->call(CharacteristicSeeder::class);
    }
}
