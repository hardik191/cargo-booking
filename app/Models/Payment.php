<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Payment extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'user_id',
        'order_amount',
        'payment_document',
        'payment_mode',
        'payment_status',
        'payment_date',
        'add_by',
        'updated_by',
    ];

    protected $casts = [
        'order_amount' => 'decimal:2',
        'payment_mode' => 'integer',
        'payment_status' => 'integer',
        'payment_date' => 'datetime',
    ];

    /**
     * Define relationships
     */
    public function orderId()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function userId()
    {
        return $this->belongsTo(User::class, 'user_id');
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
