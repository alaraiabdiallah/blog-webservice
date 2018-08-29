<?php

namespace App\Contracts\Model;

interface Filter
{
    public function scopeFiltering($query, $request, $filter_option = null);
    public function paginateAppends($result, $request);
    public  function requestFilterOption($request, $filter_option = null);
}