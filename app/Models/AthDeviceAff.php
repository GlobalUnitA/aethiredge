<?php

namespace App\Models;

use App\Models\User;
use App\Models\AthUser;
use App\Models\AthDevice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AthDeviceAff extends Model
{
    use HasFactory;

    protected $table = 'ath_device_aff';

    protected $fillable = [
        'device_id',
        'user_id',
        'aff_user_id',
        'aff_user_level',
        'is_ref',
        'bonus',
        'part_usdt',
        'created_at',
        'updated_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function athDevice()
    {
        return $this->belongsTo(AthDevice::class, 'device_id');
    }

}
