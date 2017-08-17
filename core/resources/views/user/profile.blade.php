@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Mes achats
@endsection

@section('content')
    <div id="profil">
        <div class="col-md-10 col-sm-10 col-xs-12">
            @foreach($orders as $order)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title" id="dateAchat">Le {{Carbon\Carbon::parse($order['created_at'])->format('d/m/Y') }} à  {{ Carbon\Carbon::parse($order['created_at'])->toTimeString() }}</span>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($order->cart->items as $item)
                                <div class="maList">
                                    <li class="list-group-item">{{ $item['item']['product_name'] }}</li> 
                                    <li class="list-group-item">Qté :{{ $item['qty'] }}<span class="badge">{{ $item['price'] }} €</span></li>    
                                </div>
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <span>Total : {{ $order->cart->totalPrice }} €</span>    
                    </div>
                </div>
                &nbsp
            @endforeach
        </div>
    </div><!-- fin ID profil -->    
@endsection

