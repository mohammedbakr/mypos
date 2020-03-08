<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];

    protected $appends = ['image_path', 'profit_percent'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_order');
    }

    public function getImagePathAttribute()
    {

        return asset('uploads/product_images/' . $this->image);

    }// end of get image path

    public function getProfitPercentAttribute()
    {

        $profit = $this->sale_price - $this->purchase_price;
        $profit_percent = $profit * 100 / $this->purchase_price;

        return number_format($profit_percent, 2);
    
    }// enf of profit percentage
}
