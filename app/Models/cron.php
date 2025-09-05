<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cron extends Model
{
    protected $table = 'cron';
    protected $fillable = [
        'name',
        'last_cron'
    ];

    protected $casts = [
        'last_cron' => 'datetime',
    ];
}
