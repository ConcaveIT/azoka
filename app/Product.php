<?php

namespace App;

use Actuallymab\LaravelComment\Contracts\Commentable;
use Actuallymab\LaravelComment\HasComments;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use willvincent\Rateable\Rateable;

class Product extends Model implements Commentable
{
    //
    protected $guarded = [];
    /**
     * @var mixed
     */

//    use LogsActivity;
    use HasComments;

    public function canBeRated(): bool
    {
        return true; // default false
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function specifications()
    {
        return $this->hasOne(ProductSpecification::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    public function deal()
    {
        return $this->hasOne(Deal::class)->where('expire', '>', now());
    }

    public function variant()
    {
        return $this->belongsToMany('App\Variant', 'product_variants')->withPivot('id', 'item_code', 'additional_price', 'qty', 'variant_by');
    }

}
