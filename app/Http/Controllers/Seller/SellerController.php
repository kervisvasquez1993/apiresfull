<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;


class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedor = Seller::has('products')->get();  //has recibe una relacion que tenga el modelo
        return $this->showAll($vendedor);
    }


    public function show($id)
    {
        $vendedor = Seller::has('products')->findOrFail($id);
        return  $this->showOne($vendedor);
    }

}
