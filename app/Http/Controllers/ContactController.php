<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use Mail;
use DB;

class ContactController extends Controller
{
    public function show()
    {
        $page = Page::where('slug', 'hafa-samband')->first();

        $data['page'] = $page;

        return view('frontend.forms.contact')->with($data);
    }

    public function postContact(ContactRequest $request)
    {
        $fyrirspurn = [
            'nafn' => ucwords($request->get('nafn')),
            'netfang' => trim(strtolower($request->get('netfang'))),
            'simi' => trim($request->get('simi')),
            'titill' => trim($request->get('titill')),
            'skilabod' => trim($request->get('skilabod')),
        ];
    
        Mail::send('emails.contact', $fyrirspurn, function ($m) use ($fyrirspurn) {
            $m->to('test@netvistun.is', config('formable.site_title'))->subject($fyrirspurn['titill']);
        });

        return response()->json('success', 200);
    }
}
