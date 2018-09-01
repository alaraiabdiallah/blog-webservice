<?php

namespace App\Http\Controllers;

use App\Tag;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use App\Http\Resources\TagResource;
class TagsController extends Controller
{

    use Api;

    private $rules = [
        'name' => "required|max:20",
        'slug' => "required|alpha_dash|max:20",
    ];

    public function __construct()
    {
        $this->middleware('jwtauth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return TagResource::collection(Tag::paginate());
    }

    public function store(Request $request)
    {
        $params = $this->params($request);
        return new TagResource(Tag::create($params));
    }

    public function show($id)
    {
        $tag = Tag::find($id);
        try{
            $this->throwWhenModelEmpty($tag);
            return new TagResource($tag);
        }catch(Exception $e){
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function update(Request $request,$id)
    {

        $tag = Tag::find($id);
        try {
            $this->throwWhenModelEmpty($tag);
            $tag->update($this->params($request));
            return new TagResource($tag);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
        
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
        try {
            $this->throwWhenModelEmpty($tag);
            $tag->delete();
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
            $this->rules = [
                'name' => "max:20",
                'slug' => "alpha_dash|max:20",
            ];
        }
        return $this->rules;
    }

}
