<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends ItemableController
{
    public $model = 'Product';

    public function create($id = 0, $extra = array())
    {
        $flokkar = array_merge([0 => ' - Veldu flokk - '] + \App\Category::lists('title', 'id')->toArray());

        $extra['flokkar'] = $flokkar;
        $extra['selectedParentId'] = 0;

        return parent::create($id, $extra);
    }

    public function edit($id, $extra = array())
    {
    	$vara = \App\Product::find($id);

        $flokkar = array_merge([0 => ' - Veldu flokk - '] + \App\Category::lists('title', 'id')->toArray());

        $extra['flokkar'] = $flokkar;
        $extra['selectedFlokkurId'] = $vara->{$vara->parent_key} ?: 0;

    	return parent::edit($id, $extra);
    }

    public function saveOptions($id, Request $request)
    {
        $product = \App\Product::find($id);

        $options = $request->get('options');

        $product->update([
            'options' => $options
        ]);

        return $product->options;
    }
}