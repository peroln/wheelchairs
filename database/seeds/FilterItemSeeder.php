<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Type;
use Illuminate\Support\Str;

class FilterItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_id = Type::get()->first()->id;
        $filter_wheelchair_array = array_keys(config('filter.Wheelchairs'));
        $arr = [];
        foreach($filter_wheelchair_array as $wheelchair){
            $arr[] = [
                'name' => $wheelchair,
                'type_id' => $type_id,
                'item_slug' => Str::slug($wheelchair, '-'),
                'created_at' => now()
            ];
        }
        DB::table('filter_items')->insert($arr);
    }
}
