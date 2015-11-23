<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class VorukerfiController extends Controller
{
    public $crumbs = [];

    public function index()
    {
        $cats   = \App\Category::where('parent_id', 0)->get();
        $prods  = \App\Product::where('category_id', 0)->get();

        $data['items'] = $cats->merge($prods);
        $data['title'] = 'Vörur';

        return view('frontend.products')->with($data);
    }

    // Sýnir annaðhvort vöru eða flokk
    public function show($slug)
    {
        // Tökum bara síðasta stykkið
        $e = array_filter(explode("/", $slug));
        $last = end($e);

        $item = \App\Category::where('slug', $last)->first();

        if($item) {
            $cats   = \App\Category::where('parent_id', $item->id)->get();
            $prods  = \App\Product::where('category_id', $item->id)->get();

            $data['items'] = $cats->merge($prods);
            $data['title'] = $item->title;

            return view('frontend.products')->with($data);
        }

        $item = \App\Product::where('slug', $last)->first();

        if(!$item) {
            if (!$item) abort(404, 'Fann ekki síðu!');
        }

        $data['item'] = $item;
        $data['siblings'] = $item->getSiblings();
        $data['title'] = isset($item->category->title) ? $item->category->title : 'Vörur';

        return view('frontend.product')->with($data);
    }
}
