<?php

namespace App\Http\Controllers;

use App\Post;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\PostResource;

class PostController extends Controller
{

    use Api;

    private $rules = [
        'title' => "required|max:100",
        'slug' => "alpha_dash|max:100",
        'content' => "required"
    ];

    public function index()
    {
        $model = Post::with(['categories', 'tags'])->paginate();
        return PostResource::collection($model);
    }

    public function store(Request $request)
    {
        $params = $this->params($request);
        return new PostResource(Post::create($params));
    }

    public function show($id)
    {
        $post = Post::find($id);
        try {
            $this->throwWhenModelEmpty($post);
            return PostResource::collection($post);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function update(Request $request, $id)
    {

        $post = Post::find($id);
        try {
            $this->throwWhenModelEmpty($post);
            $Post->update($this->params($request));
            return new PostResource($post);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function destroy($id)
    {
        $post = Post::find($id);
        try {
            $this->throwWhenModelEmpty($post);
            $post->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(),404);
        }
    }

    private function params($request)
    {
        $this->validate($request, $this->rules);
        $params = $request->all();
        return $params;
    }

}
