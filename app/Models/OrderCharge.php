<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderCharge extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'charge_name',
        'charge_type', // 0= No, 1=Addition, 2=Subtraction, 3=Multiplication, 4=Division, 5=Modulus
        'charge_value',
        'status', // 1=Active, 2=Inactive, 3=Deleted
        'add_by',
        'updated_by',
    ];

    // Relationships
    public function addBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
