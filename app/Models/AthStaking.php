<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AthStaking extends Model
{
    use HasFactory;

    protected $table = 'ath_staking';
    
    protected $fillable = [
        'user_id',
        'status',
        'ea',
        'bundle',
        'ath',
        'txid',
        'image_urls',
        'memo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlsAttribute($value)
    {
        return json_decode($value, true);
    }
}
