<?php

namespace App\Components;

use Exception;

trait Api{


    private function tokenResponse($token)
    {
        return response()->json([
            'token' => $token
        ], 200);
    } 

    private function apiResponse($message, $status = 200)
    {
        return response()->json([
            'message' => $message
        ], $status);
    }

    private function throwWhenModelEmpty($model)
    {
        if (is_null($model)){
            throw new Exception('DATA_SOURCE_NOT_FOUND');
        }elseif($model->count() == 0){
            throw new Exception('DATA_SOURCE_NOT_FOUND');
        }
    }
}