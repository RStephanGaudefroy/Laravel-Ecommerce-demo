@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Création article
@endsection

@section('content')
    <div id="gestionCreation">
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
                  
            <form id="formCreate" class="formulaire" novalidate method="post" action="{{route('control.postCreate') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                               
                <div class="form-group">
                    <input id="nameCreate" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nom de l'article (Maximum 22 caractères" required autofocus>
                    <p class="error-js" hidden>essai</p>
                    @if ($errors->has('name'))
                        <p class="help-block text-danger">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <textarea id="descriptionCreate" rows="5" class="form-control" name="description" placeholder="Description de l'article (Maximum 250 cractères)" required>{{ old('description') }}</textarea> 
                    <p class="error-js" hidden>essai</p>
                    @if ($errors->has('description'))
                        <p class="help-block text-danger">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <textarea id="urlCreate" rows="2" class="form-control" name="url" placeholder="URL de l'image (Format autorisé : JPG et PNG)" required>{{ old('url') }}</textarea>
                    <p class="error-js" hidden>essai</p>
                    @if ($errors->has('url'))
                        <p class="help-block text-danger">
                            {{ $errors->first('url') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <input id="imageCreate" class="form-control" name="image" value="{{ old('image' ) }}" placeholder="le nom de l'image (Sans extension et maximum 30 caractères)" required >
                    <p class="error-js" hidden>essai</p>
                    @if ($errors->has('image'))
                        <p class="help-block text-danger">
                            {{ $errors->first('image') }}
                        </p>
                    @endif
                </div>
                
                <div class="form-group">
                    <input id="priceCreate" type="number" step="0.01" class="form-control" name="price" value="{{ old('price') }}" placeholder="Le prix de l'article" required >
                    <p class="error-js" hidden>essai</p>
                    @if ($errors->has('price'))
                        <p class="help-block text-danger">
                            {{ $errors->first('price') }}
                        </p>
                    @endif
                </div>
                <button type="submit" class="bouton" id="submit">Enregistrer</button> 
            </form>   
        @else
            <h1>Bien essayé, mais non.</h1>
        @endif
    </div>
@endsection
