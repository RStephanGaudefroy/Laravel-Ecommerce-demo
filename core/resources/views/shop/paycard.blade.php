@extends('layouts.principal')

@section('title')
    Laravel simple e-commerce demonstration
@endsection

@section('view')
    Payer ma commande
@endsection

@section('content')
    <div id="payment">
        <div class="jumbotron">
            <h3>Notification</H3>
            <p>Pour la version test du système de paiement Stripe seul les N° de carte suivant sont valide : </p>
            <ul>
                <li>4242 4242 4242 4242 Visa</li>
                <li>4012 8888 8888 1881 Visa</li>
                <li>5555 5555 5555 4444 Visa</li>
                <li>3782 822463 10005 American express</li>
                <li>6011 1111 1111 1117	Discover</li>
                <li>4000 0000 0000 0069 carte expirée</li>
            </ul>
            <p>Pour la validité n'importe quelle date est acceptée.</p>
        </div>
        <form action="{{ route('paycard') }}" method="POST" id="paycard-form">
            {{ csrf_field() }}
            <!-- données du formulaire de paiement -->
            <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-label="Payer avec une CB"
                data-key="pk_test_cWJ4lJCjdfwIBGth2y3qE1Al"
                data-email="{{ Auth::user()->email }}"
                data-amount="{{ $total }}"
                data-name="Laravel Simple E-Commerce"
                data-description="Test Paiement CB avec Stripe"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-zip-code="false"
                data-allow-remember-me="false"
                data-currency="eur">
            </script>
        </form>
        <div id="charge-error"></div>
    </div><!-- fin ID payment -->
@endsection
