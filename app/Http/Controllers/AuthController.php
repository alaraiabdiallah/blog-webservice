<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Components\Api;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use Api;

    private $rules = [
        'email' => "required|email",
        'password' => "required",
    ];

    
    public function authenticate(Request $request)
    {
        $this->params($request);

        $user = User::where('email', $request->email)->first();
        
        try {
            $this->whenEmailDoesntExist($user);
            $this->whenInvalidPassword($request, $user);
            return $this->tokenResponse($user->JWTEncode());
        }catch( Exception $e){
            return $this->apiResponse($e->getMessage(),400);
        }
    }

    private function whenEmailDoesntExist($user)
    {
        if(is_null($user))
            throw new Exception('Email does not exist');
    }

    private function whenInvalidPassword($request, $user)
    {
        if (!Hash::check($request->password, $user->password))
            throw new Exception('Email or password is wrong.');
    }

    private function params($request)
    {
        $rules = $this->getRules($request);
        $this->validate($request, $rules);
        return $request->all();
    }

    private function getRules($request)
    {
        return $this->rules;
    }

}
