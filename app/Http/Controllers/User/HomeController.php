<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request)
    {
        $expires = 60 * 24 * 30;

        if ($request->hasCookie('cart')) {
            $cart = json_decode($request->cookie('cart'), true);
        } else {
            $cart = [];
        }

        return redirect()
            ->route(empty($cart) ? 'home' : 'checkout.index')
            ->withCookie(cookie('cart', json_encode($cart), $expires));
    }
}
