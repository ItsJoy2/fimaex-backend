<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_transfer',
        'max_transfer',
        'status',
    ];
}
