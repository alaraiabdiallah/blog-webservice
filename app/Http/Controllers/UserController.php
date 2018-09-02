<?php

namespace App\Http\Controllers;

use App\User as Model;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource as Resource;
use Illuminate\Support\Facades\Hash;
use App\Abstracts\Controllers\ApiController;

class UserController extends ApiController
{

    protected $rules = [
        'name' => "required",
        'email' => "required|email",
        'password' => "required|min:6|max:20",
    ];

    protected $model, $resource;

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
        $this->model = new Model;
        $this->resource = Resource::class;
    }

    protected function params($request)
    {
        $rules = $this->getRules($request);
        $this->validate($request, $rules);
        $params = $request->except('password');
        if($request->has('password')){
            $params['password'] = Hash::make($request->password); 
        }
        return $params;
    }

    protected function getRules($request)
    {
        if ($request->isMethod('patch')) {
            $this->rules = [
                'email' => "email",
                'password' => "min:6|max:20",
            ];
        }
        return $this->rules;
    }

}
