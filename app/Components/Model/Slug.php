<?php

namespace App\Components\Model;

trait Slug{
    public function getSlug($slug)
    {
        $slugs = $this->where('slug', $slug)->get();
        if ($slugs->count() > 0) {
            $last_id = $this->orderBy('id', 'DESC')->value('id') + 1;
            return $slug . '-' . $last_id;
        }

        return $slug;
    }
}