<?php

namespace App\Http\Controllers;

use App\Course;
use App\Trail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $expires = 60 * 24 * 30;
        if (!$request->hasCookie('cart')) {
            cookie('cart', json_encode([]), $expires);
        }
        $produtos = [];
        return view('pages.cart.index', ['produtos' => $produtos]);
    }

    /**
     *
     * @param Request $request
     * @return Redirector|RedirectResponse
     * @throws BindingResolutionException
     */
    public function add(Request $request)
    {
        $cart = [];
        $expires = 60 * 24 * 30;

        if ($request->hasCookie('cart')) {
            $cart = json_decode($request->cookie('cart'), true);
        }

        if (($request->has('id') && $request->id) && ($request->has('type') && $request->type)) {
            $type = $request->type;

            switch($type) {
                case 'trail':
                    $product = Trail::find($request->id);
                    break;
                case 'course':
                    $product = Course::find($request->id);
                    break;
                default:
                    $product = null;
            }
            if ($product !== null) {
                if (isset($cart[$type])) {
                    if (array_search($product->id, $cart[$type]) === false) {
                        $cart[$type][] = $product->id;
                    }
                } else {
                    $cart[$type][] = $product->id;
                }
            }
        }
        if ($request->ajax()) {
            $items = [];
            $valor_total = 0;

            if (count($cart) > 0) {
                foreach($cart as $type => $cart_items) {
                    foreach($cart_items as $cart_item) {
                        if ($type == 'trail') {
                            $item = Trail::find($cart_item, ['id', 'title', 'slug', 'price', 'discount', 'cover_details']);
                            $item->price = round($item->price * (1 - ($item->discount/100)), 2);
                        } else {
                            $item = Course::find($cart_item, ['id', 'title', 'slug', 'category_title', 'category_slug', 'price', 'image']);
                        }
                        $item->type = $type;
                        $item->title = mb_strtoupper($item->title);
                        $valor_total += $item->price;
                        $item->price = number_format($item->price, 2, ',', '.');
                        $items[] = $item;
                    }
                }
            }

            return response()
                ->json([
                    'ok' => true,
                    'total' => array_sum(array_map('count', $cart)),
                    'items' => $items,
                    'valor_total' => number_format(round($valor_total,2), 2, ',', '.'),
                    'parcelado' => number_format(round(($valor_total/10),2), 2, ',', '.'),
                ])
                ->withCookie(cookie('cart', json_encode($cart), $expires));
        }

        return redirect('/checkout')
            ->withCookie(cookie('cart', json_encode($cart), $expires));
    }

    /**
     *
     * @param Request $request
     * @param string $type
     * @param int $id
     * @return RedirectResponse|JsonResponse
     */
    public function remove(Request $request, $type, $id)
    {
        $cart = [];
        $expires = 60 * 24 * 30;
        if ($request->hasCookie('cart')) {
            $cart = json_decode($request->cookie('cart'), true);
            if (isset($cart[$type]) && ($key = array_search($id, $cart[$type])) !== false) {
                unset($cart[$type][$key]);

                if (count($cart[$type]) === 0) {
                    unset($cart[$type][$id]);
                }
            }
        }

        if ($request->ajax()) {
            return response()
                ->json(['ok' => true])
                ->withCookie(cookie('cart', json_encode($cart), $expires));
        }

        return back()
            ->withCookie(cookie('cart', json_encode($cart), $expires));
    }
}
