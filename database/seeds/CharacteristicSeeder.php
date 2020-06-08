<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Product::with('type.filterItems.subFilterItems')->get();
        $arr = [];
        foreach ($products as $product) {
            foreach ($product->type->filterItems as $filterItem) {
                $subFilterItem = $filterItem->subFilterItems->random();
                [$value, $slug] = $this->createValue($filterItem, $subFilterItem);
                $arr[] = [
                    'product_id' => $product->id,
                    'sub_filter_item_id' => $subFilterItem->id,
                    'value' => $value,
                    'slug' => $slug,
                    'created_at' => $product->created_at
                ];
            }
        }
        \Illuminate\Support\Facades\DB::table('characteristics')->insert($arr);
    }

    /**
     * @param $filterItem
     * @return int|mixed
     */
    private function createValue($filterItem, $subFilterItem)
    {

        switch ($filterItem->name) {
            case 'Stroller Seat Width':
                {
                    preg_match('/\d+/', $subFilterItem->name, $matches);
                    return [$matches[0], Str::slug($subFilterItem->name . ' ' . $filterItem->name, '-')];
                }
                break;
            case 'Maximum load, kg':
                return $this->setValueMaxLoad($subFilterItem->name, $filterItem->name);
                break;
            case 'Price':
                return [rand(70000, 5000000), 'price'];
                break;
            default :
                return [$subFilterItem->name, Str::slug($subFilterItem->name . ' ' . $filterItem->name, '-')];
        }
    }

    private function setValueMaxLoad($sub_filter_item_name, $filter_item_name)
    {
        switch ($sub_filter_item_name) {
            case 'up to 80':
                return [rand(10, 80), Str::slug($sub_filter_item_name . ' ' . $filter_item_name , '-')];
                break;
            case '100 - 120':
                return [rand(100, 120), Str::slug($sub_filter_item_name . ' ' . $filter_item_name , '-')];
                break;
            case '120 - 140':
                return [rand(120, 140), Str::slug($sub_filter_item_name . ' ' . $filter_item_name , '-')];
                break;
            case 'from 140':
                return [rand(140, 200), Str::slug($sub_filter_item_name . ' ' . $filter_item_name , '-')];
                break;
        }
        return rand(10, 200);
    }
}
