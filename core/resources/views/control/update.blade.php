@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Gestion des articles
@endsection

@section('content')
    <div id="gestionUpdate">
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
            
            <table>
                <thead>
                    <tr>
                        <th id="ID">ID</th>
                        <th id="Nom du produit">Nom du produit</th>
                        <th id="description">Description</th>
                        <th id="image">Image</th>
                        <th id="price">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td headers="ID">{{ $product->id }}</td>
                        <td headers="Nom du produit">{{ $product->product_name }}</td>
                        <td headers="description">{{ $product->description }}</td>
                        <td headers="image">{{ $product->image }} </td>
                        <td headers="price">{{ $product->price }}€</td>
                    </tr>
                </tbody>
            </table>
            <form id="formUpdate" class="formulaire" novalidate method="post" action="{{route('control.postUpdate', ['id' => $product['id']]) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label id="idUpdate" class="form-control">{{ $product->id }}</label>
                </div>
                
                <div class="form-group">
                    <input id="nameUpdate" class="form-control" name="name" value="{{ $product->product_name }}" required autofocus>
                    <p class="error-js" hidden></p>
                    @if ($errors->has('name'))
                        <p class="help-block text-danger">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <textarea id="descriptionUpdate" rows="2" class="form-control" name="description" placeholder="Description de l'article (250 caractères maximum)" required>{{ $product->description }}</textarea> 
                    <p class="error-js" hidden></p>
                    @if ($errors->has('description'))
                        <p class="help-block text-danger">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>

                <div class="form-group">
                    <textarea id="urlUpdate" rows="2" class="form-control" name="url" placeholder="URL de l'image" required>{{ $product->URL }}</textarea>
                    <p class="error-js" hidden></p>
                    @if ($errors->has('url'))
                        <p class="help-block text-danger">
                            {{ $errors->first('url') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <input id="imageUpdate" class="form-control" name="image" value="{{ $img }}" required >
                    <p class="error-js" hidden></p>
                    @if ($errors->has('image'))
                        <p class="help-block text-danger">
                            {{ $errors->first('image') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <input id="priceUpdate" type="number" step="0.01" class="form-control" name="price" value="{{ $product->price }}" required >
                    <p class="error-js" hidden></p>
                    @if ($errors->has('price'))
                        <p class="help-block text-danger">
                            {{ $errors->first('price') }}
                        </p>
                    @endif
                </div>
                <button type="submit" class="bouton" id="submit">Modifier</button> 
            </form>   
        @else
            <h1>Bien essayé, mais non.</h1>
        @endif
    </div>
@endsection

