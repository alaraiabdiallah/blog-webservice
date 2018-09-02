<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Components\Api;

class ApiController extends Controller
{

    use Api;

    public function index()
    {
        return $this->resource::collection($this->model->paginate());
    }

    public function store(Request $request)
    {
        $params = $this->params($request);
        return new $this->resource($this->model->create($params));
    }

    public function show($id)
    {
        $model = $this->model->find($id);
        try {
            $this->throwWhenModelEmpty($model);
            return new $this->resource($model);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }

    public function update(Request $request, $id)
    {

        $model = $this->model->find($id);
        try {
            $this->throwWhenModelEmpty($model);
            $model->update($this->params($request));
            return new $this->resource($model);
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }

    }

    public function destroy($id)
    {
        $model = $this->model->find($id);
        try {
            $this->throwWhenModelEmpty($model);
            $model->delete();
            return $this->apiResponse('DELETE_SUCCESS');
        } catch (Exception $e) {
            return $this->apiResponse($e->getMessage(), 404);
        }
    }


}
