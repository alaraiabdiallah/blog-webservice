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

    public function scopeFindByPostId($query,$post_id)
    {
        return $query->where('post_id',$post_id);
    }

    public function scopeFindByIdAndPostId($query, $post_id,$id)
    {
        return $query->where('post_id', $post_id)->where('id',$id)->first();
    }
}
