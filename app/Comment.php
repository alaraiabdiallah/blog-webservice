<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id','content'
    ];

    public function scopeFindByPostId($query, $post_id)
    {
        return $query->where('post_id', $post_id);
    }

    public function scopeFindByIdAndPostId($query, $post_id, $id)
    {
        return $query->where('post_id', $post_id)->where('id', $id)->first();
    }

}
