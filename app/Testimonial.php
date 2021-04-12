<?php

namespace App;

use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model implements Commentable
{
    //
    protected $guarded = [];
    use HasComments;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
