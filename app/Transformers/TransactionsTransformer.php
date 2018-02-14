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
            'mpesa_receipt_number' => $d->transaction()->mpesa_receipt_number,
            'amount' => $d->transaction()->amount,
            'description' => $d->description,
            'status' => $d->transaction()->status,
            'created_at' =>(string)$d->created_at
        ];
    }

}