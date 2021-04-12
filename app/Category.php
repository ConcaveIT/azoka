<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model{
    //
    use LogsActivity;
    protected $guarded = [];


    public function products()
    {
        return $this->hasMany(Product::class)->where('is_active', 1);
    }

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function vlogs()
    {
        return $this->hasMany(AmarCare::class);
    }
}
