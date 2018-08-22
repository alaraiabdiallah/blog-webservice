<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Model\Slug;
class Tag extends Model
{

    use Slug;
    protected $fillable = [
        'name','slug'
    ];


    public function posts()
    {
        return $this->hasMany('App\PostTag');
    }

    public function setSlugAttribute($value)
    {
        $slug = $this->getSlug(strtolower($value));
        $this->attributes['slug'] = $slug;
    }

    
}
