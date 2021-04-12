<?php

namespace App;

use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;
use Illuminate\Database\Eloquent\Model;

class AmarCare extends Model implements Commentable
{
    //
    protected $guarded = [];
    use HasComments;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'vlog_products', 'vlog_id');
    }

}
