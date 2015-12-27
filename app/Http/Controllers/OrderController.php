<?php

namespace Alyya\Http\Controllers;

use Alyya\Models\Site\Transporter;
use Illuminate\Http\Request;

use Alyya\Http\Requests;
use Alyya\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function show(Request $request){
        return view('front.order.cart');
    }
    public function shipping(Request $request){
        $data = $request->session()->all();
        $transporters = Transporter::all();
        return view('front.order.shipping',[ 'transporters' => $transporters] );
    }

}
