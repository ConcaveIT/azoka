<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Damages extends Model
{
	protected $table = 'damaged_products';
    protected $fillable =[
        "product_id", "variant_id", "qty", "note", "status"
    ];

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
