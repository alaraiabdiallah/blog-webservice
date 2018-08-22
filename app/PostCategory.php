<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
