<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Founder extends Model
{
    protected $table = 'founders';
    protected $fillable = [
        'user_id',
        'package_name',
        'package_id',
        'investment',
        'status',
    ];

    public function scopeRunning($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 0);
    }

    public function scopeExpired($query)
    {
        return $query->where('next_cron', '<', now());
    }
    public function package()
{
    return $this->belongsTo(Package::class, 'package_id');
}
}
