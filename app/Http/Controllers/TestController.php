<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\PostResource;
class TestController extends Controller
{
    public function index()
    {
        $model = Post::cachedPaginate();
        return PostResource::collection($model);

    }
}
