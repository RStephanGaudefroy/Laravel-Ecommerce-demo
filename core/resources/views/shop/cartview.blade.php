<!-- Affiche le panier en cours -->
@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Mon panier
@endsection

@section('content')
    <div id="cartview">
        @if (Session::has('cart'))
            <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <ul>
                        @foreach ($products as $product)
                            <li class="list-group-item">
                                <span class="bold">{{ $product['item']['product_name'] }}</span>
                                <div class="btn-group" id="buttonAction">
                                    <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('product.reduceByOne', ['id' => $product['item']['id']]) }}">Reduce by 1</a></li>
                                        <li><a href="{{ route('product.remove', ['id' => $product['item']['id']]) }}">Reduce All</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="bold">{{ $product['price'] }} €</span>
                                <span class="badge">{{ $product['qty'] }}</span>    
                            </li>
                            &nbsp    
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="row ">
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <ul>
                        <li class="list-group-item bold price">
                            <span>Total : {{ $totalPrice }} €</span>
                            <span class="cartview-btn">
                                <a id="cartview-command" href="{{ route('paycard') }}" type="button" class="bouton">Passer la commande</a>
                            </span>
                        </li> 
                    </ul>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h2>Il n'y a pas d'article(s) dans votre panier</h2>  
                </div>
            </div>   
        @endif
    </div> <!-- Fin ID cartview -->
@endsection
