<?php
/**
 * Created by PhpStorm.
 * User: Maina
 * Date: 2/14/2018
 * Time: 4:27 PM
 */

namespace App\Transformers;


use App\Description;
use League\Fractal\TransformerAbstract;

class TransactionsTransformer extends TransformerAbstract
{

    public function transform(Description $d)
    {
        $transaction = $d->transaction;
        return [
            'id' => $d->id,
            'mpesa_receipt_number' => isset($transaction->mpesa_receipt_number) ? $transaction->mpesa_receipt_number:"N/A",
            'amount' => isset($transaction->amount) ? number_format($transaction->amount,2) : 0,
            'description' => $d->description,
            'status' => isset($transaction->status) ? $transaction->status:"N/A",
            'created_at' =>(string)$d->created_at
        ];
    }

}