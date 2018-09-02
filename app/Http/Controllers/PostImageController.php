<?php

namespace App\Http\Controllers;

use App\PostImage;
use App\Post;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\PostImageResource;

class PostImageController extends Controller
{

    use Api;

    private $rules = [
        'url' => "required|url"
    ];

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
    }

    public function index($post_id)
    {
        $model = PostImage::findByPostId($post_id)->paginate();
        return PostImageResource::collection($model);
    }

    public function store(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        try {
            $this->throwWhenModelEmpty($post);
            $params = $this->params($request, ['post_id' => $post_id]);
            return new PostImageResource(PostImage::create($params));
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function show($post_id, $id)
    {
        $image = PostImage::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($image);
            return new PostImageResource($image);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function update(Request $request, $post_id, $id)
    {

        $image = PostImage::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($image);
            $image->update($this->params($request, ['post_id' => $post_id]));
            return new PostImageResource($image);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function destroy($post_id, $id)
    {
        $image = PostImage::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($image);
            $image->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function destroy_all($post_id)
    {
        $image = PostImage::findByPostId($post_id);
        try {
            $this->throwWhenModelEmpty($image);
            $image->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    private function params($request, $addtional = [])
    {
        $rules = $this->getRules($request);
        $this->validate($request, $rules);
        $params = [];
        $params = $request->all();
        $params['post_id'] = $addtional['post_id'];
        return $params;
    }

    private function getRules($request)
    {
        if ($request->isMethod('patch')) {
            $this->rules = [
                'content' => "url"
            ];
        }
        return $this->rules;
    }

}
