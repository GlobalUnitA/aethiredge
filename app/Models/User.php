<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

   
    protected $fillable = [
        'name',      
        'account',      
        'password',  
    ];

    
    protected $hidden = [
        'password',   
        'remember_token', 
    ];

    public function username()
    {
        return 'account';
    }
   
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function athUser()
    {
        return $this->hasOne(AthUser::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}