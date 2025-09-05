<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'package';
    protected $fillable = ['name', 'amount', 'refer_bonus', 'active'];
}
