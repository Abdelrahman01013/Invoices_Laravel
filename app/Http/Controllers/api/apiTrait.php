<?php

namespace App\Http\Controllers\Api;

trait ApiTrait
{
    public function apiResponse($data = null, $status = null, $msg = null)
    {
        $arr = [
            'data' => $data,
            'message' => $msg,
            'status' => $status,


        ];
        return response($arr, $status);
    }
}
