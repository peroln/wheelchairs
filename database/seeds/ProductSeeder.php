<?php

use Illuminate\Database\Seeder;
use App\{Product, Image};

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 50)->create()->each(function($product){
            $product->images()->save(factory(Image::class)->make());
        });
    }
}
