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
        'name' => "required"
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
            return CategoryResource::collection($category);
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
        $this->validate($request, $this->rules);

        return $request->all();
    }

}
