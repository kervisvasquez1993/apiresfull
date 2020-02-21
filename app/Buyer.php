<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
namespace User;

use App\Transactio;

class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transactio::class);
        //
    }
}
