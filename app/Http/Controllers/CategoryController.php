<?php

namespace App\Http\Controllers;

use App\Category;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{

    use Api;

    private $rules = [
        'name' => "required|max:20",
        'slug' => "required|alpha_dash|max:20",
    ];

    public function index()
    {
        return CategoryResource::collection(Category::paginate());
    }

    public function store(Request $request)
    {
        $params = $this->params($request);
        return new CategoryResource(Category::create($params));
    }

    public function show($id)
    {
        $category = Category::find($id);
        try {
            $this->throwWhenModelEmpty($category);
            return new CategoryResource($category);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function update(Request $request, $id)
    {

        $category = Category::find($id);
        try {
            $this->throwWhenModelEmpty($category);
            $category->update($this->params($request));
            return new CategoryResource($category);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        try {
            $this->throwWhenModelEmpty($category);
            $category->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    private function params($request)
    {
        $rules = $this->getRules($request);
        $this->validate($request, $rules);
        return $request->all();
    }

    private function getRules($request)
    {
        if ($request->isMethod('put')) {
            $this->rules['slug'] = 'alpha_dash|max:50';
        }
        return $this->rules;
    }

}
