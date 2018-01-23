<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $fillable = ['user_id','description','path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
