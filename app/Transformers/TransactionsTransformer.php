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
        return [
            'id' => $d->id,
            'mpesa_receipt_number' => isset($d->transaction()[0]->mpesa_receipt_number) ? $d->transaction()[0]->mpesa_receipt_number:"N/A",
            'amount' => isset($d->transaction()[0]->amount) ? $d->transaction()[0]->amount : 0,
            'description' => $d->description,
            'status' => isset($d->transaction()[0]->status) ? $d->transaction()[0]->status:"N/A",
            'created_at' =>(string)$d->created_at
        ];
    }

}