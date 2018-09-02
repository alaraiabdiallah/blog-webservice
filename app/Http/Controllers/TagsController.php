<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Abstracts\Controllers\ApiController;

class TagsController extends ApiController
{

    private $rules = [
        'name' => "required|max:20",
        'slug' => "required|alpha_dash|max:20",
    ];

    protected $model, $resource;

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
        $this->model = new Tag;
        $this->resource = TagResource::class;
    }

    protected function params($request)
    {
        $rules = $this->getRules($request);
        $this->validate($request, $rules);
        return $request->all();
    }

    protected function getRules($request)
    {
        if ($request->isMethod('patch')) {
            $this->rules = [
                'name' => "max:20",
                'slug' => "alpha_dash|max:20",
            ];
        }
        return $this->rules;
    }

}
