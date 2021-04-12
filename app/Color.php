<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Color extends Model
{
    //
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_color');
    }
}
