<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use \OwenIt\Auditing\Auditable;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'email',
        'country_code',
        'phone_no',
        'user_image',
        'password',
        'status', // 1 = active, 1 = inactive, 3 = deleted
        'is_user_allowed_login', // 1= No, 2= Yes default(2)
        'is_user_exit', // 1= No, 2= Yes
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
