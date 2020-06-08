<?php

namespace App\Http\Controllers;

use App\{FilterItem, Http\Helpers\CollectionHelper, Services\WheelchairService};
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class WheelchairController extends Controller
{
    private $service;

    /**
     * WheelchairController constructor.
     * @param WheelchairService $service
     */
    public function __construct(WheelchairService $service){
       $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $products = $this->service->indexService($request)->get();

        [$filters, $min_price, $max_price, $config_first_param,$min_filter, $max_filter] = $this->service->createFilters($products);
        $total = $products->count();
        $products = CollectionHelper::paginate($products, $total);

        if($request->ajax()){
            return response()->view('wheelchair.ajax', compact(['products', 'filters', 'config_first_param', 'min_price', 'max_price','min_filter', 'max_filter']));
        }

        return view('wheelchair.index', compact(['products', 'filters', 'config_first_param', 'min_price', 'max_price','min_filter', 'max_filter']));
    }

}
