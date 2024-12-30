<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AthStakingTest extends Model
{
    use HasFactory;

    protected $table = 'ath_staking_test';
    
    protected $fillable = [
        'user_id',
        'staking_id',
        'aff_user_id',
        'daily',
        'paid',
        'earn',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function athStaking()
    {
        return $this->belongsTo(AthStaking::class, 'staking_id');
    }
   
}
