<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];

    public function category()
    {
        return $this->belongsTo(Product::class);
    }
}
