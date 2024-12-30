<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AthUser extends Model
{
    use HasFactory;

    protected $table = 'ath_user';
    protected $fillable = [
        'user_id',
        'parent_id',
        'level',
        'email',
        'email_verified_at',
        'phone',
        'meta_uid',
        'pcc',
        'post_code',
        'address',
        'detail_address',
        'memo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->hasOne(AthUser::class, 'user_id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AthUser::class, 'parent_id', 'user_id');
    }
}
