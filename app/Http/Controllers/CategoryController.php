<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Abstracts\Controllers\ApiController;

class CategoryController extends ApiController
{

    protected $rules = [
        'name' => "required|max:20",
        'slug' => "required|alpha_dash|max:20",
    ];

    protected $model,$resource;

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
        $this->model = new Category;
        $this->resource = CategoryResource::class;
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
