<h1>Wheelchairs Content </h1>
<div class="d-flex flex-wrap  bd-highlight mb-3">
    @foreach($products as $product)
        <div class="p-2 bd-highlight d-flex align-items-stretch">
            <div class="card" style="width: 18rem;">
                <img src="{{$product->images()->first()->path}}" class="card-img-top" alt="{{$product->alter}}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center">{{$product->title}}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 100,'...')}}</p>
                    <a href="#" class="btn btn-primary mt-auto">Переход куда-нибудь</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center bd-highlight mb-3">
{{$products->onEachSide(1)->links()}}
</div>
