<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'level', 'slug', 'category_id'
    ];

    public static $rules = [
        'name' => "required|max:50",
    ];
}
