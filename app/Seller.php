<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
namespace User;
use App\Product;

class Seller extends User
{
    public function products()
    {
        return $this->hasMany(Product::class);
        // un vendedor tiene muchos productos
    }
}
