@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Le magasin
@endsection

@section('content')
    <div id="index">
        <!-- Affichage des messages d'informations -->
        @if(Session::has('success') || Session::has('info'))
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div id="charge-message" class="alert alert-success alert-info">
                        {{ Session::get('success') }}
                        {{ Session::get('info') }}
                    </div>
                </div>
            </div> 
        @endif
             
        <!-- Affichage des articles -->
        @foreach($products->chunk(4) as $productChunk) <!--chunk limiter à 4 le nombre d'article par ligne -->
            <div class="row">
                @foreach($productChunk as $product)
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="thumbnail">
                            <img src="{{URL::to('image/', $product->image )}}" alt="..." class="img-responsive">
                            <div class="caption">
                                <h3 class="productName">{{ $product->product_name }}</h3>
                                <p class="description">{{ $product->description }}</p>
                            </div>
                            <div>
                                <div class="price">{{ $product->price }} €</div>
                                <a href="{{ route('product.addCart', ['id' => $product->id]) }}" class="btn" role="button">Ajouter</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div> <!-- Fin ID Index -->
@endsection