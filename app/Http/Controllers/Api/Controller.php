<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    public function respond($message,$code = 200)
    {
        return response([
            'status_code' => $code,
            'message' => $message
        ])->setStatusCode($code);
    }

    public function val($payload,$rules,$message = 'Validation failed')
    {
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($message, $validator->errors());
        }
        return $payload;
    }
}
