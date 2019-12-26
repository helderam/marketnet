<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'zipcode_begin', 'zipcode_end', 'active', 'store_id'
    ];

    public static $rules = [
        'name' => "required|max:50",
        'zipcode_begin' => "required|max:8",
        'zipcode_end' => "required|max:8",
        'active' => "required|max:1",
        #'store_id' => "required",
    ];
}
