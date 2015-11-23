<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FormableController extends Controller
{
    private $formable = false;

    public function __construct(Request $request)
    {
        $this->formable = $this->getItem($request->get('model'), $request->get('id'));
    }

    public function getItem($model, $id)
    {
        $class_name = "\App\\".ucfirst($model);
        $class = new $class_name;
        return $class->find($id);
    }

    public function getModel($model)
    {
        $class_name = "\App\\".ucfirst($model);
        return new $class_name;
    }

    public function reorderImages(Request $request)
    {
        $images = $request->get('images');
        
        if(!$this->formable || !$images) return false;

        $this->formable->images = $images;

        $this->formable->save();
    }

    public function reorderFiles(Request $request)
    {
        $files = $request->get('files');
        
        if(!$this->formable || !$files) return false;

        $this->formable->files = $files;

        $this->formable->save();
    }

    public function reorder(Request $request)
    {
        $order = $request->get('order');
        $model = $request->get('model');

        if( ! ($m = $this->getModel($model))) return false;

        foreach($order as $order => $itemId)
        {
            $item = $m->find($itemId);

            if($item)
            {
                $item->order = $order + 1;
                $item->save();
            }
        }
    }

    public function images(Request $request)
    {
        return $this->formable->img()->all();
    }

    public function files(Request $request)
    {
        return $this->formable->file()->all();
    }

    public function toggle(Request $request)
    {
        $this->formable->status = !$this->formable->status;
        
        if($this->formable->save())
        {
            return response()->json(['success' => true, 'status' => ($this->formable->status ? '1' : '0')], 200);
        }
    }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,gif'
        ]);

        if($this->formable) {
            $file = $request->file('photo');

            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            
            $name = rtrim(sha1_file($file).'-'.str_slug($file->getClientOriginalName()), $ext).'.'.strtolower($ext);

            $file->move('uploads', $name);

            $this->formable->img()->add([
                'name' => $name,
                'title' => $file->getClientOriginalName(),
                'order' => (count($this->formable->img()->all())),
            ]);

            return response()->json(['success' => true], 200);
        }
    }


    public function deleteImage(Request $request)
    {
        $idx = $request->get('idx');

        $this->formable->img()->remove($idx);
        
        return response()->json(['success' => true], 200);
    }


    public function uploadFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:pdf,msword,plain'
        ]);

        if($this->formable) {
            $file = $request->file('file');

            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            
            $name = rtrim(sha1_file($file).'-'.str_slug($file->getClientOriginalName()), $ext).'.'.strtolower($ext);

            $file->move('files', $name);

            $this->formable->file()->add([
                'name' => $name,
                'title' => $file->getClientOriginalName(),
                'order' => (count($this->formable->file()->all())),
                'mime' => $file->getClientMimeType(),
            ]);

            return response()->json(['success' => true], 200);
        }
    }
}
