<?php

namespace App\Http\Controllers\Api;

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

        $transactions = $user->transactions()->with('description');

        dd($transactions);
    }
}
