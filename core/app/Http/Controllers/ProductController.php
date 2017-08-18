<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Product;
use App\Order;
use App\Cart;
use Auth;
use Session;
use Stripe\charge;
use Stripe\stripe;

class ProductController extends Controller
{
    /**
     * fonction getIndex
     * Retourne la vue magasin
     */
    public function getIndex() {
        $products = Product::all();
        return view('shop.index', ['products' => $products]);    
    }

    /**
     * fonction getAddCart
     * Ajout d'un article dans le panier
     * @param Request
     * @param id
     */
    public function getAddCart(Request $request, $id) {
        $product = Product::find($id);
        /* Récupération du panier dans la session */
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        /* Création du panier contenant avec les article déjà présent */
        $cart = new Cart($oldCart);
        /* Ajout du nouvel article */
        $cart->add($product, $product->id);
        /* push le nouveau panier en session */
        $request->session()->put('cart', $cart);
        return redirect()->route('product.index');
    }

    /**
     * fonction getCart
     * retourne le panier de l'utilisateur
     */ 
    public function getCart() {
        if (!Session::has('cart')) {
            Session::flash('info', "Malheureusement votre panier est vide");
            return redirect()->route('product.index');
        } else {
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            return view('shop.cartview', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
        }
    }

    /**
     * fonction getReduceByOne
     * Réduction de la quantité d'un article dans le panier
     * @param id : ID de l'article à décrémenter
     */
    public function getReduceByOne($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart); 
        } else {
            Session::forget('cart');
            return redirect()->route('product.index');
        }
        return redirect()->route('product.cartview');  
    }

    /**
     * fonction getRemove
     * Suppression d'un article dans le panier
     * @param id : ID de l'article à supprimer du panier
     */
    public function getRemove($id) {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->remove($id);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart); 
        } else {
            Session::forget('cart');
            return redirect()->route('product.index');
        }
        return redirect()->route('product.cartview');     
    }

    /**
     * Fonction getPaycard
     * @return vue paiement
     */
    public function getPaycard() {
        if (!Session::has('cart')) {
            return view('shop.cartview');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice * 100;
        Return view('shop.paycard', ['total' => $total]);
    }

    /**
    * Fonction postPaycard
    * Fonction de paiement par carte bancaire -> version test
    * @param Request $request
    * @param Session->Cart
    * @param $cart->totalPrice
    */
    public function postPaycard(Request $request) {
        if (!Session::has('cart') || Auth::guest()) {
            return redirect()->route('shop.cartview');       
        }
        
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        
        /* clé test pour stripe */
        \Stripe\Stripe::setApiKey("sk_test_KKgqxlUF1us5r5n5kgz1o25d");
        try {
            /* construction de la charge pour le test */
            $charge = \Stripe\Charge::create(array(
                "amount" => $cart->totalPrice * 100,
                "currency" => "eur",
                "source" => $request->input('stripeToken'),   
                "description" => "Test Charge"
            ));
            /* Ajout de la commande dans la table orders */
            $order = new Order();
            //$order->created_at = strftime('%d %B %Y');
            $order->cart = serialize($cart);
            $order->payment_id = $charge->id;
            Auth::user()->orders()->save($order);

        } catch (\Exception $e) {
            return redirect()->route('paycard')->with('error', $e->getMessage() );
        }

        Session::forget('cart');
        return redirect()->route('product.index')->with('success', 'Votre commande à bien été prise en compte');
        
    }
}
