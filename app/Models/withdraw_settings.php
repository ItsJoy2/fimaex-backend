<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class withdraw_settings extends Model
{
    protected $table = 'withdraw_settings';
    protected $fillable = ['min_withdraw','max_withdraw','charge','status'];
}
