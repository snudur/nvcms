<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends ItemableController
{
    public $model = 'Category';

    public function create($id = 0, $extra = array())
    {
        $extra['parents'] = array_filter($this->getParents());
        $extra['selectedParentId'] = $id;
        return parent::create($id, $extra);
    }

    public function edit($id, $extra = array())
    {
    	$category = \App\Category::find($id);
    	$extra['parents'] = array_filter($this->getParents($category));
        $extra['selectedParentId'] = $id;

    	return parent::edit($id, $extra);
    }

}