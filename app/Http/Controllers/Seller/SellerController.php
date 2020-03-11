<?php

namespace App\Http\Controllers\Seller;
use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedor = Seller::has('products')->get();  //has recibe una relacion que tenga el modelo
        return response()->json(['data' => $vendedor], 200);
    }


    public function show($id)
    {
        $vendedor = Seller::has('products')->findOrFail($id);
        return  response()->json(['data' => $vendedor], 200);
    }

}
