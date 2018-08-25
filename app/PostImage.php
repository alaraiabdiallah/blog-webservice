<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = [
        'post_id', 'alt_name', 'url'
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
