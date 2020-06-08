<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('types')->insert([
           'name' => \App\Type::WHEELCHAIR_TYPE_NAME,
           'created_at' => now()
       ]);
    }
}
