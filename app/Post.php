<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Components\Model\{Slug, Filter, Cacheable};
use App\Contracts\Model\Cacheable as CacheContract;
use App\Contracts\Model\Filter as FilterContract;

class Post extends Model implements CacheContract, FilterContract
{

    use Slug,Cacheable,Filter;
    
    protected $fillable = [
        'title','slug','content','published_at'
    ];

    protected $cache_time = 3;

    public function categories()
    {
        return $this->hasMany('App\PostCategory');
    }

    public function tags()
    {
        return $this->hasMany('App\PostTag');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function images()
    {
        return $this->hasMany('App\PostImage');
    }

    public function setSlugAttribute($value)
    {
        $slug = $this->getSlug(strtolower($value));
        $this->attributes['slug'] = $slug;
    }

    public function scopeWithQuery($query)
    {
        return $query->with(['categories', 'tags', 'comments', 'images']);
    }

    public function scopeMainQuery($query, $request)
    {
        $query = $query->withQuery()
        ->filtering($request)
        ->orderBy('posts.id','DESC')
        ->paginate();
        $query = $this->paginateAppends($query,$request);
        return $query;
    }

    public function scopeFiltering($query,$request, $filter_option = null)
    {
        $request = $this->requestFilterOption($request, $filter_option);    

        if ($request->has('category_id')) {
            $ids = explode(',', $request->get('category_id'));
            $query = $query->join('post_categories', 'post_categories.post_id', '=', 'posts.id')
            ->orWhere(function($query) use($ids) {
                $query->whereIn('post_categories.category_id', $ids); 
            });
        }
        
        if ($request->has('tag_id')) {
            $ids = explode(',', $request->get('tag_id'));
            $query = $query->join('post_tags', 'post_tags.post_id', '=', 'posts.id')
                ->orWhere(function ($query) use ($ids) {
                    $query->whereIn('post_tags.tag_id', $ids);
                });;
        }

        return $query;
    }


    public function scopeCacheQuery($query)
    {
        return $query->withQuery()->orderBy('id','DESC')->get();
    }


}
