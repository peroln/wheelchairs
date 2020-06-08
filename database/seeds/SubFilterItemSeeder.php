<?php

use Illuminate\Database\Seeder;
use App\FilterItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SubFilterItemSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filter_wheelchair_array = config('filter.Wheelchairs');
        $filter_items = FilterItem::all()->pluck('name', 'id');
        $arr = collect();
        $faker = Faker::create();
        foreach ($filter_wheelchair_array as $config_item_name => $config_item_value) {
            foreach ($filter_items as $filter_item_id => $filter_item_name) {
                if ($filter_item_name === $config_item_name && (is_array($config_item_value) && count($config_item_value))) {

                    $arr = $arr->merge(collect($config_item_value)->transform(function ($item, $key) use ($filter_item_id) {
                        return ['filter_item_id' => $filter_item_id, 'name' => $item, 'sub_item_slug' => Str::slug($item, '-'), 'created_at' => now()];

                    })->toArray());
                } elseif ($filter_item_name === $config_item_name && $filter_item_name === 'Stroller Manufacturer') {
                    $countries = [];
                    foreach (range(0, rand(5, 10)) as $number) {
                        $countries[] = $faker->country;
                    }
                    $arr = $arr->merge(collect($countries)->transform(function ($item, $key) use ($filter_item_id) {
                        return ['filter_item_id' => $filter_item_id, 'name' => $item, 'sub_item_slug' => Str::slug($item, '-'), 'created_at' => now()];
                    }
                    ));
                } elseif ($filter_item_name === $config_item_name && $filter_item_name === 'Price') {
                    $arr = $arr->merge(array(['filter_item_id' => $filter_item_id, 'name' => 'null', 'sub_item_slug' => 'null', 'created_at' => now()]));
                }
            }
        }

        DB::table('sub_filter_items')->insert($arr->toArray());
    }
}
