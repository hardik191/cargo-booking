<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderChargeDetail extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'order_charge_details';

    protected $fillable = [
        'order_id',
        'charge_id',
        'charge_type',
        'charge_value',
        'add_by',
        'updated_by',
    ];

    protected $casts = [
        'charge_value' => 'decimal:2',
        'charge_type' => 'integer',
    ];

    /**
     * Define relationships
     */
    public function orderId()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function chargeId()
    {
        return $this->belongsTo(OrderCharge::class, 'charge_id');
    }

    public function addBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
