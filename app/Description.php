<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $fillable = ['merchant_request_id','checkout_request_id','email','description'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'merchant_request_id','merchant_request_id');
    }
}
