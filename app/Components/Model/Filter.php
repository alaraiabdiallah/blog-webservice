<?php

namespace App\Components\Model;

trait Filter
{
    public function paginateAppends($result, $request)
    {
        $result->appends($request->except('page'));

        return $result;
    }

    public function requestFilterOption($request, $filter_option = null)
    {
        if (is_null($filter_option)) {
            $request = collect($request->all());
        } else {
            $request = $request->only($filter_option);
        }

        return $request;
    }

}