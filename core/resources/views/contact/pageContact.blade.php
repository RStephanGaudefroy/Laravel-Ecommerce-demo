<!-- Affiche le panier en cours -->
@extends('layouts.principal')

@section('title')
    Laravel mini e-commerce
@endsection

@section('view')
    Me contacter
@endsection

@section('content')
    <form id="formContact" novalidate method="post" action="{{ route('contact.postContact') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
        <div class="col-md-8 col-sm-10 col-xs-12">
            <div class="form-group">
                <label id="dateJour"></label>
            </div>
        </div>
        <div class="col-md-8 col-sm-10 col-xs-12">
            <div class="form-group">
                <label for="mailContact"></label>
                <input type="email" class="form-control" id="mailContact" name="mailContact" value="{{ Auth::user()->email }}">
            </div>
        </div>
        <div class="col-md-8 col-sm-10 col-xs-12">
            <div class="form-group">
                <label for="messageContact"></label>
                <textarea class="form-control" id="messageContact" rows="8" name="messageContact" placeholder="Votre message"></textarea>
            </div>
            <input type="submit" class="btn btn-success bouton">
        </div>
        </div>
                
        {{--Affichage des messages d'erreurs--}}
        @if(count($errors->all()))
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{--Affichage des messages d'information--}}
        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fa fa-times"></i> {{ session('error') }}
            </div>
        @endif
    </form>    
@endsection