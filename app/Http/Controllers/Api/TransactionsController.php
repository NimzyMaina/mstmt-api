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

        $transactions = $user->descriptions()->with('transaction')->get();

        dd($transactions);
    }
}
