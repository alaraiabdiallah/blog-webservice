<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Hash;
class TestController extends Controller
{
    public function index()
    {
        $model = Post::cachedPaginate();
        return PostResource::collection($model);

    }

    public function authtest()
    {
        $user = User::where('email', 'admin@example.com')->first();
        dd($user->JWTEncode());
    }
}
