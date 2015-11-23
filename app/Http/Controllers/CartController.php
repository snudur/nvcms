<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $cart = \Cart::content();

        return view('luxus.cart.index')->with(['cart' => $cart]);
    }

    public function cartDestroy(Request $request)
    {
        \Cart::destroy();

        return response()->json('success', 200);
    }

    public function cartHasItems()
    {
        $count = (count(\Cart::content()->toArray()));
        return response()->json(['itemCount'=>($count ?: 0)]);
    }

    public function getCartItems(Request $request)
    {
        $items = [];

        $total = 0;

        foreach(\Cart::content() as $rowid => $item) {
            $product = \App\Product::find($item['id']);

            $items[] = [
                'id'        => $item['id'],
                'name'      => $item['name'],
                'options'   => $item['options'],
                'price'     => $product->formatPrice($item['price']),
                'qty'       => $item['qty'],
                'rowid'     => $item['rowid'],
                'subtotal'  => $product->formatPrice($item['subtotal']),
                'image'     => $product->img()->first()
            ];

            $total += $item['subtotal'];
        }

        //dd($items);

        return response()->json(['items' => $items, 'total' => kalFormatPrice($total)]);
    }

    public function cartModal($product_id)
    {
        $product = \App\Product::find($product_id);

        return view('luxus.cart.modal')->with(compact('product'));
    }

    public function addToCart(Request $request)
    {
        $product_id = $request->get('product_id');

        $product = \App\Product::find($product_id);

        $product_options = $request->get('product_options');

        $options = $product->optionsArray($product_options);
        
        \Cart::add(
            $product->id,
            $product->title,
            1,
            $product->price,
            $options
        );

        return response()->json('success', 200);
    }

    public function updateCart(Request $request)
    {
        $items = $request->get('items');

        $rowids = [];

        foreach($items as $item) {
            $rowids[] = $item['rowid'];
            \Cart::update($item['rowid'], $item['qty']);
        }

        // Fjarlægjum vörur sem ekki lengur eru í körfunni
        foreach(\Cart::content() as $rowid => $item) {
            if(!in_array($rowid, $rowids)) {
                \Cart::remove($item['rowid']);
            }
        }

        return response()->json('success', 200);
    }
}
