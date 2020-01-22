<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug', 'body', 'sku', 'supplier_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public static $rules = [
        'name' => "required|max:50",
        'description' => "required|max:5000",
        'slug' => "required|max:50",
        'sku' => "required|max:20",
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

}
