@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Gestion des articles
@endsection

@section('content')
    <div id="gestionArticle">
        @if (Auth::user()->profil == '1')
            <!-- Affichage des messages d'informations -->
            @if(Session::has('success'))
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div id="message" class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    </div>
                </div> 
            @endif
            <div>
                <a href="{{ route('control.create') }}" class="bouton" role="button">Creer un article</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th id="ID">ID</th>
                        <th id="Nom du produit">Nom du produit</th>
                        <th id="description">Description</th>
                        <th id="image">Image</th>
                        <th id="price">Prix</th>
                        <th id="action">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td headers="ID">{{ $product->id }}</td>
                            <td headers="Nom du produit">{{ $product->product_name }}</td>
                            <td headers="description">{{ str_limit($product->description, $limit = 20, $end = ' ...') }}</td>
                            <td headers="image">{{ $product->image }} </td>
                            <td headers="price">{{ $product->price }}€</td>
                            <td headers="action">
                                <a title="Modifier l'entrée" href="{{route('control.update', ['id' => $product['id']]) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                &nbsp&nbsp
                                <a title="Supprimer l'entrée" href="{{route('control.remove', ['id' => $product['id']]) }}"><i class="fa fa-times" aria-hidden="true"></i></a>    
                            </td>
                        </tr>    
                    @endforeach
                </tbody>
            </table>
        @else
            <h1>Bien essayé, mais non.</h1>
        @endif
    </div>
@endsection