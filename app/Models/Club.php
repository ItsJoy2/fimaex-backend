<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name',
        'image',
        'required_refers',
        'bonus_percent',
        'incentive',
        'status'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_club');
    }
       public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
