<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{

    use Api;

    private $rules = [
        'content' => "required"
    ];

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
    }

    public function index($post_id)
    {
        $model = Comment::findByPostId($post_id)->paginate();
        return CommentResource::collection($model);
    }

    public function store(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        try {
            $this->throwWhenModelEmpty($post);
            $params = $this->params($request, ['post_id' => $post_id]);
            return new CommentResource(Comment::create($params));
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function show($post_id,$id)
    {
        $comment = Comment::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($comment);
            return new CommentResource($comment);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function update(Request $request, $post_id, $id)
    {

        $comment = Comment::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($comment);
            $comment->update($this->params($request, ['post_id' => $post_id]));
            return new CommentResource($comment);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function destroy($post_id, $id)
    {
        $comment = Comment::findByIdAndPostId($post_id, $id);
        try {
            $this->throwWhenModelEmpty($comment);
            $comment->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function destroy_all($post_id)
    {
        $comment = Comment::findByPostId($post_id);
        try {
            $this->throwWhenModelEmpty($comment);
            $comment->delete();
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
        if ($request->isMethod('patch')) {
            $params = $request->only('content');
        }else{
            $params = $request->all();
            $params['post_id'] = $addtional['post_id'];
        }
        return $params;
    }

    private function getRules($request)
    {
        if ($request->isMethod('patch')) {
            $this->rules = [
                'content' => "required"
            ];
        }
        return $this->rules;
    }

}
