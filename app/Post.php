<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','slug','content','published_at'
    ];


    public function categories()
    {
        return $this->hasMany('App\PostCategory');
    }

    public function tags()
    {
        return $this->hasMany('App\PostTag');
    }


}
