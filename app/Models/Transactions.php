<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 */
class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['transaction_id', 'user_id', 'amount', 'remark','type','status','details','charge'];

    public static function generateTransactionId(): string
    {
        do {
            $transaction_id = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 13));
        } while (self::where('transaction_id', $transaction_id)->exists());

        return $transaction_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
