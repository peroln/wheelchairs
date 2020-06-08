<div class="d-flex flex-column">
    <div class="jumbotron">
        <h1>Filter Bar</h1>
        <h6 id="anchor">Count of products ({{$products->total()}})</h6>
        <hr class="my-4">

        @foreach($filters as $filterItem)
            <div class="mb-3">
                <h4>{{$filterItem->name}}</h4>
                @if($filterItem->name != 'Price')
                    @foreach($filterItem->subFilterItems as $subFilterItem)
                        <div class="custom-control custom-checkbox">
                            @if($filterItem->name === collect(config('filter.Wheelchairs'))->keys()->first())
                                <input type="checkbox" class="custom-control-input"
                                       id="{{$subFilterItem->id}}" name="{{$subFilterItem->name}}"
                                       title="{{\Illuminate\Support\Str::slug($subFilterItem->name .' '. $filterItem->name, '-')}}"
                                       data-count-filter="{{$subFilterItem->count_filter}}">
                                <label class="custom-control-label"
                                       for="{{$subFilterItem->id}}">{{$subFilterItem->name}}
                                    {{(!$subFilterItem->count_filter)  ? '(+'. $subFilterItem->products()->count() . ')' :
                                     '('. $subFilterItem->count_filter . ')'}}
                                </label>
                            @else
                                <input type="checkbox" class="custom-control-input"
                                       id="{{$subFilterItem->id}}" name="{{$subFilterItem->name}}"
                                       title="{{\Illuminate\Support\Str::slug($subFilterItem->name .' '. $filterItem->name, '-')}}"
                                       {{ $subFilterItem->count_filter ? '' : 'disabled' }}
                                       data-count-filter="{{$subFilterItem->count_filter}}">
                                <label class="custom-control-label"
                                       for="{{$subFilterItem->id}}">{{$subFilterItem->name}}
                                    ({{$subFilterItem->count_filter}})
                                </label>

                            @endif
                        </div>
                    @endforeach
                @else
                    <p>
                        <label for="amount">Price range:</label>
                        <input type="text" id="amount" readonly
                               style="border:0; color:#f6931f; font-weight:bold;"
                               data-min="{{$min_price}}"
                               data-max="{{$max_price}}"
                               data-min-filter="{{$min_filter}}"
                               data-max-filter="{{$max_filter}}"
                        >
                    </p>

                    <div id="slider-range"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
