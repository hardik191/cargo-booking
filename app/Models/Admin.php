<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use \OwenIt\Auditing\Auditable;

    // protected $guard_name = 'admin';
    
    protected $fillable = [
        'name',
        'email',
        'user_image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
