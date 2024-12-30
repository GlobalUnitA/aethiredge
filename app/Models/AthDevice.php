<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AthDevice extends Model
{
    use HasFactory;

    protected $table = 'ath_device';
    
    protected $fillable = [
        'user_id',
        'status',
        'ea',
        'usdt',
        'txid',
        'image_urls',
        'memo',
        'created_at',
        'updated_at'
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
