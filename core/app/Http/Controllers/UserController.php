<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Product;

class UserController extends Controller
{
    public function getProfile() {
        $orders = Auth::user()->orders;
        $orders = $orders->sortByDesc("created_at");
        $orders->transform(function($order, $key){
            $order->cart = unserialize($order->cart);
            return $order;
        });
        return view('user.profile', ['orders' => $orders]);
    }

    public function getLogout() {
        Auth::logout();
        Session::forget('cart');
        return redirect()->route('product.index');
    }
}
