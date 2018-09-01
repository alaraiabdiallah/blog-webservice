<?php

namespace App\Http\Controllers;

use App\PostCategory;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\PostCategoryResource;

class PostCategoryController extends Controller
{

    use Api;

    private $rules = [
        'category_id' => "required|exists:categories,id"
    ];

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
    }

    public function index($post_id)
    {
        $model = PostCategory::findByPostId($post_id)->get();
        return PostCategoryResource::collection($model);
    }


    public function store(Request $request,$post_id)
    {
        $params = $this->params($request,['post_id'=>$post_id]);
        return new PostCategoryResource(PostCategory::create($params));
    }

    public function show($post_id,$id)
    {
        $category = PostCategory::findByIdAndPostId($post_id,$id);
        try {
            $this->throwWhenModelEmpty($category);
            return new PostCategoryResource($category);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function destroy($post_id,$id)
    {
        $category = PostCategory::findByIdAndPostId($post_id,$id);
        try {
            $this->throwWhenModelEmpty($category);
            $category->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function destroy_all($post_id)
    {
        $category = PostCategory::findByPostId($post_id);
        try {
            $this->throwWhenModelEmpty($category);
            $category->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    private function params($request,$addtional = [])
    {
        $rules = $this->getRules($request);
        $this->validate($request, $rules);
        $params = $request->all();
        $params['post_id'] = $addtional['post_id'];
        return $params;
    }

    private function getRules($request)
    {
        return $this->rules;
    }

}
