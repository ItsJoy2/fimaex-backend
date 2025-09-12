<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $fillable = ['user_id', 'amount', 'transaction_id','status','wallet'];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
