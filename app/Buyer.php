<?php

namespace App;
use App\Transactio;

class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transactio::class);
        //
    }
}
