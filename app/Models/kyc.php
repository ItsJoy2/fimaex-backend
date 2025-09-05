<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static latest()
 */
class kyc extends Model
{
    protected $table = 'kyc';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'name',
        'nid_front',
        'details',
        'selfie',
        'status',
    ];
}
