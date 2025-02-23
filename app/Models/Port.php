<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Port extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'port_name',
        'location',
        'status', // 1 For Active,2 For Inactive,3 For Delete
        'add_by',
        'updated_by'
    ];

    public function addBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
