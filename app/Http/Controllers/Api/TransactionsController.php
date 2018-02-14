<?php

namespace App\Http\Controllers\Api;

use App\Transformers\TransactionsTransformer;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function index(Request $request)
    {
        $user = $this->auth->user();

        $transactions = $user->descriptions()->with('transaction')->get();

        if(count($transactions) == 0 )
        {
            return $this->respond('No Transactions could be found.',404);
        }

        return $this->response->collection($transactions,new TransactionsTransformer)->setStatusCode(200);
    }
}
