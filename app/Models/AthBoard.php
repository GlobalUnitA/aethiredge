<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AthBoard extends Model
{
    use HasFactory;

    protected $table = 'ath_board';
    
    protected $fillable = [
        'board_code',
        'board_name',
        'is_comment',
        'acess_level'
    ];

}
