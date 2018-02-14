<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['result_code','result_desc','amount','mpesa_receipt_number','balance',
        'transaction_date','phone_number','status','merchant_request_id','checkout_request_id'];

    public function description()
    {
        return $this->belongsTo(Transaction::class,'merchant_request_id','merchant_request_id');
    }
}
