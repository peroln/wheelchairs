<?php


namespace App\Services;

use App\Characteristic;
use App\FilterItem;
use App\Product;
use App\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WheelchairService
{
    /**
     * @param Request $request
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function indexService(Request $request)
    {
        $sort = $request->sort;
        $order = $request->order;

        $products_query = Product::with(['type.filterItems.subFilterItems', 'characteristics'])
            ->whereHas('type', function (Builder $builder) {
                $builder->where('name', Type::WHEELCHAIR_TYPE_NAME);
            });

        if ($request->route('search')) {
            $products_query = $this->createQuery($products_query, $request->route('search'));
        } elseif ($request->has('min') && $request->has('max')) {
            $products_query = $this->requestPrice($products_query);
        }
        if ($sort && $order) {
            $products_query = $products_query->orderBy($sort, $order);
        }
        return $products_query;
    }

    /**
     * @param Builder $products_query
     * @param $search
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection
     */

    private function createQuery(Builder $products_query, $search)
    {
        $array_search = explode('/', $search);
        if (count($array_search) > 1) {
            [$arr_or, $arr_and] = $this->createArraysHelper($array_search);
            if (!empty($arr_and)) {
                if (empty($arr_or)) {
                    if (count($arr_and) === 1) {
                        $products_query = $this->createQueryOR($products_query, $arr_and);
                    } else {
                        return $this->createQueryAndMulti($products_query, $arr_and);
                    }
                } else {
                    $products_query = $this->createQueryOR($products_query, $arr_or);
                    return $this->createQueryAndMulti($products_query, $arr_and);
                }
                if (!empty($arr_or)) {
                    $products_query = $products_query->whereHas('characteristics', function (Builder $query) use ($arr_or) {
                        $query->whereIn('slug', $arr_or);
                    });
                    return $this->requestPrice($products_query);
                }
            }
        }
        $products_query = $this->createQueryOR($products_query, $array_search);


        return $products_query;
    }

    /**
     * @param Builder $products_query
     * @param array $arr_and
     * @return Builder
     */
    private function createQueryAndMulti(Builder $products_query, array $arr_and)
    {
        foreach ($arr_and as $slug) {
            $products_query = $products_query->whereHas('characteristics', function (Builder $query) use ($slug) {
                $query->whereExists(function ($query) use ($slug) {
                    $query->where('slug', $slug);
                });
            });
        }

        return $this->requestPrice($products_query);
    }

    /**
     * @param Builder $products_query
     * @param $array_search
     * @return Builder
     */
    private function createQueryOR(Builder $products_query, $array_search)
    {

        $products_query = $products_query->whereHas('characteristics', function (Builder $query) use ($array_search) {
            $query->whereIn('slug', $array_search);
        });

        return $this->requestPrice($products_query);
    }

    /**
     * @param Builder $products_query
     * @return Builder
     */
    private function requestPrice(Builder $products_query)
    {
         $products_query->when(request()->has('min') && request()->has('max'), function ($q) {
            $q->whereHas('characteristics', function (Builder $query) {
                $query->whereBetween('value', [(integer)request()->min, (integer)request()->max])
                    ->where('slug', 'price');
            });
        });

        return $products_query;
    }

    /**
     * @param $array_search
     * @return array
     */
    private function createArraysHelper($array_search)
    {
        $arr_or = [];
        $arr_and = [];
        $pattern_or = Str::slug(collect(config('filter.Wheelchairs'))->keys()->first(), '-');
        foreach ($array_search as $string_search) {
            if (stristr($string_search, $pattern_or)) {
                $arr_or[] = $string_search;
            } else {
                $arr_and[] = $string_search;
            }
        }
        return [$arr_or, $arr_and];
    }

    /**
     * @param Collection $products
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function createFilters(Collection $products)
    {
        $filters = FilterItem::with('subFilter.products')
            ->get();
        $arr_price = [];
        foreach ($products as $product) {
            foreach ($product->characteristics as $characteristic) {
                if ($characteristic->slug === 'price') {
                    $arr_price[] = $characteristic->value;
                }
                $filters->transform(function ($value, $key) use ($characteristic) {
                    foreach ($value->subFilterItems as $subFilterItem) {

                        if ($subFilterItem->id === $characteristic->sub_filter_item_id) {
                            ++$subFilterItem->count_filter;
                        }
                    }
                    return $value;
                });
            }
        }
        $min_filter = collect($arr_price)->min();
        $max_filter = collect($arr_price)->max();
        $characteristics = Characteristic::where('slug', 'price')->pluck('value');
        $max_global = $characteristics->max();
        $min_global = $characteristics->min();

        $config_first_param = Str::slug(collect(config('filter.Wheelchairs'))->keys()->first(), '-');
        return [$filters, $min_global, $max_global, $config_first_param, $min_filter, $max_filter];
    }
}
