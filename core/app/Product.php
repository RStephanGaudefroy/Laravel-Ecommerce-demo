<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name', 'image', 'description', 'price' ];

    /**
    * Desactivation du timeStamp pour eviter l'erreur
    * SQLSTATE[42S22]: Column not found: 1054 Champ 'updated_at' inconnu dans field list
    */
    public $timestamps = false;
}
