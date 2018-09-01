<?php

namespace App\Http\Controllers;

use App\PostTag;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\PostTagResource;

class PostTagController extends Controller
{

    use Api;

    private $rules = [
        'tag_id' => "required|exists:tags,id"
    ];

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
    }

    public function index($post_id)
    {
        $model = PostTag::findByPostId($post_id)->get();
        return PostTagResource::collection($model);
    }


    public function store(Request $request, $post_id)
    {
        $params = $this->params($request, ['post_id' => $post_id]);
        return new PostTagResource(PostTag::create($params));
    }

    public function show($post_id, $id)
    {
        $tag = PostTag::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($tag);
            return new PostTagResource($tag);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function destroy($post_id, $id)
    {
        $tag = PostTag::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($tag);
            $tag->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function destroy_all($post_id)
    {
        $tag = PostTag::findByPostId($post_id);
        try {
            $this->throwWhenModelEmpty($tag);
            $tag->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    private function params($request, $addtional = [])
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
