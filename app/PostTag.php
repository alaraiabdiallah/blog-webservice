<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id','tag_id'
    ];

    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }
}
