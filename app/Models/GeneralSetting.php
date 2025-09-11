<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
protected $table = 'general_settings';

    protected $fillable = [
        'app_name',
        'logo',
        'favicon',
        'total_founder',
        'available_founder_slot',
    ];
}
