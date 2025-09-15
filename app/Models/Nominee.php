<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date_of_birth',
        'national_id',
        'relationship',
        'contact_number',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
