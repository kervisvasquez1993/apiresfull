<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Transactio;
use Illuminate\Http\Request;


class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comprador = Buyer::has('transactions')->get();  //has recibe una relacion que tenga el modelo
        return $this->showAll($comprador);
    }


    public function show($id)
    {
        $comprador = Buyer::has('transactions')->findOrFail($id);
        return  $this->showOne($comprador);
    }


}
