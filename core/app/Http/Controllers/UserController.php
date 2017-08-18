<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Product;

class UserController extends Controller
{
    /**
     * Retourne la liste des achats de l'utilisateur en cours
     */
    public function getProfile() {
        $orders = Auth::user()->orders;
        $orders = $orders->sortByDesc("created_at");
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        if (count($orders) > 0) {
            return view('user.profile', ['orders' => $orders]);
        }  else {
            Session::flash('info', "Vous n'avez pas d'achat enregistré");
            return redirect()->route('product.index');
        }
        
    }

    /**
     * Deconnection de l'utilisateur 
     */
    public function getLogout() {
        Auth::logout();
        Session::forget('cart');
        return redirect()->route('product.index');
    }
}
