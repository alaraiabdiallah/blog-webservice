<?php

namespace App\Contracts\Model;

interface Cacheable
{
    public function scopeCacheQuery($query);
    public function scopeCached($query);
    public function scopeCachedPaginate($query, $per_page);
}