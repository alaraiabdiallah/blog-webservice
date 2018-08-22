<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Model\Slug;
class Post extends Model
{

    use Slug;
    
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


    public function setSlugAttribute($value)
    {
        $slug = $this->getSlug(strtolower($value));
        $this->attributes['slug'] = $slug;
    }

}
