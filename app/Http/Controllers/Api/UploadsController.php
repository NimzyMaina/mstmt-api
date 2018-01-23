<?php

namespace App\Http\Controllers\Api;

use App\Statement;
use App\Transformers\StatementsTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function upload(Request $request)
    {
        Log::error($request->all());
        if(!$path = $request->file->store('public/uploads'))
        {
            return $this->respond("Unable to upload file",400);
        }

        $user = $this->auth->user();
        $st = Statement::create([
            'user_id' => $user->id,
            'path' => $path,
            'description' => $request->description
        ]);

        if(!$st){
            return $this->respond("Unable to upload file",400);
        }

        return $this->respond('Upload Successful');
    }

    public function statements(Request $request)
    {
        $user = $this->auth->user();

        $statements = $user->statements;

        if(count($statements) == 0)
        {
            return $this->respond('No statements for this user',404);
        }

        return $this->response->collection($statements,new StatementsTransformer)->setStatusCode(200);

    }
}
