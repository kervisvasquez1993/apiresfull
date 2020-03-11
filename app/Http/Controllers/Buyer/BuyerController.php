<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Transactio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comprador = Buyer::has('transactions')->get();  //has recibe una relacion que tenga el modelo
        return response()->json(['data' => $comprador], 200);
    }


    public function show($id)
    {
        $comprador = Buyer::has('transactions')->findOrFail($id);
        return  response()->json(['data' => $comprador], 200);
    }


}
