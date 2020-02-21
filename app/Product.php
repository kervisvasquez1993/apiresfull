<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use User\Seller;

class Product extends Model
{
    const PRODUCTO_DISPONIBLE = 'disponible';
    const PRODUCTO_NO_DISPONIBLE = 'no disponible';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];
    public function estaDisponible()
    {
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
        // belongsToMany ->>>> tiene muchos categorias

        // el modelo que pertenece al otro es quien lleva la clave foranea
    }


    public function seller()
    {
            return $this->belongsToMany(Seller::class);
            // belongsToMany -> pertenece a muchas ventas
            //, es quien lleva la clave foranea
    }
    public function transactions()
    {
        return $this->belongsToMany(Transactio::class);
    }
}
